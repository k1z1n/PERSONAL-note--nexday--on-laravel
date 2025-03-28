<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;

class TaskDetailsModal extends Component
{
    public bool $showModal = false;
    public $task;
    public ?string $notification = null;
    public $newDueDate;

    protected $listeners = ['showTaskDetails' => 'loadTask'];

    public function loadTask($taskId): void
    {
        $this->task = Task::findOrFail($taskId);
        $this->updateFormattedDueDate();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->reset(['showModal', 'task', 'newDueDate']);
    }

    public function closeModalIfOutside(): void
    {
        $this->closeModal();
    }

    /**
     * Универсальный метод для изменения даты.
     *
     * @param int $taskId
     * @param int $days Количество дней (+1 – завтра, 0 – сегодня, -1 – вчера)
     */
    public function changeDueDate(int $taskId, int $days): void
    {
        $task = Task::findOrFail($taskId);
        $task->due_date = Carbon::today()->addDays($days)->toDateString();
        $task->save();

        $this->task->due_date = $task->due_date;
        $this->updateFormattedDueDate();
        $this->dispatch('taskUpdated');
        $this->closeModal();
    }

    /**
     * Переносит задачу на выбранную дату из input.
     */
    public function moveToDate($taskId): void
    {
        $this->validate([
            'newDueDate' => 'required|date'
        ]);

        $task = Task::findOrFail($taskId);
        $task->due_date = $this->newDueDate;
        $task->save();

        $this->task->due_date = $task->due_date;
        $this->updateFormattedDueDate();
        $this->dispatch('taskUpdated');
        $this->closeModal();
    }

    private function updateFormattedDueDate(): void
    {
        Carbon::setLocale('ru');    // Важно: устанавливает локаль для Carbon
        if (!$this->task->due_date) {
            $this->task->formatted_due_date = 'Без ограничений';
            return;
        }

        $dueDate = Carbon::parse($this->task->due_date);
//        $this->task->formated_created_at = $dueDate->translatedFormat('d F Y (l)');
        if ($dueDate->isToday()) {
            $this->task->formatted_due_date = 'Сделай сегодня';
        } elseif ($dueDate->isTomorrow()) {
            $this->task->formatted_due_date = 'На завтра';
        } elseif ($dueDate->isYesterday()) {
            $this->task->formatted_due_date = 'Вчера надо было';
        } else {
            $this->task->formatted_due_date = $dueDate->translatedFormat('d F Y (l)');
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
    {
        if ($this->showModal && $this->task) {
            $this->updateFormattedDueDate();
            $this->task->formatted_created_at = $this->task->created_at->translatedFormat('d F Y \в H:i');
        }

        return view('livewire.task-details-modal');
    }
}
