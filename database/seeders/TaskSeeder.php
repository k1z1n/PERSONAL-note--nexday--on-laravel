<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5 задач на сегодня
        Task::factory()->count(5)->create(['due_date' => Carbon::today()]);

        // 5 задач на вчера
        Task::factory()->count(5)->create(['due_date' => Carbon::yesterday()]);

        // 5 задач на 3 дня назад
        Task::factory()->count(5)->create(['due_date' => Carbon::today()->subDays(3)]);

        // 5 задач на будущее (от +1 до +5 дней)
        for ($i = 0; $i < 5; $i++) {
            Task::factory()->create(['due_date' => Carbon::today()->addDays(rand(1, 5))]);
        }
    }
}
