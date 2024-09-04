<?php

namespace App\Services;

interface QrServiceInterface {
    public function generateQr(string $data): string;
}