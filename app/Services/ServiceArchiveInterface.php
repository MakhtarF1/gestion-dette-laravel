<?php

namespace App\Services;

use App\Models\Dette;

interface ServiceArchiveInterface
{
    public function archiveDette(Dette $dette);
}
