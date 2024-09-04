<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UploadService implements UploadServiceInterface
{
    public function uploadFile(UploadedFile $file, $directory)
    {
        // Create a unique filename for the uploaded file
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the file in the specified directory within the 'public' disk
        $path = $file->storeAs($directory, $filename, 'public');

        // Return the file path, stripping 'public/' for simplicity
        return str_replace('public/', '', $path);
    }
}
