<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'history';

    const CREATED_AT = 'played_at';
    const UPDATED_AT = null;

    public function media() {
        return $this->belongsTo('App\Media');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
