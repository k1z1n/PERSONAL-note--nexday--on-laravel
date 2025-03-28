<?php

namespace App\Http\Livewire;

use App\Services\CompletedTaskService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CompletedTasks extends Component
{
    use WithPagination;

    public int $userId;
    public int $datesPerPage = 10;
    public Collection $loadedDates;
    public bool $allDatesLoaded = false;

    protected CompletedTaskService $completedTaskService;

    public function __construct()
    {
        $this->completedTaskService = app(CompletedTaskService::class);
    }

    public function mount()
    {
        $this->userId = Auth::id();
        $this->loadedDates = collect();
        $this->loadMoreDates();
    }

    public function loadMoreDates()
    {
        if ($this->allDatesLoaded) {
            return;
        }

        $groupedTasks = $this->completedTaskService->getGroupedCompletedTasks($this->userId, $this->datesPerPage);

        if ($groupedTasks->isEmpty()) {
            $this->allDatesLoaded = true;
            return;
        }

        $this->loadedDates = $this->loadedDates->merge($groupedTasks);
    }

    public function render()
    {
        return view('livewire.completed-tasks', [
            'groupedTasks' => $this->loadedDates
        ]);
    }
}
