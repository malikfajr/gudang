<?php

namespace App\Exports;

use App\Models\Pinjam;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class IcomeExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    const FORMAT_CURRENCY_IDR_SIMPLE = '"Rp. "#,##0_-';

    protected $start;
    protected $end;
    protected $index;

    function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->index = 1;
    }
    
    public function map($row): array
    {
        return [
            $this->index++,
            $row->user->name,
            $row->barang->nama,
            $row->starting_date,
            $row->ending_date,
            $row->denda,
            $row->income,
        ];
    }

    public function query(){
        $income = Pinjam::query();

        if (!empty($this->start)) {
            $income->where('starting_date', '>=', $this->start);
        }

        if (!empty($this->end)) {
            $income->where('ending_date', '<=', $this->end);
        }


        return $income;
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama',
            'Nama Barang',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Denda',
            'Total'
        ]; 
    }

    public function columnWidths(): array {
        return [
            'A' => 3,
            'B' => 20,
            'C' => 30,
            'D' => 30,
            'E' => 20,
            'F' => 20,
            'G' => 20,
        ];
    }

    public function styles($sheet) : array {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => ['bold' => true], 
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
            ],
            
            'F' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                'numberFormat' => ['formatCode' =>self::FORMAT_CURRENCY_IDR_SIMPLE]
            ],

            'G' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                'numberFormat' => ['formatCode' =>self::FORMAT_CURRENCY_IDR_SIMPLE]
            ],
        ];
    }
}
