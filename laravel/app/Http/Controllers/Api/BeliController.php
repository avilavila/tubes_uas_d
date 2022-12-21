<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beli as AppBeli;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BeliController extends Controller
{
    public function index(){
        $belis = AppBeli::all();

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

    public function show($id){
        $belis = AppBeli::find($id);

        if(!is_null($belis)){
            return response([
                'message' => 'Retrieve Success',
                'data' => $belis
            ], 200);
        } 

        return response([
            'message' => 'Tidak ditemukan!',
            'data' => null
        ], 404); 
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'nama_produk' => 'required',
            'jumlah' => 'required'
        ]); 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $beli = AppBeli::create($storeData);
        return response([
            'message' => 'Berhasil menambahkan Beli!',
            'data' => $beli
        ], 200); 
    }

    public function destroy($id){
        $beli = AppBeli::find($id);

        if(is_null($beli)){
            return response([
                'message' => 'Tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        if($beli->delete()){
            return response([
                'message' => 'Berhasil menghapus Beli!',
                'data' => $beli
            ], 200);
        } 

        return response([
            'message' => 'Gagal menghapus!',
            'data' => null,
        ], 400); 
    }

    public function update(Request $request, $id){
        $beli = AppBeli::find($id);

        if(is_null($beli)){
            return response([
                'message' => 'Tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama' => 'required',
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
                'message' => 'Berhasil mengupdate Beli!',
                'data' => $beli
            ], 200);
        }

        return response([
            'message' => 'Gagal mengupdate!',
            'data' => null,
        ], 400); 
    }
}
