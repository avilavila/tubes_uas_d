<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Http\Resources\AnnouncementResource;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function index(){
        $announcement = Announcement::latest()->get();
        return new AnnouncementResource(true, 'List Pengumuman', $announcement);
    }

    public function create(){
        return view('announcement.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $announcement = Announcement::create([
            'nama_produk' => $request->nama_produk,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);
        return new AnnouncementResource(true, 'Pengumuman Berhasil Ditambahkan!', $announcement);   
    }

    public function edit($id){
        $announcement = Announcement::find($id);
        return view('announcement.edit', compact('announcement'));
    }
    public function show($id)
    {
    $announcement = Announcement::find($id);
    return new AnnouncementResource(true,'Pengumuman Ditemukan', $announcement);
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'nama_produk' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]);
        //Fungsi Update Data ke dalam Database
        $announcement = Announcement::find($id);
        $announcement->update([
            $announcement->nama_produk = $request->nama_produk,
            $announcement->status = $request->status,
            $announcement->keterangan = $request->keterangan,
        ]);
        
        return new AnnouncementResource(true, 'Pengumuman Berhasil Diupdate!', $announcement);
        
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */

     public function destroy($id){
        $announcement = Announcement::find($id);
        $announcement->delete();
        return new AnnouncementResource(true, 'Pengumuman Berhasil Dihapus!', $announcement);
    }
}
