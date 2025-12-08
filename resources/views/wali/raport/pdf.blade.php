<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport - {{ $siswa->nama_siswa }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            background: #fff;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #28a745;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18pt;
            color: #28a745;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16pt;
            color: #dc3545;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 11pt;
            color: #666;
        }
        
        .info-box {
            border: 2px solid #28a745;
            padding: 15px;
            margin-bottom: 20px;
            background: #f8f9fa;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
        }
        
        .info-value {
            flex: 1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #28a745;
            color: white;
        }
        
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            font-weight: bold;
            text-align: center;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 2px solid #28a745;
            padding-top: 15px;
        }
        
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 20px;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SD ISLAM TERPADU</h1>
        <h2>PERMATA HATI</h2>
        <p>RAPORT SEMESTER</p>
    </div>
    
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Nama Siswa</div>
            <div class="info-value">: {{ $siswa->nama_siswa }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">NIS</div>
            <div class="info-value">: {{ $siswa->nis }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kelas</div>
            <div class="info-value">: {{ $siswa->kelas->nama_kelas ?? '-' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tahun Ajaran</div>
            <div class="info-value">: {{ $siswa->tahunAjaran->tahun_ajaran ?? '-' }} - {{ $siswa->tahunAjaran->semester ?? '-' }}</div>
        </div>
    </div>
    
    <h3 style="text-align: center; margin-bottom: 15px; color: #28a745;">NILAI MATA PELAJARAN</h3>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>UH</th>
                <th>PTS</th>
                <th>PAS</th>
                <th>Nilai Akhir</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa->nilai as $index => $nilai)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $nilai->mapel->nama_mapel }}</td>
                <td style="text-align: center;">{{ $nilai->nilai_uh ?? '-' }}</td>
                <td style="text-align: center;">{{ $nilai->nilai_pts ?? '-' }}</td>
                <td style="text-align: center;">{{ $nilai->nilai_pas ?? '-' }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $nilai->rata_rata ? number_format($nilai->rata_rata, 2) : '-' }}</td>
                <td>{{ $nilai->deskripsi_kompetensi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <div class="signature">
            <div class="signature-box">
                <div class="signature-line">
                    Wali Kelas
                </div>
            </div>
            <div class="signature-box">
                <div class="signature-line">
                    Kepala Sekolah
                </div>
            </div>
        </div>
    </div>
    
    <div class="no-print" style="text-align: center; margin-top: 20px; padding: 20px;">
        <button onclick="window.print()" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; margin-right: 10px;">
            🖨️ Cetak / Print
        </button>
        <a href="{{ route('wali.raport.index') }}" style="display: inline-block; background: #6c757d; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 14px;">
            ← Kembali
        </a>
    </div>
</body>
</html>

