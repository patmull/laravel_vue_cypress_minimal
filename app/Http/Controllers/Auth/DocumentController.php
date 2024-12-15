<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Http\Controllers\Controller;
use App\Http\Controllers\Http\Resources\DocumentResource;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\User;
use App\Service\DomainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $documents = Document::with('user')->get();
        return DocumentResource::collection($documents);
    }

    public function getDocumentByUserId(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $request->validate([
            'user_id' => 'required'
        ]);
        $userId = $request->user_id;
        $documents = Document::where('user_id', $userId)->get();
        return DocumentResource::collection($documents);
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'user_id' => 'required',
            'file' => 'required|mimes:pdf|max:20000',
            'id_document' => 'required_if:upload_type,employee_upload',
        ]);
        $userIdToFind = $request->user_id;
        $userFound = User::findOrFail($userIdToFind);

        $documentTypeIdToFind = $request->document_type_id;
        $documentTypeFound = DocumentType::findOrFail($documentTypeIdToFind);

        $file = $request->file('file');

        $filename = $file->getClientOriginalName() . '_' . uniqid() . '.' . $file->extension();
        $domainName = DomainService::getAppDomain();
        $path = $domainName . '/' . $userFound->id . '/documents/' . $filename;

        $uploadType = $request->route()->getName();

        if ($uploadType === 'employer_upload') {
            $document = new Document([
                'file_path_employer' => $path,
                'file_path_employee' => null,
                'file_name_employer_original' => $file->getClientOriginalName()
            ]);
            $document->user()->associate($userFound);
            $document->documentType()->associate($documentTypeFound);
        } elseif ($uploadType === 'employee_upload') {
            $document = Document::where('user_id', $userFound->id)
                ->where('id', $request->id_document)
                ->whereNotNull('file_path_employer')
                ->firstOrFail();
            $document->file_path_employee = $path;
        } else {
            return response()->json(['message' => 'Invalid upload type'], 400);
        }

        $document->save();

        $domainName = DomainService::getAppDomain();
        $documentPath = $domainName . '/' . $userFound->id . '/documents';

        try {
            Storage::disk('s3')->putFileAs(
                $documentPath,
                $file,
                $filename
            );
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        return response()->json($document, 200);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $document = Document::findOrFail($id);

            // Delete file from S3
            if ($document->file_path_employer) {
                Storage::disk('s3')->delete($document->file_path_employer);
            }
            if ($document->file_path_employee) {
                Storage::disk('s3')->delete($document->file_path_employee);
            }

            // Delete the document record
            $document->delete();

            DB::commit();

            return response()->json(['message' => 'Document deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while deleting the document.'], 500);
        }
    }
}
