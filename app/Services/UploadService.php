<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;

class UploadService implements UploadServiceInterface
{
    protected $cloudinary;

    public function __construct()
    {
        // Configuration de Cloudinary avec les variables d'environnement
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);
    }

    public function uploadFile(UploadedFile $file, $directory)
    {
        try {
            // Uploader le fichier sur Cloudinary
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => $directory,
                'public_id' => uniqid(), // Générer un ID unique
            ]);

            // Retourner l'URL sécurisée de l'image
            return $result['secure_url'];
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de l\'upload : ' . $e->getMessage());
        }
    }
}
