<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 40px 40px 60px 40px; }
        body { font-family: sans-serif; font-size: 12px; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.data th, table.data td { border: 1px solid #333; padding: 5px; }
        table.data th { background: #eee; }
        footer { position: fixed; bottom: -40px; left: 0; right: 0; font-size: 10px; text-align: right; }
    </style>
</head>
<body>
    <h3>Detail Kategori</h3>
    <table>
        <tr><th align="left">Nama Kategori</th><td>:</td><td>{{ $data->nama }}</td></tr>
        <tr><th align="left">Kode Kategori</th><td>:</td><td>{{ $data->kode }}</td></tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>No</th><th>Kode</th><th>Nama</th><th>Jenis</th><th>Supplier</th><th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data->masterItems as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->supplier }}</td>
                <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" align="center">Tidak ada item</td></tr>
            @endforelse
        </tbody>
    </table>

    <footer>Dicetak pada: {{ $dicetak }}</footer>
</body>
</html>
