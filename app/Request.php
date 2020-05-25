<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    const CREATED_AT = 'requested_at';
    const UPDATED_AT = null;

    public function media() {
        return $this->belongsTo('App\Media');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
