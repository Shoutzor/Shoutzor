<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    const CREATED_AT = 'played_at';
    const UPDATED_AT = null;

    public function media() {
        return $this->hasOne('App\Media');
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
