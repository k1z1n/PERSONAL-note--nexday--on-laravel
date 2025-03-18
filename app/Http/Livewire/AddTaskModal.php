<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;

class AddTaskModal extends Component
{
    public bool $showModal = false;
    public string $title = '';
    public string $description = '';
    public $due_date = '';
    public ?string $notification = null;

    protected array $rules = [
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'due_date'    => 'nullable|date',
    ];

    protected array $messages = [
        'title.required'       => 'Заполни поле для задачи',
        'title.string'         => 'Поле должно содержать текст',
        'title.max'            => 'Задача может содержать только :max символов',
        'description.string'   => 'Поле должно содержать текст',
        'description.max'      => 'Задача может содержать только :max символов',
        'due_date.date'        => 'Введи корректную дату',
    ];

    public function clearNotification()
    {
        $this->notification = null;
    }

    protected $listeners = ['clearNotification'];

    public function setToday(): void
    {
        $this->due_date = now()->toDateString();
    }

    public function saveTask()
    {
        $this->validate();
//
//        dd(
//            $this->validate()
//        );

        // Создаём задачу в БД с user_id текущего пользователя
        $task = Task::create([
            'title'       => $this->title,
            'description' => $this->description,
            'due_date'    => empty($this->due_date) ? null : $this->due_date,
            'user_id'     => auth()->id(),
        ]);

        // Отправляем событие TaskList для обновления списка задач
        $this->dispatch('taskAdded', task: $task->toArray());

        // Сбрасываем поля формы и скрываем модальное окно
        $this->reset(['title', 'description', 'due_date', 'showModal']);
    }

    public function render()
    {
        if (!$this->showModal) {
            $this->notification = null;
        }

        return view('livewire.add-task-modal');
    }
}
