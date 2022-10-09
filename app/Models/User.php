<?php

namespace App\Models;

use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\Contracts\HasApiTokens as HasApiTokensContract;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable implements HasApiTokensContract
{
    use UsesUUID, HasApiTokens, Notifiable, HasRoles, HasPermissions, RefreshesPermissionCache, HasFactory;

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'api_token'];
    protected $appends = ['is_admin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'api_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime',];

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn() => $this->hasRole('admin')
        );
    }

    /**
     * Will contain both permissions inherited via assigned roles, and directly assigned permissions
     * @return Attribute
     */
    public function allPermissions(): Attribute
    {
        return new Attribute(
            get: fn() => $this->getAllPermissions()
        );
    }
}
