<?php

namespace App;

class Permission extends \Spatie\Permission\Models\Permission {

    protected $hidden = ['created_at', 'updated_at', 'guard_name'];

}
