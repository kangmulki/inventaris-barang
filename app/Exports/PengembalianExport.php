<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengembalianExport implements FromCollection, WithHeadings, WithStyles
{
    protected $kembali;

    public function __construct($kembali)
    {
        $this->kembali = $kembali;
    }
    public function collection()
    {
        // Pilih hanya data yang ingin Anda ekspor
        return $this->kembali->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Nama Barang' => $item->pusat->nama,
                'Merek' => $item->merek,
                'Jumlah' => $item->jumlah,
                'Tanggal Kembali' => $item->formatted_tanggal,
                'Nama Peminjam' => $item->nama_peminjam,
                'Status' => $item->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Barang', 'Merek', 'Jumlah', 'Tanggal Kembali', 'Nama Peminjam', 'Status'];
    }
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->kembali->count() + 1;

        return [
            // Styling untuk header (baris pertama)
            1 => ['font' => ['bold' => true, 'color' => ['argb' => '000000']], 'alignment' => ['horizontal' => 'center']],
            // Mengatur background header agar berwarna
            'A1:G1' => ['fill' => ['fillType' => 'solid', 'color' => ['argb' => 'CCFFFF']],
            ],
            "A1:G{$rowCount}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => Color::COLOR_BLACK],
                    ],
                ],
            ],
        ];

    }
}
