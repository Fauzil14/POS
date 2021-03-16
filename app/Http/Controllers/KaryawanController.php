<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    public function index() 
    {
        $karyawans = User::whereHas('roles', function($query) {
            return $query->where('business_id', Auth::user()->roles->pluck('pivot.business_id')->first());
        })->get();

        $roles = Role::get();

        return view('karyawan.index', compact('karyawans', 'roles'));
    }

    public function createKaryawan(Request $request)
    {
        $validatedData = $request->validate([
            'name'            => 'required',
            'email'           => 'required|unique:users',
            'password'        => 'required|min:8',
            'umur'            => 'required|integer|max:60',
            'alamat'          => 'required',
            'role_id'         => 'required|exists:roles,id',
            'profile_picture' => 'sometimes|image|max:2048|mimes:jpg,jpeg,png'
        ]);

        $user = new User;
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->umur = $validatedData['umur'];
        $user->alamat = $validatedData['alamat'];
        if(!empty($validatedData['profile_picture'])) {
            $user->profile_picture = $this->uploadImage($validatedData['profile_picture']);
        }
        $user->save(); 
    
        $role = Role::find($validatedData['role_id']);
        $user->assignRole($role->role_name, Auth::user()->roles->pluck('pivot.business_id')->first());

        if ($request->wantsJson()) {
            return response()->json([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'umur' => $validatedData['umur'],
                'alamat' => $validatedData['alamat'],
                'role' => $role->role_name,
            ]);
        }
    }

    public function show($karyawan_id)
    {
        $karyawan = User::findOrFail($karyawan_id);
        $karyawan = $karyawan->makeVisible('encrypted_password');
        $karyawan = $karyawan->load('roles');
        $arr = $karyawan->toArray();
        foreach($arr as $key => $value) {
            if($key == 'encrypted_password') {
                $password = Crypt::decrypt($value);
            }
        }

        $allroles = Role::all();

        return view('karyawan.detail-karyawan', compact('karyawan', 'password', 'allroles'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $validatedData = $request->validate([
            'name'            => 'required',
            'email'           => ['required', Rule::unique('users')->ignore($user->id)],
            'password'        => 'required|min:8',
            'umur'            => 'required|integer|max:60',
            'alamat'          => 'required',
            'role_id'         => 'required|exists:roles,id',
            'profile_picture' => 'sometimes|image|max:2048|mimes:jpg,jpeg,png'
        ]);


        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->umur = $validatedData['umur'];
        $user->alamat = $validatedData['alamat'];
        if(!empty($validatedData['profile_picture'])) {
            $user->profile_picture = $this->uploadImage($validatedData['profile_picture']);
        }
        $user->update(); 
        

        $role = Role::find($validatedData['role_id']);
        if( $user->role !== $role->role_name) {
            $user->roles()->updateExistingPivot($validatedData['role_id'], [
                'business_id' => $user->roles()->pluck('pivot.business_id')->first(),
                'kode_user' => $user->roles()->pluck('pivot.kode_user')->first(),
            ]);

        }

        return response()->json([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'umur' => $validatedData['umur'],
            'alamat' => $validatedData['alamat'],
            'role' => $role->role_name,
        ]);

    }

    public function delete($karyawan_id)
    {
        $karyawan = User::findOrFail($karyawan_id);

        try {
            $karyawan->delete();
    
            Alert::success('Berhasil', 'Karyawan berhasil di hapus');
            return redirect()->route('karyawan');
        } catch(\Throwable $e) {
            Alert::error('Gagal', 'Karyawan gagal di hapus');
            return back();
        }
    }
}
