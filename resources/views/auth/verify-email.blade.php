@extends('template.app')

@section('content')
    <div class="container mx-auto mt-6 px-4">
        <h1 class="text-xl font-bold text-gray-800 text-center mb-4">Подтвердите ваш email</h1>
        <p class="text-gray-600 text-center mb-4">
            На ваш email отправлена ссылка для подтверждения. Пожалуйста, проверьте почту.
        </p>
        @if (session('message'))
            <p class="text-green-600 text-center">{{ session('message') }}</p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="text-center">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                Отправить ссылку еще раз
            </button>
        </form>
    </div>
@endsection
