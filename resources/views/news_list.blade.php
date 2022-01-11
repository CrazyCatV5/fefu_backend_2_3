<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
    @include('header')
        <h1>Новости</h1>
        @foreach($news_list as $i => $news_item)
            <a href="{{ route('news_item', ['slug' => $news_item->slug]) }}"><b>{{ $news_item->title }}</b></a>
            <p>{{ $news_item->published_at }}</p>
            @if($news_item->description !== null)
                <p>{{ $news_item->description }}</p>
            @endif
            @if($i > 0)
                <hr>
            @endif
        @endforeach
        @includeWhen(session('suggestion'), 'scripts.suggestionScript')
    </body>
</html>
