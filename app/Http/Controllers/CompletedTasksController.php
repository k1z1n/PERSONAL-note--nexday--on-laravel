<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\CompletedTaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompletedTasksController extends Controller
{
    protected CompletedTaskService $completedTaskService;

    public function __construct(CompletedTaskService $completedTaskService)
    {
        $this->completedTaskService = $completedTaskService;
    }

    public function showCompletedPage()
    {
        return view('pages.completed-tasks');
    }
}
