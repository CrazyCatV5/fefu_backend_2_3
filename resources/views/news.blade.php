<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
        <a href="{{ route('news_list') }}">Новости</a>
        <h1>{{ $news_item->title }}</h1>
        <p>{{ $news_item->published_at }}</p>
        <p>{{ $news_item->text }}</p>
        @includeWhen(session('suggestion'), 'scripts.suggestionScript')
    </body>
</html>
