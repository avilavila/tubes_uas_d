<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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

    public function show($id){
        $announcement = Announcement::find($id);

        if(!is_null($announcements)){
            return response([
                'message' => 'Retrieve Announcement Success',
                'data' => $announcement
            ], 200);
        } 

        return response([
            'message' => 'Announcements Not Found',
            'data' => null
        ], 404); 
    }

    public function store(Request $request){
        $announcementData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_produk' => 'required',
            'status' => 'required',
            'keterangan' => 'required',
        ]); 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        

        $announcement = Announcement::create($storeData);
        return response([
            'message' => 'Add Announcement Success',
            'data' => $announcement
        ], 200); 
    }

    public function destroy($id){
        $announcement = Announcement::find($id);

        if(is_null($announcement)){
            return response([
                'message' => 'Announcement Not Found',
                'data' => null
            ], 404); 
        }

        if($announcement->delete()){
            return response([
                'message' => 'Delete Announcement Success',
                'data' => $announcement
            ], 200);
        } 

        return response([
            'message' => 'Delete Announcement Failed',
            'data' => null,
        ], 400); 
    }

    public function update(Request $request, $id){
        $announcement = Announcement::find($id);

        if(is_null($announcement)){
            return response([
                'message' => 'Announcement Not Found',
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
                'message' => 'Update Announcement Success',
                'data' => $announcement
            ], 200);
        }

        return response([
            'message' => 'Update Announcement Failed',
            'data' => null,
        ], 400); 
    }
}
