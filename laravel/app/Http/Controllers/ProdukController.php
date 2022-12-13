<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Http\Resources\ProdukResource;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{

    public function index(){
        $produk = Produk::latest()->paginate(5);
        return new ProdukResource(true, 'List Data Produk', $produk);
    }

    public function create(){
        return view('produk.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'kategori_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'kategori_produk' => $request->kategori_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga' => $request->harga,
        ]);
        return new ProdukResource(true, 'Data Produk Berhasil Ditambahkan!', $produk);   
    }

    public function edit($id){
        $produk = produk::find($id);
        return view('produk.edit', compact('produk'));
    }
    public function show($id)
    {
    $produk = produk::find($id);
    return new ProdukResource(true,'Data Produk Ditemukan', $produk);
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'nama_produk' => 'required',
            'kategori_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga' => 'required',
        ]);
        //Fungsi Update Data ke dalam Database
        $produk = Produk::find($id);
        $produk->update([
            $produk->nama_produk = $request->nama_produk,
            $produk->kategori_produk = $request->kategori_produk,
            $produk->jumlah_produk = $request->jumlah_produk,
            $produk->harga = $request->harga,
        ]);
        
        return new ProdukResource(true, 'Data Berhasil Diupdate!', $produk);
        
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */

     public function destroy($id){
        $produk = Produk::find($id);
        $produk->delete();
        return new ProdukResource(true, 'Produk Berhasil Didelete!', $produk);
    }
    
}
