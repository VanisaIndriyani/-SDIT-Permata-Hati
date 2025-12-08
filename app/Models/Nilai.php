<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'tahun_ajaran_id',
        'nilai_uh',
        'nilai_pts',
        'nilai_pas',
        'rata_rata',
        'deskripsi_kompetensi',
    ];

    protected $casts = [
        'nilai_uh' => 'decimal:2',
        'nilai_pts' => 'decimal:2',
        'nilai_pas' => 'decimal:2',
        'rata_rata' => 'decimal:2',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
}
