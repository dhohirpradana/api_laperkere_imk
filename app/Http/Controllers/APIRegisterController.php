<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Response;
use Validator;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'nama' => 'required',
            'password' => 'required',
            'hp' => 'required',
            'foto' => 'required',
            'is_deleted' => 'require',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('nApp')->accessToken;
        $success['nama'] = $user->nama;

        return response()->json(['success' => $success], $this->successStatus);
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'nama' => 'required',
    //         'password' => 'required',
    //         'hp' => 'required',
    //         'foto' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors());
    //     }
    //     $rand = strftime("%Y", time());
    //     User::create([
    //         'nama' => $request->get('nama'),
    //         'email' => $request->get('email'),
    //         'password' => bcrypt($request->get('password')),
    //         'hp' => $request->get('hp'),
    //         'foto' => $request->get('foto'),
    //         'is_deleted' => 0,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);
    //     $user = User::first();
    //     $token = JWTAuth::fromUser($user);
    //     // $success['token'] =  $user->createToken('nApp')->accessToken;
    //     // $success['name'] =  $user->name;

    //     // return Response::json(compact('token'));
    // }
}
