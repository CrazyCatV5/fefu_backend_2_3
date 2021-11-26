<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory, Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function save(array $options = []) {
        if ($this->exists && $this->isDirty('slug')) {
            $oldSlug = $this->getOriginal('slug');
            $newSlug = $this->slug;
            $redirect = new Redirect();
            $redirect->old_slug = route('news_item', ['slug' => $oldSlug], false);
            $redirect->new_slug = route('news_item', ['slug' => $newSlug], false);
            $redirect->save();
        }
        return parent::save($options);
    }
}
