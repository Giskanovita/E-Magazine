<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class artikel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';
    protected $fillable = ['judul', 'isi', 'tanggal', 'id_user', 'id_kategori', 'foto', 'lampiran', 'status'];
    
    protected $casts = [
        'lampiran' => 'array'
    ];
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_artikel', 'id_artikel');
    }
    
    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'id_artikel', 'id_artikel');
    }
}
