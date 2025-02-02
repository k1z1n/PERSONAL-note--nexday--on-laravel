<div>
    @if ($showModal)
        <div class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 px-4"
             wire:click="closeModalIfOutside">

            {{-- Контейнер модального окна --}}
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 relative animate-fade-in"
                 wire:click.stop>

                {{-- Кнопка закрытия --}}
                <button wire:click="closeModal"
                        class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition focus:outline-none">
                </button>

                {{-- Заголовок (Срок выполнения) --}}
                <h2 class="text-2xl font-bold text-center mb-6 flex items-center justify-center gap-3 ">
                    <span class="text-gray-700">Срок:</span>
                    <span class=" font-semibold">
                        {{ $task->formatted_due_date }}
                    </span>
                </h2>

                {{-- Детали задачи --}}
                <div class="mb-6 space-y-4">
                    <p class="text-lg font-semibold text-gray-900 flex items-center gap-3 border-gray-400 border-b-[1px] pb-3">
                        {{ $task->title }}
                    </p>

                    @if($task->description)
                        <p class="text-gray-800 text-sm bg-gray-100 p-4 rounded-lg flex items-start gap-3 shadow-sm">
                            @svg('heroicon-o-document-text', 'w-6 h-6 text-gray-500')
                            <span><strong>Описание:</strong> {{ $task->description }}</span>
                        </p>
                    @endif

                    <p class="text-sm font-semibold flex items-center gap-3">
                        <strong>Выполнить до:</strong>
                        <span class="font-semibold">
                            {{ $task->formatted_due_date }}
                        </span>
                    </p>

                    <p class="text-xs text-gray-500 flex items-center gap-3">
                        <strong>Создано:</strong> {{ $task->formatted_created_at }}
                    </p>
                </div>

                {{-- Кнопки управления --}}
                <div class="grid gap-4">

                    {{-- Кнопка "Перенести на завтра" --}}
                    <button wire:click="moveToTomorrow({{ $task->id }})"
                            class="w-full flex items-center justify-center gap-3 px-5 py-3 bg-yellow-500 text-white rounded-xl shadow-md hover:bg-yellow-600 transition font-medium">
                        @svg('heroicon-o-arrow-path-rounded-square', 'w-6 h-6')
                        Перенести на завтра
                    </button>

                    {{-- Поле выбора даты и кнопка переноса --}}
                    <div class="flex gap-3">
                        <input type="date" wire:model="newDueDate"
                               class="flex-1 px-4 py-3 border rounded-xl text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <button wire:click="moveToDate({{ $task->id }})"
                                class="px-5 py-3 bg-blue-500 text-white rounded-xl hover:bg-blue-600 flex items-center justify-center gap-3 shadow-md transition font-medium">
                            Перенести
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
