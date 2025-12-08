<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Mapel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanPendidikanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    public function collection()
    {
        // Return collection dengan data laporan pendidikan
        $data = collect();
        
        // Data Kelas
        $kelas = Kelas::all();
        foreach ($kelas as $k) {
            $siswaIds = $k->siswa->pluck('id');
            $rataRata = Nilai::whereIn('siswa_id', $siswaIds)
                ->whereNotNull('rata_rata')
                ->avg('rata_rata') ?? 0;
            
            $data->push([
                'type' => 'kelas',
                'nama' => $k->nama_kelas,
                'jumlah_siswa' => $k->siswa->count(),
                'rata_rata' => $rataRata,
            ]);
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'Kelas',
            'Jumlah Siswa',
            'Rata-rata Nilai',
            'Keterangan',
        ];
    }

    public function map($item): array
    {
        return [
            $item['nama'],
            $item['jumlah_siswa'],
            number_format($item['rata_rata'], 2),
            $item['rata_rata'] >= 75 ? 'Baik' : ($item['rata_rata'] >= 60 ? 'Cukup' : 'Perlu Perhatian'),
        ];
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 15,
            'D' => 18,
            'E' => 20,
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
        return 'Laporan Pendidikan';
    }
}
