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
        'due_date'    => 'required|date',
    ];

    protected array $messages = [
        'title.required'       => 'Поле "Название задачи" обязательно для заполнения.',
        'title.string'         => 'Поле "Название задачи" должно быть строкой.',
        'title.max'            => 'Поле "Название задачи" не должно превышать :max символов.',
        'description.required' => 'Поле "Описание" обязательно для заполнения.',
        'description.string'   => 'Поле "Описание" должно быть строкой.',
        'description.max'      => 'Поле "Описание" не должно превышать :max символов.',
        'due_date.required'    => 'Поле "Дата окончания" обязательно для заполнения.',
        'due_date.date'        => 'Поле "Дата окончания" должно быть корректной датой.',
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

        // Создаём задачу в БД с user_id текущего пользователя
        $task = Task::create([
            'title'       => $this->title,
            'description' => $this->description,
            'due_date'    => $this->due_date,
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
