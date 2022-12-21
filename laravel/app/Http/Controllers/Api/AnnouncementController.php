<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index(){
        $announcements = Announcement::all();

        if(count($announcements) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $announcements
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
            'nama_produk' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]); 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        

        $announcement = Announcement::create($storeData);
        return response([
            'message' => 'Berhasil menambahkan pengumuman!',
            'data' => $announcement
        ], 200); 
    }

    public function show($id){
        $announcement = Announcement::find($id);

        if(!is_null($announcements)){
            return response([
                'message' => 'Retrieve Announcement Success',
                'data' => $announcement
            ], 200);
        } 

        return response([
            'message' => 'Pengumuman tidak ditemukan!',
            'data' => null
        ], 404); 
    }

    public function update(Request $request, $id){
        $announcement = Announcement::find($id);

        if(is_null($announcement)){
            return response([
                'message' => 'Pengumuman tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_produk' => ['required'],
            'status' => 'required',
            'keterangan' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $announcement->nama_produk = $updateData['nama_produk'];
        $announcement->status = $updateData['status'];
        $announcement->keterangan = $updateData['keterangan'];

        if($announcement->save()){
            return response([
                'message' => 'Berhasil mengupdate pengumuman!',
                'data' => $announcement
            ], 200);
        }

        return response([
            'message' => 'Gagal mengupdate pengumuman!',
            'data' => null,
        ], 400); 
    }

    public function destroy($id){
        $announcement = Announcement::find($id);

        if(is_null($announcement)){
            return response([
                'message' => 'Pengumuman tidak ditemukan!',
                'data' => null
            ], 404); 
        }

        if($announcement->delete()){
            return response([
                'message' => 'Berhasil menghapus pengumuman!',
                'data' => $announcement
            ], 200);
        } 

        return response([
            'message' => 'Gagal menghapus pengumuman!',
            'data' => null,
        ], 400); 
    }
}