<header class="bg-white shadow-md relative z-10">
    <nav class="border-gray-200 px-4 lg:px-4 py-4 container mx-auto">
        <div class="flex flex-wrap justify-between items-center mx-auto container">
            <a href="/" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap">Nexday</span>
            </a>
            <!-- Regular Menu for Larger Screens -->
            <div class="hidden lg:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-blue-500">Главная</a>
                @guest()
                    <a href="{{ route('view.register') }}" class="text-gray-700 hover:text-blue-500">Регистрация</a>
                    <a href="{{ route('view.login') }}" class="text-gray-700 hover:text-blue-500">Авторизация</a>
                @endguest
                @auth()
                    {{--                    <a href="#profile" class="text-gray-700 hover:text-blue-500">Профиль</a>--}}
                    <a href="{{ route('view.completed.tasks') }}" class="text-gray-700 hover:text-blue-500">Выполненные
                        задания</a>
                    <form action="{{ route('logout') }}" method="post" class="flex items-center flex-col">
                        @csrf

                        <button type="submit" class="block text-red-500 hover:bg-gray-100">Выход</button>
                        {{--                            <a href="#logout" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Выход</a>--}}
                    </form>
{{--                    <a href="/#add-task-button" class="text-gray-700 hover:text-blue-500">Добавить запись</a>--}}
                @endauth
            </div>
            <!-- Burger Menu for Smaller Screens -->
            <button id="menu-toggle" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 lg:hidden"
                    aria-controls="mobile-menu" aria-expanded="false">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
                <span class="sr-only">Открыть меню</span>
            </button>
            <div id="mobile-menu"
                 class="absolute top-full left-0 w-full bg-white border-t shadow-lg menu-hidden no-animation"
                 style="--target-height: 200px;">
                <ul class="flex flex-col mt-1 mb-2 font-medium">
                    <li>
                        <a href="/" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Главная</a>
                    </li>
                    @guest()
                        <li>
                            <a href="{{ route('view.register') }}"
                               class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Регистрация</a>
                        </li>
                        <li>
                            <a href="{{ route('view.login') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Авторизация</a>
                        </li>
                    @endguest
                    @auth()
                        {{--                        <li>--}}
                        {{--                            <a href="#profile" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Профиль</a>--}}
                        {{--                        </li>--}}
                        <li>
                            <a href="{{ route('view.completed.tasks') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Выполненные задания</a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="block py-2 px-4 text-red-500 hover:bg-gray-100">Выход
                                </button>
                                {{--                            <a href="#logout" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Выход</a>--}}
                            </form>
                        </li>
{{--                        <li>--}}
{{--                            <a href="/#add-task-button" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Добавить--}}
{{--                                запись</a>--}}
{{--                        </li>--}}
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>
