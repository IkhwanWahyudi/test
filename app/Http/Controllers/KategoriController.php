<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $data['kategoris'] = Kategori::query()
            ->when($request->filled('nama'), fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->when($request->filled('kode'), fn($q) => $q->where('kode', 'like', '%' . $request->kode . '%'))
            ->orderBy('id')->get();
        return view('kategori.index.index', $data);
    }

    public function formView($method, $id = 0)
    {
        $data['data'] = $method == 'new' ? null : Kategori::findOrFail($id);
        $data['method'] = $method;
        return view('kategori.form.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $kategori = $method == 'new' ? new Kategori : Kategori::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'kode' => 'required|string|max:20|unique:kategoris,kode,' . ($kategori->id ?? 'NULL'),
        ]);

        $kategori->nama = $request->nama;
        $kategori->kode = $request->kode;
        $kategori->save();

        return redirect('kategori')->with('success', 'Kategori berhasil disimpan.');
    }

    public function search(Request $request)
    {
        $data = Kategori::query()
            ->when($request->filled('kode'), fn($q) => $q->where('kode', 'like', '%' . $request->kode . '%'))
            ->when($request->filled('nama'), fn($q) => $q->where('nama', 'like', '%' . $request->nama . '%'))
            ->select('id', 'kode', 'nama')
            ->orderBy('id')
            ->get();

        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function singleView($id)
    {
        $data['data'] = Kategori::with('masterItems')->findOrFail($id);
        return view('kategori.single.index', $data);
    }

    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->masterItems()->detach();
        $kategori->delete();
        return redirect('data');
    }

    public function pdf($id)
    {
        $data = Kategori::with('masterItems')->findOrFail($id);
        $pdf = Pdf::loadView('kategori.pdf', [
            'data' => $data,
            'dicetak' => now()->format('d-m-Y H:i:s'),
        ]);
        return $pdf->download('kategori-' . $data->kode . '.pdf');
    }
}
