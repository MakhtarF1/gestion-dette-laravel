<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use Cloudinary\Cloudinary;
use Illuminate\Support\Facades\Log;
use Cloudinary\Transformation\Image;

class UploadUserPhoto implements ShouldQueue
{
    use Dispatchable;

    protected $filePath;
    protected $directory;
    protected $userId;

    public function __construct(string $filePath, string $directory, int $userId)
    {
        $this->filePath = $filePath;
        $this->directory = $directory;
        $this->userId = $userId;
    }

    public function handle()
    {
        // Initialize Cloudinary
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        try {
            $uploadResult = $cloudinary->uploadApi()->upload($this->filePath, [
                'folder' => $this->directory,
            ]);

            // Retrieve the URL of the photo
            $photoPath = $uploadResult['secure_url'];

            // Update the user with the photo URL
            $user = User::find($this->userId);
            if ($user) {
                $user->photo = $photoPath;
                $user->save();
            }

        } catch (\Exception $e) {
            // Handle errors (e.g., log the error or send a notification)
            Log::error('Cloudinary upload error: ' . $e->getMessage());
        }
    }
}
