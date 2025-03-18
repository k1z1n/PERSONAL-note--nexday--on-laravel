<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TaskList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $finalSearch = '';
    public ?string $notification = null;

    public bool $confirmModal = false;
    public string $confirmType = '';
    public ?int $taskId = null;

    protected $listeners = ['taskAdded', 'clearNotification', 'deleteTask', 'markCompleted', 'taskUpdated' => '$refresh',];

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
        $task = Task::find($taskId);
        if ($task) {
            $task->delete();
            session()->flash('notification', "Задача '{$task->title}' удалена!");
        }
    }

    public function markCompleted($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->completed = true;
            $task->save();
            session()->flash('notification', "Задача '{$task->title}' отмечена как выполненная!");
        }
    }

    public function taskAdded(array $task)
    {
        $this->notification = 'Задача "' . $task['title'] . '" успешно добавлена!';
        $this->dispatch('hide-notification', ['timeout' => 4000]);
    }

    public function clearNotification()
    {
        $this->notification = null;
    }

    public function applySearch()
    {
        $this->finalSearch = $this->search;
        $this->resetPage();
    }

    public function showDetails($taskId)
    {
        $this->dispatch('showTaskDetails', $taskId);
    }

    public function render()
    {
        // Выбираем только задачи текущего пользователя, у которых completed = false
        $tasks = Task::where('user_id', auth()->id())
            ->where('completed', false)
            ->when($this->finalSearch, function ($query) {
                $query->where('title', 'like', '%' . $this->finalSearch . '%')
                    ->orWhere('description', 'like', '%' . $this->finalSearch . '%');
            })
            ->orderBy('due_date', 'asc')
            ->get();

        $today = Carbon::today();

        $formattedTasks = collect($tasks)->map(function ($task) {
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
        return view('livewire.task-list', [
            'urgentTasks' => $formattedTasks->filter(fn($task) => $task->due_date && Carbon::parse($task->due_date)->isBefore($today)),
            'todayTasks' => $formattedTasks->filter(fn($task) => $task->due_date && Carbon::parse($task->due_date)->isToday()),
            'upcomingTasks' => $formattedTasks->filter(fn($task) => $task->due_date && Carbon::parse($task->due_date)->isAfter($today)),
            'noDateTasks' => $formattedTasks->filter(fn($task) => !$task->due_date),
            'notification' => $this->notification,
        ]);
    }
}
