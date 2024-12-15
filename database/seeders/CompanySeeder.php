<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Schema::hasTable('companies')) {
            $companyWay4 = Company::create([
                'email' => 'office@way4solution.cz',
                'name' => 'Way4Solution',
                'domain' => 'way4'
            ]);
        } else {
            $companyWay4 = Company::where('email', 'office@way4solution.cz')->first();
        }

        $way4emails = [
            'patmull@seznam.cz',
            'patmull@centrum.cz',
            'office@way4solution.cz',
            'mainmarshal@gmail.com',
            'kristyna.filipczykova@seznam.cz',
            'admin@way4solution.cz'
        ];


    }
}
