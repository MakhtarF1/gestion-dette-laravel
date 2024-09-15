<?php

namespace App\Jobs;

use App\Models\Demande;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\DemandeSoumiseNotification;

class NotifyBoutiquierJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $demande;

    public function __construct(Demande $demande)
    {
        $this->demande = $demande;
    }

    public function handle()
    {
        $boutiquiers = User::where('role', 'boutiquier')->get();

        foreach ($boutiquiers as $boutiquier) {
            $boutiquier->notify(new DemandeSoumiseNotification($this->demande));
        }
    }
}
