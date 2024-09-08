<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface UploadServiceInterface
{
    public function uploadFile(UploadedFile $file, $folder = 'user_photos');
}
