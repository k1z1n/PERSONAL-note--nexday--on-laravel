<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompletedTasksController extends Controller
{
    public function index()
    {
        // Получаем выполненные задачи только для текущего пользователя
        $completedTasks = Task::completed()
            ->where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($task) {
                $task->formatted_completed_date = Carbon::parse($task->updated_at)
                        ->translatedFormat('d F Y') . ' в ' . Carbon::parse($task->updated_at)->format('H:i');
                return $task;
            });

        // Получаем сегодняшнюю дату для сравнения
        $today = Carbon::today()->translatedFormat('d F Y');

        // Группируем задачи по дате: если дата совпадает с сегодняшней – группа "Сегодня",
        // иначе по реальной дате
        $groupedTasks = $completedTasks->groupBy(function ($task) use ($today) {
            $taskDate = Carbon::parse($task->updated_at)->translatedFormat('d F Y');
            return $taskDate === $today ? 'Сегодня' : $taskDate;
        });

        return view('pages.completed-tasks', compact('groupedTasks', 'today'));
    }
}
