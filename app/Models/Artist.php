<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use UsesUUID, HasFactory;

    public function albums()
    {
        return $this->belongsToMany('App\Models\Album');
    }

    public function media()
    {
        return $this->belongsToMany('App\Models\Media');
    }
}
