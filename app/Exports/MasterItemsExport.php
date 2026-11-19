<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    private $filter;
    private $no = 0;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $f = $this->filter;
        return MasterItem::with('kategoris')
            ->when(!empty($f['kode']), fn($q) => $q->where('kode', 'like', '%' . $f['kode'] . '%'))
            ->when(!empty($f['nama']), fn($q) => $q->where('nama', 'like', '%' . $f['nama'] . '%'))
            ->when(!empty($f['hargamin']), fn($q) => $q->where('harga_beli', '>=', $f['hargamin']))
            ->when(!empty($f['hargamax']), fn($q) => $q->where('harga_beli', '<=', $f['hargamax']))
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama Kategori', 'Nama Items', 'Nama Supplier', 'Harga', 'Laba', 'Harga Jual'];
    }

    public function map($item): array
    {
        $laba = $item->harga_beli * $item->laba / 100;
        return [
            ++$this->no,
            $item->kategoris->pluck('nama')->implode(', '),
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $laba,
            $item->harga_beli + $laba,
        ];
    }
}
