@extends('template.app')
@section('title', 'Авторизация')

@section('content')
    <div class="container md:w-1/2 p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Вход</h2>
        <form class="mt-6" action="{{ route('login') }}" method="POST">
            @csrf
            <label class="block mb-2 text-sm font-medium text-gray-600">Электронная почта</label>
            <input type="email" class="w-full px-4 py-2 bg-gray-200 border rounded-md focus:outline-none " placeholder="Введите ваш email" name="email">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <label class="block mt-4 mb-2 text-sm font-medium text-gray-600">Пароль</label>
            <input type="password" class="w-full px-4 py-2 bg-gray-200 border rounded-md focus:outline-none focus:ring-2 " placeholder="Введите ваш пароль" name="password">

            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full mt-6 px-4 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                Войти
            </button>

            @error('message')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <p class="mt-4 text-center text-sm text-gray-600">
                У вас нет аккаунта? <a href="{{ route('view.register') }}" class="text-green-500 hover:underline">Зарегистрироваться</a>
            </p>
        </form>
    </div>
@endsection
