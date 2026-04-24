<?php

namespace App\Exports;

use App\Models\Denda;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DendaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.buku', 'user'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Peminjam',
            'Nama buku',
            'Kategori Denda',
            'Total Denda',
            'Petugas',
            'Status',
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->pengembalian->peminjaman->user->name,
            $row->pengembalian->peminjaman->buku->nama_buku,
            $row->nama_kategori,
            'Rp ' . number_format($row->total_denda, 0, ',', '.'),
            $row->user->name,
            ucfirst($row->status),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Laporan Denda';
    }
}
