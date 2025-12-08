<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapelGuru extends Model
{
    protected $table = 'mapel_guru';
    
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
