<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanKelasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $kelasId;

    public function __construct($kelasId = null)
    {
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        $query = Kelas::with('siswa', 'waliKelas');
        
        if ($this->kelasId) {
            $query->where('id', $this->kelasId);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kelas',
            'Wali Kelas',
            'Jumlah Siswa',
            'Rata-rata Nilai',
        ];
    }

    public function map($kelas): array
    {
        $siswaIds = $kelas->siswa->pluck('id');
        $rataRata = Nilai::whereIn('siswa_id', $siswaIds)
            ->whereNotNull('rata_rata')
            ->avg('rata_rata') ?? 0;

        return [
            $kelas->nama_kelas,
            $kelas->waliKelas->name ?? '-',
            $kelas->siswa->count(),
            number_format($rataRata, 2),
        ];
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 15,
            'D' => 18,
        ];
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
        return 'Laporan Kelas';
    }
}
