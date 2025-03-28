<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    /**
     * Получает и форматирует задачи для текущего пользователя.
     *
     * @return Collection
     */
    public function getUserTasks(): Collection
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('completed', false)
            ->orderBy('due_date', 'asc')
            ->get();

        return $tasks->map(function ($task) {
            if ($task->due_date) {
                $dueDate = Carbon::parse($task->due_date);

                if ($dueDate->isToday()) {
                    $task->formatted_due_date = 'Сегодня';
                } elseif ($dueDate->isTomorrow()) {
                    $task->formatted_due_date = 'Завтра надо сделать';
                } elseif ($dueDate->isYesterday()) {
                    $task->formatted_due_date = 'Вчера надо было';
                } else {
                    $task->formatted_due_date = $dueDate->translatedFormat('d F Y (l)');
                }
            } else {
                $task->formatted_due_date = 'Без ограничений';
            }

            return $task;
        });
    }

    /**
     * Удаление задачи.
     *
     * @param int $taskId
     * @return string|null
     */
    public function deleteTask(int $taskId): ?string
    {
        $task = Task::find($taskId);

        if (!$task) {
            return null;
        }

        $title = $task->title;
        $task->delete();

        return "Задача '{$title}' удалена!";
    }

    /**
     * Отметить задачу как выполненную.
     *
     * @param int $taskId
     * @return string|null
     */
    public function markCompleted(int $taskId): ?string
    {
        $task = Task::find($taskId);

        if (!$task) {
            return null;
        }

        $task->completed = true;
        $task->save();

        return "Задача '{$task->title}' отмечена как выполненная!";
    }
}
