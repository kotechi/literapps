<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PengembalianExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Pengembalian::with(['peminjaman.user', 'peminjaman.buku', 'user'])->get();
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
            'Tanggal Pinjam',
            'Tanggal Seharusnya Kembali',
            'Tanggal Kembali Realisasi',
            'Hari Terlambat',
            'User',
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
            $row->peminjaman->user->name,
            $row->peminjaman->buku->nama_buku,
            $row->peminjaman->created_at    ->format('d/m/Y'),
            $row->peminjaman->tgl_pengembalian->format('d/m/Y'),
            $row->tanggal_kembali_realisasi->format('d/m/Y'),
            $row->hari_terlambat . ' hari',
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
        return 'Laporan Pengembalian';
    }
}
