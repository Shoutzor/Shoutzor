<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    const CREATED_AT = 'requested_at';
    const UPDATED_AT = null;

    public function media() {
        return $this->hasOne('App\Media');
    }

    public function user() {
        return $this->hasOne('App\User');
    }
}
