<?php

namespace App\Http\Controllers;

use App\Exports\PengembalianExport;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

Carbon::setLocale('id');

class PengembalianController extends Controller
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
            $kembali = Peminjaman::where('status', 'Sudah Dikembalikan')->get();
        } else {
            $kembali = Peminjaman::where('status', 'Sudah Dikembalikan')
                ->whereBetween('tgl_kembali', [$tanggalAwal, $tanggalAkhir])
                ->get();
        }

        foreach ($kembali as $data) {
            $data->formatted_tanggal = Carbon::parse($data->tgl_kembali)->translatedFormat('l, d F Y');
        }

        if ($request->has('download_pdf')) {
            $pdf = PDF::loadView('laporan.pdf_pengembalian', compact('kembali'));
            return $pdf->download('laporan_pengembalian.pdf');
        }

        // download excel
        if ($request->has('download_excel')) {
            return Excel::download(new PengembalianExport($kembali), 'laporan_pengeluaran.xlsx');
        }

        return view('pengembalian.index', compact('kembali'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function show(Pengembalian $pengembalian)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengembalian $pengembalian)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengembalian $pengembalian)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengembalian  $pengembalian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengembalian $pengembalian)
    {

    }
}
