<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Report extends Model
{
    use HasFactory;
    use AsSource;

    protected $guarded = [];

    public function paste()
    {
        return $this->belongsTo('App\Paste');
    }
}
