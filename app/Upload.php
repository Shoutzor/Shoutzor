<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model {
    const STATUS_QUEUED = 0; # In queue to be processed
    const STATUS_PROCESSING = 1; # Currently being processed
    const STATUS_FAILED_RETRY = 2; # Processing failed, retry allowed.
    const STATUS_FAILED_FINAL = 3; # Processing failed, no retry.

    const QUEUE_NAME = 'uploads';
    const STORAGE_PATH = 'temp/upload/';

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }

}
