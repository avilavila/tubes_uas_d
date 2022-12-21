<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index($id){
        $user = User::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User tidak ditemukan!',
            'data' => null
        ], 404);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User tidak ditemukan!',
            'data' => null
        ], 404);
    }


    public function update(Request $request, $id){
        $user = User::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User tidak ditemukan!',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns',
            'username' => ['required', Rule::unique('users')->ignore($user)],
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        $user->name = $updateData['name'];
        $user->email = $updateData['email'];
        $user->username = $updateData['username'];
        
        if($user->save()){
            return response([
            'message' => 'Berhasil mengupdate akun profile!',
            'data' => $user,
            ],200);
        }

        return response([
            'message' => 'Gagal mengupdate akun profile!',
            'data' => null
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(is_null($user)){
            return response([
                'message' => 'User tidak ditemukan!',
                'data' => null
            ], 404);
        }

        if($user->delete()){
            return response([
                'message' => 'Berhasil menghapus akun!',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Gagal menghapus akun!',
            'data' => null
        ], 400);
    }
}