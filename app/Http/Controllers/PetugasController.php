<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petugas = User::where('is_admin', 0)->get();
        confirmDelete('Hapus Petugas!', 'Apakah Anda Yakin?');
        return view('petugas.index', compact('petugas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('petugas.create');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
            'email.unique' => 'Email Sudah Terdaftar',
            'password.required' => 'Password Harus Diisi',
            'password.min' => 'Password Minimal 8 Karakter',
        ]);

        $petugas = new User();
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->password = Hash::make($request->password);
        $petugas->save();

        Alert::success('Success', 'Data Berhasil Ditambahkan')->autoClose(1500);
        return redirect()->route('petugas.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ], [
            'name.required' => 'Nama Harus Diisi',
            'email.required' => 'Email Harus Diisi',
        ]);

        $petugas = User::findOrFail($id);
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->password = Hash::make($request->password);
        $petugas->save();

        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(1500);
        return redirect()->route('petugas.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();
        Alert::success('Success', 'Data Berhasil Dihapus')->autoClose(1500);
        return redirect()->route('petugas.index');
    }
}
