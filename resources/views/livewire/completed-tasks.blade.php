<div class="container mx-auto mt-6 px-4">
    <h1 class="text-2xl font-bold text-center text-green-600 mb-6">Выполненные задачи</h1>

    @if($groupedTasks->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            @foreach ($groupedTasks as $date => $tasks)
                {{-- Кликабельная плашка с датой --}}
                <button class="w-full text-left bg-gray-200 p-4 font-bold text-gray-700 focus:outline-none"
                        onclick="toggleTasks('{{ $loop->index }}')">
                    {{ $date }}
                </button>

                {{-- Список задач --}}
                <ul id="task-group-{{ $loop->index }}" class="{{ $date !== 'Сегодня' ? 'hidden' : '' }}">
                    @foreach ($tasks as $task)
                        <li class="border-b border-gray-200 last:border-none">
                            <div data-modal-target="modal-{{ $task->id }}" data-modal-toggle="modal-{{ $task->id }}"
                                 class="cursor-pointer p-4 bg-green-50 hover:bg-green-100 transition rounded">
                                <p class="font-semibold text-gray-800">{{ $task->title }}</p>
                                <p class="text-sm text-gray-600">{{ $task->description }}</p>
                                <p class="text-sm text-gray-500">Выполнено: {{ $task->formatted_completed_date }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-600">Нет выполненных задач.</p>
    @endif

    {{-- Индикатор загрузки --}}
    <div wire:loading wire:target="loadMoreDates" class="text-center my-4">
        <span class="text-gray-600">Загрузка...</span>
    </div>

    {{-- Невидимый триггер для подгрузки --}}
    <div wire:ignore class="h-10" id="load-more-trigger"></div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    Livewire.dispatch('loadMoreDates');
                }
            });
        });

        observer.observe(document.getElementById('load-more-trigger'));
    });

    function toggleTasks(groupIndex) {
        let taskList = document.getElementById('task-group-' + groupIndex);
        taskList.classList.toggle('hidden');
    }
</script>
