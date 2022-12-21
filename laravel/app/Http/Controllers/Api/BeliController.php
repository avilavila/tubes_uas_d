<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Beli;

class BeliController extends Controller
{
    public function index(){
        $belis = Beli::all();

        if(count($belis) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $belis
            ], 200); 
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); 
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'nama_produk' => 'required',
            'jumlah' => 'required',
        ]); 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        

        $beli = Beli::create($storeData);
        return response([
            'message' => 'Berhasil menambahkan pembelian!',
            'data' => $beli
        ], 200); 
    }

    public function show($id){
        $beli = Beli::find($id);

        if(!is_null($belis)){
            return response([
                'message' => 'Retrieve Beli Success',
                'data' => $beli
            ], 200);
        } 

        return response([
            'message' => 'Pembelian tidak ditemukan!',
            'data' => null
        ], 404); 
    }

    public function update(Request $request, $id){
        $beli = Beli::find($id);

        if(is_null($beli)){
            return response([
                'message' => 'Pembelian tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama' => ['required'],
            'nama_produk' => 'required',
            'jumlah' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $beli->nama = $updateData['nama'];
        $beli->nama_produk = $updateData['nama_produk'];
        $beli->jumlah = $updateData['jumlah'];

        if($beli->save()){
            return response([
                'message' => 'Berhasil mengupdate pembelian!',
                'data' => $beli
            ], 200);
        }

        return response([
            'message' => 'Gagal mengupdate pembelian!',
            'data' => null,
        ], 400); 
    }

    public function destroy($id){
        $beli = Beli::find($id);

        if(is_null($beli)){
            return response([
                'message' => 'Pembelian tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        if($beli->delete()){
            return response([
                'message' => 'Berhasil menghapus pembelian!',
                'data' => $beli
            ], 200);
        } 

        return response([
            'message' => 'Gagal menghapus pembelian!',
            'data' => null,
        ], 400); 
    }
}