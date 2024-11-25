<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataPusatExport implements FromCollection, WithHeadings, WithStyles
{
    protected $datapusat;

    public function __construct($datapusat)
    {
        $this->datapusat = $datapusat;
    }
    public function collection()
    {
        // Pilih hanya data yang ingin Anda ekspor
        return $this->datapusat->map(function ($item, $key) {
            return [
                'No' => $key + 1,
                'Nama Barang' => $item->nama,
                'Merek' => $item->merek,
                'Stok' => $item->stok,
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama Barang', 'Merek', 'Stok'];
    }
    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->datapusat->count() + 1;

        return [
            // Styling untuk header (baris pertama)
            1 => ['font' => ['bold' => true, 'color' => ['argb' => '000000']], 'alignment' => ['horizontal' => 'center']],
            // Mengatur background header agar berwarna
            'A1:D1' => ['fill' => ['fillType' => 'solid', 'color' => ['argb' => 'CCFFFF']],
            ],
            "A1:D{$rowCount}" => [
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
