<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function dashboard(){
dd(auth()->user());
return view('dashboard');
        }


    public function index(){

        $data = User ::get();

        return view('index', compact('data'));

    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
          dd($request->all());
       $validator = Validator::make($request->all(),[
        'username' => 'required|string',
        'name' => 'required',
        'password' => 'required',
        'role'  => 'required',
       ]);

       if($validator->fails()) return redirect()->back()-> withInput()-> withErrors($validator);

       $data['username'] = $request->username;
       $data['name'] = $request->name;
       $data['password'] = Hash::make($request->password);
       $data['role'] = $request->role;

       User::create($data);

       return redirect()->route('index');
    }
    public function edit(Request $request,$id ){
        $data = User::find($id);
         //dd($data);

         return view('edit', compact('data'));


    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'nullable',
            'role' => 'required|in:petugas,kasi,kabid,pelayanan'
           ]);

           if($validator->fails()) return redirect()->back()-> withInput()-> withErrors($validator);

           $data['email'] = $request->email;
           $data['name'] = $request->name;
           if($request->password){
            $data['password'] = Hash::make($request->password);
            $data['role'] = $request->role;

           }
           User::whereId($id)->update($data);

           return redirect()->route('index');
    }
    public function delete(Request $request, $id){
        $data =User::find($id);

        if($data){
            $data->delete();
        }
        return redirect()->route('index');
    }
}
