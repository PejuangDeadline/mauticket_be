<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Welcoming;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
use App\Mail\SendCode;

class ApiAuthController extends ApiBaseController
{
    public function storesignup(Request $request)
    {
        //dd($request->all());
        $namadepan = $request->namadepan;
        $namabelakang = $request->namabelakang;
        $email = $request->email;
        $phone = $request->phone;
        $username = $request->username;
        $password = $request->password;

        $CheckUsername = User::where('name', $username)->count();
        $CheckEmail = User::where('email', $email)->count();
        if($CheckUsername > 0){
            return $this->sendError('Error', ['error' => 'Username atau Email Sudah digunakan']);
        }
        if($CheckEmail > 0){
            return $this->sendError('Error', ['error' => 'Username atau Email Sudah digunakan']);
        }

        DB::beginTransaction();
        try{

            $createuser = User::create([
                'id_partner' => '0',
                'name' => $username,
                'firstname' => $namadepan,
                'lastname' => $namabelakang,
                'phonenumber' => $phone,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => "Customer",
                'is_active' => 0,
            ]);

            // Kirim Welcoming Email
            $recipient = $email;
            $namauser = $namadepan." ".$namabelakang;
            $sent=Mail::to($recipient)->send(new Welcoming($namauser));

            DB::commit();

            $success['username'] = $username;
            $success['email'] = $email;

            return $this->sendResponse($success, 'Pendaftaran Berhasil, Silahkan Login dengan akun anda');

        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError('Error', ['error' => 'Pendaftaran Gagal!']);
        }
    }

    public function sendToken(Request $request){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $token = substr(str_shuffle($characters), 0, 5);

        //Update token
        $updatetoken = User::where('id',$request->id_user)->update(['remember_token' => $token]);

        //Send Token to Email
        $sent=Mail::to($request->email)->send(new SendCode($token));

        $success['email'] = $request->email;
        $success['error'] = '0';

        return $this->sendResponse($success, 'Sukses Mengirim Email Token');
    }

    public function verifemail(Request $request){
        $email = $request->email;
        $code = $request->codeVerif;

        $user = User::where('email', $email)->first();
        if($code == $user->remember_token){
            // Update Is Active User
            $update = User::where('email', $email)->update(['is_active'=>1]);

            $success['email'] = $email;

            return $this->sendResponse($success, 'Sukses Verifikasi Email');
        } else {
            $error = 1;
            return $this->sendError('Error', [
                'error' => $error,
                'email' => $email,
                'message' => 'Gagal Verifikasi Email'
            ]);
        }
    }
}
