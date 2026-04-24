<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Peminjaman::with(['user', 'buku.kategori'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama User',
            'Nama buku',
            'Kategori',
            'Tanggal Pinjam',
            'Tanggal Pengembalian',
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
            $row->user->name,
            $row->buku->nama_buku,
            $row->buku->kategori->nama_kategori,
            $row->created_at->format('d/m/Y'),
            $row->tgl_pengembalian->format('d/m/Y'),
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
        return 'Laporan Peminjaman';
    }
}
