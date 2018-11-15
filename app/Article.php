<?php

namespace App;

use Carbon\Carbon as Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $fillable = ['title', 'body', 'image', 'author', 'published_at'];

    public static $rulesValidation = [
        'title' => 'required|min:3',
        'body' => 'required|min:10',
        'image' => 'required',
        'author' => 'required',
        'published_at' => 'required',
    ];


    public function scopeFilter($query, $title, $author, $publishedAtDateFrom, $publishedAtDateTo)
    {

        if (isset($title)) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if (isset($author)) {
            $query->where('author', 'like', '%' . $author . '%');
        }


        if ($publishedAtDateFrom != '' && $publishedAtDateTo != '') {
            $publishedAtDateFrom =  Carbon::createFromFormat('d/m/Y',
                $publishedAtDateFrom)->toDateString();

            $publishedAtDateTo =  Carbon::createFromFormat('d/m/Y',
                $publishedAtDateTo)->toDateString();

            $query->whereBetween(DB::raw('DATE(`published_at`)'),
                [$publishedAtDateFrom, $publishedAtDateTo]);
        }


        return $query;
    }


    public function getImageAttribute($value)
    {

        if (strpos($value, 'http') !== false) {
            return $value;
        } else {
            return url("/") . '/' . $value;
        }
    }

    public function getPublishedAtAttribute($value)
    {
        return Carbon::CreateFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function setPublishedAtAttribute($value)
    {

        $this->attributes['published_at'] =
            Carbon::createFromFormat('d/m/Y', $value)->toDateString();
    }


}
