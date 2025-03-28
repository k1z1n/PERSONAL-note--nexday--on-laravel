<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface CompletedTaskServiceInterface
{
    public function getGroupedCompletedTasks(int $userId, ?int $limit = null):Collection;
}
