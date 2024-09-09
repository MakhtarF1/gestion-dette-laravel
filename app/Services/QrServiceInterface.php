<?php

namespace App\Services;

interface QrServiceInterface
{
    /**
     * Generate a QR code.
     *
     * @param string $data
     * @return string The path to the generated QR code image.
     */
    public function generateQrCode(string $data): string;
    
}