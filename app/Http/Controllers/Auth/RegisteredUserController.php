<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Http\Controllers\Controller;
use App\Http\Controllers\Http\Requests\StoreUserRequest;
use App\Models\Address;
use App\Models\AddressType;
use App\Models\Company;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use App\Service\DomainService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request): \Illuminate\Http\JsonResponse
    {
        // create address first, so if something went wrong, user is not created
        $addressPrimary = new Address([
            'country' => $request->address['countryCode'],
            'city' => $request->address['city'],
            'street' => $request->address['street'],
            'house_number' => $request->address['house_number'],
            'orientation_number' => $request->address['orientation_number'],
            'postal_code' => $request->address['postal_code'],
        ]);

        DB::beginTransaction();

        $user = new User([
            'email' => $request->email,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
            'phone_prefix' => $request->phone_prefix,
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'health_insurance_company' => $request->health_insurance_company,
            'personal_number_part_1' => $request->personal_number['part_1'],
            'personal_number_part_2' => $request->personal_number['part_2'],
            'email_verified_at' => now(),
        ]);
        $user->save();

        $domainName = DomainService::getAppDomain();
        $company = Company::where('domain', $domainName)->first();

        if ($company) {
            $user->companies()->attach($company->id); // Attach after saving the user
        } else {
            // Handle the case where no company is found for the domain
            DB::rollBack();
            return response()->json(['error' => 'No company found for this domain: ' . $domainName], 422);
        }

        $addressTypePrimary = AddressType::where('type_name', 'primary')->first();

        $addressPrimary->user()->associate($user);
        $addressPrimary->addressType()->associate($addressTypePrimary);
        $addressPrimary->save();

        $addressSecondary = null;
        // TODO: Add the second address too.
        if (isset($request->address_secondary['city'])
            && isset($request->address_secondary['street'])
            && isset($request->address_secondary['house_number'])
            && isset($request->address_secondary['orientation_number'])
            && isset($request->address_secondary['postal_code'])) {

            $addressSecondary = new Address([
                'country' => $request->address_secondary['countryCode'],
                'city' => $request->address_secondary['city'],
                'street' => $request->address_secondary['street'],
                'house_number' => $request->address_secondary['house_number'],
                'orientation_number' => $request->address_secondary['orientation_number'],
                'postal_code' => $request->address_secondary['postal_code'],
            ]);

            $addressTypeSecondary = AddressType::where('type_name', 'secondary')->first();

            $addressSecondary->user()->associate($user);
            $addressSecondary->addressType()->associate($addressTypeSecondary);
            $addressSecondary->save();
        }

        if ($request->bank_account['allow_sending_salary']) {
            $user->bankAccount()->create([
                'prefix' => $request->bank_account['prefix'],
                'account_number' => $request->bank_account['account_number'],
                'bank_number' => $request->bank_account['bank_number'],
                'allow_sending_salary' => $request->bank_account['allow_sending_salary'],
            ]);
        }

        if($request->img_path != null and $request->img_path != ''
            and $request->img_path != 'null') {
            // find the photo
            $temporaryImgPath = $request->img_path;
            $filename = 'profile_' . $user->id . '.' . 'jpg';
            $path = $domainName . '/' . $user->id . '/profile_images/' . $filename;

            Storage::disk('s3')->move($temporaryImgPath, $path);

            // associate profile with photo
            $user->update(['profile_photo_path' => $path]);
        }

        DB::commit();
        event(new Registered($user));
        $user->notify(new WelcomeEmailNotification());

        Auth::login($user);

        return response()->json([
                'user' => $user,
                'address_primary' => $addressPrimary,
                'address_secondary' => $addressSecondary
            ]
        );
    }
}
