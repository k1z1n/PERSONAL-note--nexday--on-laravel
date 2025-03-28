@extends('template.app')

@section('title', 'Главная')
@section('main-flex-status', 'flex-col justify-start')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 mt-6 px-4">Задачи</h1>
            <livewire:add-task-modal/>
        </div>

        {{-- Компонент модального окна для добавления новой задачи --}}

        {{-- Компонент списка задач --}}
        <livewire:task-list/>

        {{-- Модальное окно для подробностей задачи --}}
        <livewire:task-details-modal/>
    </div>
@endsection
