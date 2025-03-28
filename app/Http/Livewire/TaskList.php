<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\TaskService;
use Illuminate\Support\Collection;

class TaskList extends Component
{
    use WithPagination;

    public ?string $notification = null;

    public bool $confirmModal = false;
    public string $confirmType = '';
    public ?int $taskId = null;

    protected TaskService $taskService;

    protected $listeners = ['taskAdded', 'clearNotification', 'deleteTask', 'markCompleted', 'taskUpdated' => '$refresh'];

    public function __construct()
    {
        $this->taskService = app(TaskService::class);
    }

    // Методы для модального окна
    public function confirmDelete($taskId)
    {
        $this->confirmModal = true;
        $this->confirmType = 'delete';
        $this->taskId = $taskId;
    }

    public function confirmComplete($taskId)
    {
        $this->confirmModal = true;
        $this->confirmType = 'complete';
        $this->taskId = $taskId;
    }

    public function closeModal()
    {
        $this->confirmModal = false;
        $this->confirmType = '';
        $this->taskId = null;
    }

    public function doConfirm()
    {
        if ($this->confirmType === 'delete') {
            $this->deleteTask($this->taskId);
        } elseif ($this->confirmType === 'complete') {
            $this->markCompleted($this->taskId);
        }
        $this->closeModal();
    }

    public function deleteTask($taskId)
    {
        $message = $this->taskService->deleteTask($taskId);
        if ($message) {
            session()->flash('notification', $message);
        }
    }

    public function markCompleted($taskId)
    {
        $message = $this->taskService->markCompleted($taskId);
        if ($message) {
            session()->flash('notification', $message);
        }
    }

    public function taskAdded(array $task): void
    {
        $this->notification = 'Задача успешно добавлена!';
        $this->dispatch('hide-notification', ['timeout' => 2500]);
    }

    public function clearNotification(): void
    {
        $this->notification = null;
    }

    public function showDetails($taskId): void
    {
        $this->dispatch('showTaskDetails', $taskId);
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $tasks = $this->taskService->getUserTasks();
        $today = now()->startOfDay();

        return view('livewire.task-list', [
            'urgentTasks' => $tasks->filter(fn($task) => $task->due_date && Carbon::parse($task->due_date)->isBefore($today)),
            'todayTasks' => $tasks->filter(fn($task) => $task->due_date && Carbon::parse($task->due_date)->isToday()),
            'upcomingTasks' => $tasks->filter(fn($task) => $task->due_date && Carbon::parse($task->due_date)->isAfter($today)),
            'noDateTasks' => $tasks->filter(fn($task) => !$task->due_date),
            'notification' => $this->notification,
        ]);
    }
}
