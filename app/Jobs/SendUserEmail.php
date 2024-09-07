<?php

namespace App\Jobs;

use App\Mail\UserCreatedMail;
use App\Services\PdfService;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $pdfService;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
        // Inject PdfService from the service container
        $this->pdfService = app(PdfService::class);
    }

    public function handle()
    {
        try {
            $user = User::findOrFail($this->userId);

            // Ensure PdfService is available
            if (!$this->pdfService) {
                throw new \Exception('PdfService not available.');
            }

            $pdfContent = $this->pdfService->generatePdf($user);

            Mail::to($user->email)
                ->send(new UserCreatedMail($user, $this->pdfService));

            Log::info('Email sent successfully to:', ['email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('Failed to send email:', ['error' => $e->getMessage()]);
        }
    }
}
