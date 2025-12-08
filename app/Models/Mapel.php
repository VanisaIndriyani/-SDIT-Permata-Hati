<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function mapelGuru()
    {
        return $this->hasMany(MapelGuru::class);
    }
}
