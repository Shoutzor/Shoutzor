<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['voted_at'];

    public function request()
    {
        return $this->belongsTo('App\Models\Request');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
