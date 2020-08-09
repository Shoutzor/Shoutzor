<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    const STATUS_QUEUED     = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_FAILED     = 2;

    public function user() {
        return $this->belongsTo('App\User');
    }

}
