<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    
    protected $fillable = [
        'nama',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function getNameAttribute()
    {
        return $this->nama;
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_user', 'id_user');
    }
    
    public function artikel()
    {
        return $this->hasMany(Artikel::class, 'id_user', 'id_user');
    }
    
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_user', 'id_user');
    }
}