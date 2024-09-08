<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class UploadService implements UploadServiceInterface
{
    protected $cloudinary;

    public function __construct()
    {
        // Configuration via CLOUDINARY_URL (via le fichier .env)
        $this->cloudinary = new Cloudinary(env('CLOUDINARY_URL'));
    }

    /**
     * Upload un fichier vers Cloudinary.
     *
     * @param UploadedFile $file Instance de UploadedFile à uploader
     * @param string $folder Dossier sur Cloudinary
     * @return string URL du fichier uploadé
     */
    public function uploadFile(UploadedFile $file, $folder = 'user_photos')
    {
        try {
            // Uploader le fichier sur Cloudinary
            $result = (new UploadApi())->upload($file->getRealPath(), [
                'folder' => $folder,  // Dossier sur Cloudinary
                'public_id' => uniqid(), // Générer un ID unique pour chaque fichier
                'overwrite' => true,
            ]);

            // Retourner l'URL sécurisée
            return $result['secure_url'];
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'upload sur Cloudinary : ' . $e->getMessage());
            throw new \Exception('Erreur lors de l\'upload sur Cloudinary : ' . $e->getMessage());
        }
    }
}
