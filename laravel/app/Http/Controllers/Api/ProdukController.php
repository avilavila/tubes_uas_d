<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProdukResource;

class ProdukController extends Controller
{
    
    public function index(){
        $produks = Produk::all();

        if(count($produks) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $produks
            ], 200); 
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); 
    }

    public function show($id){
        $produk = Produk::find($id);

        if(!is_null($produks)){
            return response([
                'message' => 'Retrieve Produk Success',
                'data' => $produk
            ], 200);
        } 

        return response([
            'message' => 'Produk tidak ditemukan!',
            'data' => null
        ], 404); 
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_produk' => 'required',
            'kategori_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga' => 'required',
        ]); 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $produk = Produk::create($storeData);
        return response([
            'message' => 'Berhasil menambahkan produk!',
            'data' => $produk
        ], 200); 
    }

    public function destroy($id){
        $produk = Produk::find($id);

        if(is_null($produk)){
            return response([
                'message' => 'Produk tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        if($produk->delete()){
            return response([
                'message' => 'Berhasil menghapus produk!',
                'data' => $produk
            ], 200);
        } 

        return response([
            'message' => 'Gagal menghapus produk!',
            'data' => null,
        ], 400); 
    }

    public function update(Request $request, $id){
        $produk = Produk::find($id);

        if(is_null($produk)){
            return response([
                'message' => 'Produk tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_produk' => ['required'],
            'kategori_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $produk->nama_produk = $updateData['nama_produk'];
        $produk->kategori_produk = $updateData['kategori_produk'];
        $produk->jumlah_produk = $updateData['jumlah_produk'];
        $produk->harga = $updateData['harga'];

        if($produk->save()){
            return response([
                'message' => 'Berhasil mengupdate produk!',
                'data' => $produk
            ], 200);
        }

        return response([
            'message' => 'Gagal mengupdate produk!',
            'data' => null,
        ], 400); 
    }
    // public function index(){
    //     $produk = Produk::latest()->paginate(5);
    //     return new ProdukResource(true, 'List Data Produk', $produk);
    // }

    // public function create(){
    //     return view('produk.create');
    // }

    // public function store(Request $request){

    //     $validator = Validator::make($request->all(), [
    //         'nama_produk' => 'required',
    //         'kategori_produk' => 'required',
    //         'jumlah_produk' => 'required',
    //         'harga' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }
    //     //Fungsi Post ke Database
    //     $produk = Produk::create([
    //         'nama_produk' => $request->nama_produk,
    //         'kategori_produk' => $request->kategori_produk,
    //         'jumlah_produk' => $request->jumlah_produk,
    //         'harga' => $request->harga,
    //     ]);
    //     return new ProdukResource(true, 'Data Produk Berhasil Ditambahkan!', $produk);   
    // }

    // public function edit($id){
    //     $produk = produk::find($id);
    //     return view('produk.edit', compact('produk'));
    // }
    // public function show($id)
    // {
    // $produk = produk::find($id);
    // return new ProdukResource(true,'Data Produk Ditemukan', $produk);
    // }

    // public function update(Request $request, $id){

    //     $this->validate($request, [
    //         'nama_produk' => 'required',
    //         'kategori_produk' => 'required',
    //         'jumlah_produk' => 'required',
    //         'harga' => 'required',
    //     ]);
    //     //Fungsi Update Data ke dalam Database
    //     $produk = Produk::find($id);
    //     $produk->update([
    //         $produk->nama_produk = $request->nama_produk,
    //         $produk->kategori_produk = $request->kategori_produk,
    //         $produk->jumlah_produk = $request->jumlah_produk,
    //         $produk->harga = $request->harga,
    //     ]);
        
    //     return new ProdukResource(true, 'Data Berhasil Diupdate!', $produk);
        
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  * 
    //  * @param int $id
    //  * @return \Illuminate\Http\Response
    //  */

    //  public function destroy($id){
    //     $produk = Produk::find($id);
    //     $produk->delete();
    //     return new ProdukResource(true, 'Produk Berhasil Didelete!', $produk);
    // }
    
}
