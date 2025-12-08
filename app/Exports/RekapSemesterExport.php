<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapSemesterExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $mapel;

    public function __construct()
    {
        $this->mapel = Mapel::all();
    }

    public function collection()
    {
        return Siswa::with(['kelas', 'tahunAjaran', 'nilai.mapel'])->get();
    }

    public function headings(): array
    {
        $headings = ['NIS', 'Nama Siswa', 'Kelas'];
        
        foreach ($this->mapel as $m) {
            $headings[] = $m->nama_mapel;
        }
        
        $headings[] = 'Rata-rata Umum';
        
        return $headings;
    }

    public function map($siswa): array
    {
        $row = [
            $siswa->nis,
            $siswa->nama_siswa,
            $siswa->kelas->nama_kelas ?? '-',
        ];
        
        $totalNilai = 0;
        $jumlahMapel = 0;
        
        foreach ($this->mapel as $m) {
            $nilai = $siswa->nilai->where('mapel_id', $m->id)->first();
            $rataRata = $nilai ? $nilai->rata_rata : null;
            $row[] = $rataRata ? number_format($rataRata, 2) : '-';
            
            if ($rataRata) {
                $totalNilai += $rataRata;
                $jumlahMapel++;
            }
        }
        
        $rataRataUmum = $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
        $row[] = $rataRataUmum > 0 ? number_format($rataRataUmum, 2) : '-';
        
        return $row;
    }
    
    public function columnWidths(): array
    {
        $widths = [
            'A' => 15,
            'B' => 30,
            'C' => 15,
        ];
        
        $col = 'D';
        foreach ($this->mapel as $m) {
            $widths[$col] = 18;
            $col++;
        }
        $widths[$col] = 18; // Rata-rata umum
        
        return $widths;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '28a745']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Rekap Semester';
    }
}
