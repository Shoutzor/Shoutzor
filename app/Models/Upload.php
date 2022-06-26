<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use UsesUUID;

    const STATUS_QUEUED = 0; # In queue to be processed
    const STATUS_PROCESSING = 1; # Currently being processed
    const STATUS_FAILED_RETRY = 2; # Processing failed, retry allowed.
    const STATUS_FAILED_FINAL = 3; # Processing failed, no retry.

    const QUEUE_NAME = 'uploads';
    const STORAGE_PATH = 'temp/upload/';

    const CREATED_AT = 'uploaded_at';
    const UPDATED_AT = null;

    public function uploaded_by()
    {
        return $this->hasOne('App\Models\User', 'id', 'uploaded_by');
    }

}
