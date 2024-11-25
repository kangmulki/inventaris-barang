<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangMasukExport implements FromCollection, WithHeadings, WithStyles
{
    protected $masuk;

    public function __construct($masuk)
    {
        $this->masuk = $masuk;
    }
    public function collection()
    {
        // Pilih hanya data yang ingin Anda ekspor
        return $this->masuk->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Nama Barang' => $item->pusat->nama,
                'Jumlah' => $item->jumlah,
                'Tanggal Masuk' => $item->formatted_tanggal,
                'Keterangan' => $item->ket,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Barang', 'Jumlah', 'Tanggal Masuk', 'Keterangan'];
    }
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->masuk->count() + 1;

        return [
            // Styling untuk header (baris pertama)
            1 => ['font' => ['bold' => true, 'color' => ['argb' => '000000']], 'alignment' => ['horizontal' => 'center']],
            // Mengatur background header agar berwarna
            'A1:E1' => ['fill' => ['fillType' => 'solid', 'color' => ['argb' => 'CCFFFF']],
            ],
            "A1:E{$rowCount}" => [
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
