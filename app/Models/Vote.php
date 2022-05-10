<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use UsesUUID, HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    public function media()
    {
        return $this->belongsTo('App\Models\Media');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
