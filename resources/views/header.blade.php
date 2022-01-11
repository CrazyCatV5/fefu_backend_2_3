@if(auth()->user() === null)
    <a href="{{ route('registration') }}">Регистрация</a>
    <a href="{{ route('login') }}">Вход</a>
@else
    <a href="{{ route('profile') }}">Профиль</a>
    <a href="{{ route('logout') }}">Выход</a>
@endif
