<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArchiveDetteServiceInterface;

class ArchiveDettesCommand extends Command
{
    protected $signature = 'dettes:archive';
    protected $description = 'Archiver les dettes payées';

    protected $archiveService;

    public function __construct(ArchiveDetteServiceInterface $archiveService)
    {
        parent::__construct();
        $this->archiveService = $archiveService;
    }

    public function handle()
    {
        $this->archiveService->archivePaidDettes();
        $this->info('L\'archivage des dettes a été effectué.');
    }
}
