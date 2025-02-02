<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CompletedTasks extends Component
{
    use WithPagination;

    public $datesPerPage = 10; // Количество загружаемых дат за раз
    public $loadedDates; // Загруженные даты
    public $allDatesLoaded = false; // Флаг загрузки всех данных

    public function mount()
    {
        $this->loadedDates = collect();
        $this->loadMoreDates();
    }

    public function loadMoreDates()
    {
        if ($this->allDatesLoaded) return;

        // Фильтруем задачи по текущему пользователю
        $completedTasks = Task::completed()
            ->where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($task) {
                $task->formatted_completed_date = Carbon::parse($task->updated_at)
                        ->translatedFormat('d F Y') . ' в ' . Carbon::parse($task->updated_at)->format('H:i');
                return $task;
            });

        // Группируем задачи по дате
        $groupedTasks = $completedTasks->groupBy(function ($task) {
            return Carbon::parse($task->updated_at)->translatedFormat('d F Y');
        });

        // Получаем новые даты, которые ещё не загружены
        $newDates = $groupedTasks->keys()->diff($this->loadedDates->keys())->take($this->datesPerPage);

        if ($newDates->isEmpty()) {
            $this->allDatesLoaded = true; // Все даты загружены
            return;
        }

        // Добавляем новые даты в загруженные
        foreach ($newDates as $date) {
            $this->loadedDates[$date] = $groupedTasks[$date];
        }
    }

    public function render()
    {
        return view('livewire.completed-tasks', [
            'groupedTasks' => $this->loadedDates
        ]);
    }
}
