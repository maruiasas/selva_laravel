<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administer extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function getAuthPassword()
    {
        return $this->password;
    }

    protected $guard = 'admin';
    protected $fillable = [
        'name', 'loginid', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
