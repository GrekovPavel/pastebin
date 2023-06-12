<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Report extends Model
{
    use HasFactory;
    use AsSource;

    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function paste()
    {
        return $this->belongsTo('App\Paste');
    }
}
