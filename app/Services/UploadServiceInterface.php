<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;

interface UploadServiceInterface
{
    /**
     * Upload a file and store it in the specified directory.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string The path to the stored file
     */
   public function uploadFile(UploadedFile $file, $directory);
   

}
