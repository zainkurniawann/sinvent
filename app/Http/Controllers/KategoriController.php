<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //  private $aKategori = array(
    //     'blank' => 'Pilih Kategori',
    //     'M' => 'Barang Modal',
    //     'A' => 'Alat',
    //     'BHP' => 'Bahan Habis Pakai',
    //     'BTHP' => 'Bahan Tidak Habis Pakai'
    // );

/**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        if ($search) {
            $rsetKategori = DB::table('kategori')
                            ->select('id', 'deskripsi', DB::raw('getKategori(kategori) COLLATE utf8mb4_unicode_ci as kat'))
                            ->where('id', 'like', '%' . $search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $search . '%')
                            ->orWhere('kategori', 'like', '%' . $search . '%')
                            ->orWhere(DB::raw('getKategori(kategori) COLLATE utf8mb4_unicode_ci'), 'like', '%' . $search . '%')
                            ->paginate(5);
        } else {
            $rsetKategori = DB::table('kategori')
                            ->select('id', 'deskripsi', DB::raw('getKategori(kategori) COLLATE utf8mb4_unicode_ci as kat'))
                            ->paginate(5);
        
        }
    
        return view('v_kategori.index', compact('rsetKategori'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Kategori Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('v_kategori.create',compact('akategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $request->validate([
            'deskripsi'              => 'required', 
            'kategori'              => 'required',
        ]);


        //create post
        Kategori::create([
            'deskripsi'          => $request->deskripsi,
            'kategori'          => $request->kategori,
        ]);

        //redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetKategori = Kategori::find($id);
        

        return view('v_kategori.show', compact('rsetKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Kategori Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );

        $rsetKategori = Kategori::find($id);
        //return $rsetKategori;
        return view('v_kategori.edit', compact('rsetKategori','akategori'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'deskripsi' => 'required',
        'kategori' => 'required',
    ]);

    $rsetKategori = Kategori::find($id);
    $rsetKategori->update($request->all());

    return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()){ 
            return redirect()->route('kategori.index')->with(['Gagal' => 'Gagal dihapus']);
        } else {
            $rseKategori = Kategori::find($id);
            $rseKategori->delete();
            return redirect()->route('kategori.index')->with(['Success' => 'Berhasil dihapus']);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('search');
        $rsetResults = DB::select('CALL SearchKategori(?)', [$query]);

        $aKategori = $this->aKategori;

        return view('v_kategori.search', compact('rsetResults', 'query', 'aKategori'));
    }
    
}