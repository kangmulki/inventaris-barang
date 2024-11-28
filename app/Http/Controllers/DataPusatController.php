<?php

namespace App\Http\Controllers;

use App\Exports\DataPusatExport;
use App\Models\DataPusat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DataPusatController extends Controller
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
        $datapusat = DataPusat::all();

        // download pdf
        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('laporan.pdf_dataPusat', compact('datapusat'));
            return $pdf->download('laporan_data_pusat.pdf'); //ini buat download pdf
        }

        // download excel
        if ($request->has('download_excel')) {
            return Excel::download(new DataPusatExport($datapusat), 'laporan_dataPusat.xlsx');
        }

        confirmDelete('delete', 'Apakah Anda Yakin?');
        return view('datapusat.index', compact('datapusat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('datapusat.create');
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
            'nama' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nama.required' => 'Nama Harus Diisi',
            'merek.required' => 'Merek Harus Diisi',
            'foto.required' => 'Foto Harus Diisi',
        ]);

        $datapusat = new DataPusat;

        $lastRecord = DataPusat::latest('id')->first();
        $lastId = $lastRecord ? $lastRecord->id : 0;
        $kodeBarang = 'BRG-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $datapusat->kode_barang = $kodeBarang;
        $datapusat->nama = $request->nama;
        $datapusat->merek = $request->merek;

        if ($request->hasFile('foto')) {
            $img = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/foto/datapusat', $name);
            $datapusat->foto = $name;
        }

        $datapusat->save();
        Alert::success('Success', 'Data Berhasil Ditambahkan')->autoClose(1500);
        return redirect()->route('datapusat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataPusat  $dataPusat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datapusat = DataPusat::findOrFail($id);
        return view('datapusat.show', compact('datapusat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataPusat  $dataPusat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datapusat = DataPusat::findOrFail($id);
        return view('datapusat.edit', compact('datapusat'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataPusat  $dataPusat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'nama.required' => 'Nama Harus Diisi',
            'merek.required' => 'Merek Harus Diisi',
        ]);

        $datapusat = DataPusat::findOrFail($id);
        $datapusat->nama = $request->nama;
        $datapusat->merek = $request->merek;

        if ($request->hasFile('foto')) {

            $fotoLama = $datapusat->foto;
            if ($fotoLama && file_exists(public_path('images/foto/datapusat/' . $fotoLama))) {
                unlink(public_path('images/foto/datapusat/' . $fotoLama));
            }

            $img = $request->file('foto');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move(public_path('images/foto/datapusat'), $name);
            $datapusat->foto = $name;

        }

        $datapusat->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(1500);
        return redirect()->route('datapusat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataPusat  $dataPusat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datapusat = DataPusat::findOrFail($id);

        if ($datapusat->foto && file_exists(public_path('images/foto/datapusat/' . $datapusat->foto))) {
            unlink(public_path('images/foto/datapusat/' . $datapusat->foto));
        }

        $datapusat->delete();
        Alert::success('Success', 'Data Berhasil Dihapus')->autoClose(1500);
        return redirect()->route('datapusat.index');
    }
}
