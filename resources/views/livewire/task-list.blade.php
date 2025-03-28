<div>
    {{-- Уведомление --}}
    @if ($notification)
        <div id="notification"
             class="fixed md:top-4 md:right-4 mx-4 top-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-md z-30">
            {{ $notification }}
        </div>
    @endif
    {{-- Общая проверка: если во всех категориях задач нет, выводим одно сообщение --}}
    @if($urgentTasks->isEmpty() && $todayTasks->isEmpty() && $upcomingTasks->isEmpty() && $noDateTasks->isEmpty())
        <div class="p-4 text-center text-gray-600">Задачи не найдены</div>
    @else
        @if($noDateTasks->count() > 0)
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-500 px-4">Надо сделать</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden mx-4">
                    <ul>
                        @foreach ($noDateTasks as $task)
                            <li class="border-b border-gray-200 last:border-none task-item">
                                <div class="flex justify-between items-center p-4 hover:bg-gray-50">
                                    <div class="flex-1 cursor-pointer" wire:click="showDetails({{ $task->id }})">
                                        <p class="font-semibold text-gray-800 overflow-hidden text-ellipsis"
                                           style="-webkit-line-clamp: 1; display: -webkit-box; -webkit-box-orient: vertical;">
                                            {{ $task->title }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $task->formatted_due_date }}</p>
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button wire:click.stop="confirmComplete({{ $task->id }})"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                        </button>
                                        <button wire:click.stop="confirmDelete({{ $task->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        {{-- Срочные задачи --}}
        @if($urgentTasks->count() > 0)
            <div class="mb-6">
                <h2 class="text-lg font-bold text-red-500 px-4">Срочные задачи</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden mx-4">
                    <ul>
                        @foreach ($urgentTasks as $task)
                            <li class="border-b border-red-500 last:border-none task-item">
                                <div class="flex justify-between items-center p-4 bg-red-50">
                                    <div class="flex-1 cursor-pointer" wire:click="showDetails({{ $task->id }})">
                                        <p class="font-semibold text-gray-800 overflow-hidden text-ellipsis"
                                           style="-webkit-line-clamp: 1; display: -webkit-box; -webkit-box-orient: vertical;">
                                            {{ $task->title }}
                                        </p>
                                        <p class="text-sm text-red-500">{{ $task->formatted_due_date }}</p>
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button wire:click.stop="confirmComplete({{ $task->id }})"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                        </button>
                                        <button wire:click.stop="confirmDelete({{ $task->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Задачи на сегодня --}}
        @if($todayTasks->count() > 0)
            <div class="mb-6">
                <h2 class="text-lg font-bold text-blue-500 px-4">На сегодня</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden mx-4">
                    <ul>
                        @foreach ($todayTasks as $task)
                            <li class="border-b border-gray-200 last:border-none task-item">
                                <div class="flex justify-between items-center p-4 hover:bg-gray-50">
                                    <div class="flex-1 cursor-pointer" wire:click="showDetails({{ $task->id }})">
                                        <p class="font-semibold text-gray-800 overflow-hidden text-ellipsis"
                                           style="-webkit-line-clamp: 1; display: -webkit-box; -webkit-box-orient: vertical;">
                                            {{ $task->title }}
                                        </p>
                                        <p class="text-sm text-blue-500">{{ $task->formatted_due_date }}</p>
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button wire:click.stop="confirmComplete({{ $task->id }})"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                        </button>
                                        <button wire:click.stop="confirmDelete({{ $task->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Будущие задачи --}}
        @if($upcomingTasks->count() > 0)
            <div class="mb-6">
                <h2 class="text-lg font-bold text-green-500 px-4">Будущие задачи</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden mx-4">
                    <ul>
                        @foreach ($upcomingTasks as $task)
                            <li class="border-b border-gray-200 last:border-none task-item">
                                <div class="flex justify-between items-center p-4 hover:bg-gray-50">
                                    <div class="flex-1 cursor-pointer" wire:click="showDetails({{ $task->id }})">
                                        <p class="font-semibold text-gray-800 overflow-hidden text-ellipsis"
                                           style="-webkit-line-clamp: 1; display: -webkit-box; -webkit-box-orient: vertical;">
                                            {{ $task->title }}
                                        </p>
                                        <p class="text-sm text-green-500">{{ $task->formatted_due_date }}</p>
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button wire:click.stop="confirmComplete({{ $task->id }})"
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.5 12.75l6 6 9-13.5"/>
                                            </svg>
                                        </button>
                                        <button wire:click.stop="confirmDelete({{ $task->id }})"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="2"
                                                 stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    @endif

    {{-- Модальное окно подтверждения --}}
    @if($confirmModal)
        <div class="fixed inset-0 flex items-center justify-center backdrop-blur-sm bg-black/50 z-50">
            <div class="bg-white p-6 rounded shadow-md max-w-sm w-full mx-4">
                <h2 class="text-xl font-bold mb-4">
                    @if($confirmType === 'delete')
                        Подтвердите удаление
                    @else
                        Подтвердите выполнение
                    @endif
                </h2>
                <p class="mb-4">
                    @if($confirmType === 'delete')
                        Вы действительно хотите удалить эту задачу?
                    @else
                        Вы действительно хотите отметить задачу как выполненную?
                    @endif
                </p>
                <div class="flex justify-end space-x-2">
                    <button wire:click="doConfirm"
                            class="@if($confirmType === 'delete')bg-red-500 @else bg-green-500 @endif text-white px-4 py-2 rounded">
                        Да
                    </button>
                    <button wire:click="closeModal" class="bg-gray-300 px-4 py-2 rounded">
                        Отмена
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
