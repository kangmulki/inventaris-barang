<?php

namespace App\Http\Controllers;

use App\Exports\BarangKeluarExport;
use App\Models\BarangKeluar;
use App\Models\DataPusat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

Carbon::setLocale('id');

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if (!$tanggalAwal || !$tanggalAkhir) {
            $keluar = BarangKeluar::all()->map(function ($keluar) {
                // $keluar->tgl_keluar = Carbon::parse($keluar->tgl_keluar)->translatedFormat('l, d F Y');
                return $keluar;
            });
        } else {
            $keluar = BarangKeluar::whereBetween('tgl_keluar', [$tanggalAwal, $tanggalAkhir])->get();
        }

        foreach ($keluar as $data) {
            $data->formatted_tanggal = Carbon::parse($data->tgl_keluar)->translatedFormat('l, d F Y');
        }

        // download pdf
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('laporan.pdf_barangKeluar', compact('keluar'));
            return $pdf->download('laporan_barang_keluar.pdf'); //ini buat nama file download pdf
        }

        // download excel
        if ($request->has('download_excel')) {
            return Excel::download(new BarangKeluarExport($keluar), 'laporan_barangKeluar.xlsx');
        }

        confirmDelete('delete', 'Apakah Anda Yakin?');
        return view('BarangKeluar.index', compact('keluar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pusat = DataPusat::all();
        return view('barangkeluar.create', compact('pusat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'jumlah' => 'required',
            'tgl_keluar' => 'required',
            'ket' => 'required',
            'id_barang' => 'required',
        ], [
            'jumlah.required' => 'Jumlah Harus Diisi',
            'tgl_keluar.required' => 'Tanggal Keluar Harus Diisi',
            'ket.required' => 'Keterangan Harus Diisi',
            'id_barang.required' => 'Barang Harus Diisi',
        ]);

        $keluar = new BarangKeluar();
        $keluar->jumlah = $request->jumlah;
        $keluar->tgl_keluar = $request->tgl_keluar;
        $keluar->ket = $request->ket;
        $keluar->id_barang = $request->id_barang;

        $pusat = DataPusat::findOrFail($request->id_barang);
        if ($pusat->stok < $request->jumlah) {
            Alert::warning('Warning', 'Stok Tidak Cukup')->autoClose(1500);
            return redirect()->route('barangkeluar.index');
        } else {
            $pusat->stok -= $request->jumlah;
            $pusat->save();
        }

        $keluar->save();
        Alert::success('success', 'Data Berhasil Ditambahkan')->autoClose(1500);
        return redirect()->route('barangkeluar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keluar = BarangKeluar::findOrFail($id);
        return view('barangkeluar.show', compact('keluar'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keluar = BarangKeluar::findOrFail($id);
        $pusat = DataPusat::all();
        return view('barangkeluar.edit', compact('keluar', 'pusat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'jumlah' => 'required',
            'tgl_keluar' => 'required',
            'ket' => 'required',
            'id_barang' => 'required',
        ], [
            'jumlah.required' => 'Jumlah Harus Diisi',
            'tgl_keluar.required' => 'Tanggal Keluar Harus Diisi',
            'ket.required' => 'Keterangan Harus Diisi',
            'id_barang.required' => 'Barang Harus Diisi',
        ]);

        $keluar = BarangKeluar::findOrFail($id);
        $pusat = DataPusat::findOrFail($keluar->id_barang);

        if ($pusat->stok < $request->jumlah) {
            Alert::warning('Warning', 'Stok Tidak Cukup')->autoClose(1500);
            return redirect()->route('barangkeluar.index');
        } else {
            $pusat->stok += $keluar->jumlah;
            $pusat->stok -= $request->jumlah;
            // $pusat->stok = $pusat->stok - $keluar->jumlah + $request->jumlah;
            $pusat->save();
        }

        $keluar->update($request->all());

        $keluar->save();
        Alert::success('success', 'Data Berhasil Diubah')->autoClose(1500);
        return redirect()->route('barangkeluar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangKeluar  $barangKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keluar = BarangKeluar::findOrFail($id);
        $pusat = DataPusat::findOrFail($keluar->id_barang);
        $pusat->stok += $keluar->jumlah;
        $pusat->save();
        $keluar->delete();
        Alert::success('success', 'Data Berhasil Dihapus')->autoClose(1500);
        return redirect()->route('barangkeluar.index');
    }
}
