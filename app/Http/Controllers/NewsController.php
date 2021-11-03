<?php

namespace App\Http\Controllers;
use App\Models\News;

class NewsController extends Controller
{
    public function getList()
    {
        $news_list = News::query()->where('published_at', '<=', 'NOW()')->orderByDesc('published_at')->orderByDesc('id')->paginate(5);
        return view('news_list', ['news_list' => $news_list]);
    }

    public function getDetails(string $slug)
    {
        $news = News::query()->where('slug', $slug)->where('is_published', true)->where('published_at', '<=', 'NOW()')->first();

        if ($news === null) {
            abort(404);
        }
        return view('news', ['news_item' => $news]);
    }
}
