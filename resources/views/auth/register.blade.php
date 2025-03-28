@extends('template.app')
@section('title', 'Регистрация')
@section('content')
    <div class="container md:w-1/2 p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Регистрация</h2>
        <form class="mt-6" method="POST" action="{{ route('register') }}">
            @csrf
            <label class="block mb-2 text-sm font-medium text-gray-600">Полное имя</label>
            <input type="text" class="w-full px-4 py-2 bg-gray-200 border rounded-md focus:outline-none"
                   placeholder="Введите ваше имя" name="name">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <label class="block mt-4 mb-2 text-sm font-medium text-gray-600">Электронная почта</label>
            <input type="text" class="w-full px-4 py-2 bg-gray-200 border rounded-md focus:outline-none"
                   placeholder="Введите ваш email" name="email">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <label class="block mt-4 mb-2 text-sm font-medium text-gray-600">Пароль</label>
            <input type="password" class="w-full px-4 py-2 bg-gray-200 border rounded-md focus:outline-none"
                   placeholder="Придумайте пароль" name="password">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <label class="block mt-4 mb-2 text-sm font-medium text-gray-600">Подтверждение пароля</label>
            <input type="password" class="w-full px-4 py-2 bg-gray-200 border rounded-md focus:outline-none"
                   placeholder="Подтверди пароль" name="password_confirmation">
            @error('general')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <button type="submit"
                    class="w-full mt-6 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                Зарегистрироваться
            </button>

            <p class="mt-4 text-center text-sm text-gray-600">
                Уже есть аккаунт? <a href="{{ route('view.login') }}" class="text-green-500 hover:underline">Войти</a>
            </p>
        </form>
    </div>
@endsection
