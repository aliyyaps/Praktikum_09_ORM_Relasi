<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination 
        // $mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel

        // Tugas Praktikum 7 No 2
        // Mengambil 3 data tabel
        // $mahasiswa = $mahasiswa = DB::table('mahasiswa')->paginate(3);

        // Praktikum 1 JS 9 (Langkah 18)
        //yang semula Mahasiswa::all, diubah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();

        // Mengambil semua isi tabel 
        $posts = Mahasiswa::orderBy('id', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Praktikum 1 JS 9 (Langkah 21)
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);

        // return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas' => 'required',
            'Jurusan' => 'required',

            // Tugas Praktikum 7 No 1
            'Email' => ['required', 'Email:dns'],
            'Alamat' => 'required',
            'Tanggal_lahir' => 'required',
        ]);

        // Praktikum 1 JS 9 (Langkah 24)
        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        // $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_lahir');

        $idkelas = $request->get('kelas');
        $kelas = Kelas::find($idkelas);

        // //fungsi eloquent untuk menambah data
        // Mahasiswa::create($request->all());
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        //code sebelum dibuat relasi --> $Mahasiswa = Mahasiswa::find($Nim);
        // Praktikum 1 JS 9 (Langkah 26)
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = DB::table('mahasiswa')->where('nim', $Nim)->first();
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $data = $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',

            // Tugas Praktikum 7 No 1
            'Email' => ['required', 'Email:dns'],
            'Alamat' => 'required',
            'Tanggal_lahir' => 'required',
        ]);

        //fungsi eloquent untuk mengupdate data inputan kita
        Mahasiswa::find($Nim)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }

    // Tugas Praktikum 7 No 3
    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswa = Mahasiswa::where('nama', 'like', "%" . $keyword . "%")->paginate(3);
        return view(view: 'mahasiswa.index', data: compact(var_name: 'mahasiswa'));
    }
}
