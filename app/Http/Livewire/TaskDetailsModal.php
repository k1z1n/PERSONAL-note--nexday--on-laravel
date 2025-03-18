<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;

class TaskDetailsModal extends Component
{
    public bool $showModal = false;
    public $task;
    public ?string $notification = null; // Переменная для уведомления
    public $newDueDate; // Свойство для выбранной даты при переносе

    protected $listeners = ['showTaskDetails' => 'loadTask'];

    /**
     * Загружает задачу по ID и показывает модальное окно.
     */
    public function loadTask($taskId): void
    {
        $this->task = Task::findOrFail($taskId);
        $this->showModal = true;
    }

    /**
     * Закрывает модальное окно и сбрасывает данные.
     */
    public function closeModal(): void
    {
        $this->reset(['showModal', 'task', 'newDueDate']);
    }

    /**
     * Закрывает модальное окно при клике вне его.
     */
    public function closeModalIfOutside(): void
    {
        $this->closeModal();
    }

    public function makeToday($taskId)
    {
        $this->task = Task::findOrFail($taskId);
        $this->task->due_date = Carbon::today()->toDateString();
        $this->task->save();

        $this->updateFormattedDueDate(); // Убедитесь, что метод существует

        $this->dispatch('taskUpdated'); // Работает только в Livewire
        $this->closeModal(); // Убедитесь, что метод существует
    }

    /**
     * Переносит задачу на завтра.
     */
    public function moveToTomorrow($taskId)
    {
        $task = Task::findOrFail($taskId);
        // Устанавливаем дату на завтра
        $newDue = Carbon::tomorrow()->toDateString();
        $task->due_date = $newDue;
        $task->save();

        // Обновляем локальный объект задачи и пересчитываем форматированную дату
        $this->task = Task::findOrFail($taskId);
        $this->updateFormattedDueDate();

        // Эмиттим событие, чтобы родительский компонент обновил список задач
        $this->dispatch('taskUpdated');

        // Закрываем модальное окно
        $this->closeModal();
    }

    public function moveToDate($taskId)
    {
        $this->validate([
            'newDueDate' => 'required|date'
        ]);

        $task = Task::findOrFail($taskId);
        $task->due_date = $this->newDueDate;
        $task->save();

        $this->task = Task::findOrFail($taskId);
        $this->updateFormattedDueDate();

        $this->dispatch('taskUpdated');

        $this->closeModal();
    }

    /**
     * Обновляет форматированное отображение даты выполнения задачи.
     */
    private function updateFormattedDueDate(): void
    {
        $dueDate = Carbon::parse($this->task->due_date);
        if(!is_null($this->task->due_date)){
            if ($dueDate->isToday()) {
                $this->task->formatted_due_date = 'До конца дня';
            } elseif ($dueDate->isTomorrow()) {
                $this->task->formatted_due_date = 'Завтра надо сделать';
            } elseif ($dueDate->isYesterday()) {
                $this->task->formatted_due_date = 'Вчера надо было';
            } else {
                $this->task->formatted_due_date = $dueDate->translatedFormat('d F Y (l)');
            }
        }else{
            $this->task->formatted_due_date = 'Без ограничений';
        }

    }

    public function render()
    {
        if ($this->showModal && $this->task) {
            // Обновляем форматированное отображение даты выполнения
            $this->updateFormattedDueDate();
            // Форматируем дату создания задачи в нужном виде (например, "01 декабря 2025 в 10:59")
            $this->task->formatted_created_at = $this->task->created_at->translatedFormat('d F Y \в H:i');
        }

        if ($this->showModal) {
            $this->notification = null;
        }
        return view('livewire.task-details-modal');
    }
}
