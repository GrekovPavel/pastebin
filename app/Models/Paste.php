<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Paste extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AsSource;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function reports()
    {
        return $this->hasMany('App\Report');
    }
}
