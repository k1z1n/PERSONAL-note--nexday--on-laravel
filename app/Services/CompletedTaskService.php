<?php

namespace App\Services;


use App\Contracts\Services\CompletedTaskServiceInterface;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class CompletedTaskService implements CompletedTaskServiceInterface
{
    /**
     * Получает и группирует выполненные задачи для текущего пользователя с возможностью пагинации.
     *
     * @param int $userId
     * @param int|null $limit
     * @return Collection
     */
    public function getGroupedCompletedTasks(int $userId, ?int $limit = null): Collection
    {
        $query = Task::completed()
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        App::setLocale('ru'); // Устанавливаем русскую локаль
        Carbon::setLocale('ru');

        $completedTasks = $query->get()->map(function ($task) {
            $task->formatted_completed_date = Carbon::parse($task->updated_at)
                    ->translatedFormat('d F Y') . ' в ' . Carbon::parse($task->updated_at)->format('H:i');
            return $task;
        });

        return $completedTasks->groupBy(fn ($task) => Carbon::parse($task->updated_at)->translatedFormat('d F Y'));
    }
}
