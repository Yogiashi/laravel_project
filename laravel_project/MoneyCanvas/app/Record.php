<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $table = 'records';
    protected $fillable =
    [
        'user_id',
        'category_id',
        'type',
        'date',
        'amount',
        'note'
    ];

    public function user()
    {
     return $this->belongsTo(User::class);
    }

    public function category()
    {
     return $this->belongsTo(Category::class);
    }
}
