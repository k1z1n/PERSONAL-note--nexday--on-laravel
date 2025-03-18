<div>
    @if ($showModal)
{{--        @dd($task->formatted_due_date)--}}
        <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 px-4"
             wire:click="closeModalIfOutside">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative animate-fade-in" wire:click.stop>

                <!-- Кнопка закрытия -->
                <button wire:click="closeModal"
                        class="absolute top-4 right-4 text-gray-500 hover:text-red-500 transition focus:outline-none">
                    @svg('heroicon-o-x-mark', 'w-6 h-6')
                </button>

                <!-- Заголовок и срок выполнения -->
                {{--                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Срок выполнения</h2>--}}
                <p class="text-xl font-bold text-black mb-6">{{ $task->formatted_due_date }}</p>

                <!-- Детали задачи -->
                <div class="mb-6 border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Задача:</h3>
                    <p class="text-gray-900 text-base mb-4">{{ $task->title }}</p>

                    @if($task->description)
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg shadow-sm mb-4">
                            <div class="flex items-center gap-2 mb-2">
                                @svg('heroicon-o-document-text', 'w-5 h-5 text-gray-500')
                                <span class="font-medium text-gray-600">Описание</span>
                            </div>
                            <p class="text-gray-800 text-sm">{{ $task->description }}</p>
                        </div>
                    @endif

                    <div class="flex flex-col gap-1 text-sm text-gray-600">
                        {{--                        <span><strong>Выполнить до:</strong> {{ $task->formatted_due_date }}</span>--}}
                        <span><strong>Создано:</strong> {{ $task->formatted_created_at }}</span>
                    </div>
                </div>
                @if($task->formatted_due_date !== 'Без ограничений')
                    <!-- Кнопки управления -->
                    <div class="space-y-4">
                        <button wire:click="moveToTomorrow({{ $task->id }})"
                                class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 transition font-medium">
                            @svg('heroicon-o-arrow-path-rounded-square', 'w-6 h-6')
                            Перенести на завтра
                        </button>

                        <div class="flex gap-3">
                            <input type="date" wire:model="newDueDate"
                                   class="flex-1 px-4 py-3 border border-gray-300 rounded-xl text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <button wire:click="moveToDate({{ $task->id }})"
                                    class="px-5 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 flex items-center justify-center gap-2 shadow-md transition font-medium">
                                Перенести
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="space-y-4">
                        <button wire:click="makeToday{{ $task->id }})"
                                class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 transition font-medium">
                            @svg('heroicon-o-arrow-path-rounded-square', 'w-6 h-6')
                            Нужно сделать сегодня
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
