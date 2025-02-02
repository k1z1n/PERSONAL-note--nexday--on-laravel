<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'       => fake('ru_RU')->sentence(3), // Генерация заголовка на русском
            'description' => fake('ru_RU')->paragraph(), // Генерация описания
            'completed'   => fake()->boolean(20), // 20% вероятности, что задача выполнена
            'due_date'    => Carbon::today(), // По умолчанию сегодня (будем менять в сидере)
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
