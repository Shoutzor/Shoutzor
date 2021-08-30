<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public function media()
    {
        return $this->belongsTo('App\Media');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
