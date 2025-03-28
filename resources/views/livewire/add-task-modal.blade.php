<div class="mt-6">
    <button id="add-task-button"
            class="mx-4 mb-6 px-6 py-2 text-white bg-blue-500 font-semibold rounded-lg shadow-md hover:bg-blue-600"
            wire:click="$set('showModal', true)">
        Добавить задачу
    </button>

    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4"
             wire:click="$set('showModal', false)">
            <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative" wire:click.stop>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Добавить задачу</h2>
                <form wire:submit.prevent="saveTask">
                    <label class="block mb-2 text-sm font-medium text-gray-600">О чем тебе напомнить</label>
                    <textarea rows="6" wire:model="title"
                              class="w-full px-4 py-2 bg-gray-200 border-2 border-gray-300 rounded-xl shadow-sm
           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
           transition duration-300 ease-in-out"></textarea>
                    @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <label class="block mb-2 text-sm font-medium mt-4 text-gray-600">Дата окончания</label>
                    <div class="flex items-center space-x-4 mb-4">
                        <input type="date" id="due_date_picker" wire:model="due_date"
                               class="flex-grow px-4 py-2 bg-gray-200 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="{{ now()->format('Y-m-d') }}">
                        <button type="button" wire:click="setToday"
                                class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Сегодня
                        </button>
                    </div>
                    @error('due_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <div class="flex justify-end space-x-4">
                        <button type="button"
                                class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                wire:click="$set('showModal', false)">Отмена
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
