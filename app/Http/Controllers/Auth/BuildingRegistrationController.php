<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuildingRegistrationController extends Controller
{
    public function showForm()
    {
        return view('auth.building-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'admin_name'     => 'required',
            'email'          => 'required|email|unique:users,email',
            'phone'          => ['required', 'regex:/^[0-9]{10}$/'],
            'password'       => 'required|confirmed|min:6',
            'building_name'  => 'required',
            'city'           => 'required',
            'state'          => 'required',
            'pincode'        => 'required',
            'country'        => 'required',
            'address'        => 'required',
            'total_flats'    => 'required|integer|min:1',
        ], [
            'phone.regex' => 'Phone number must be exactly 10 digits.'
        ]);

        // GET Building Admin Role
        $role = Role::where('name', 'Building Admin')->firstOrFail();

        // 1️⃣ Create User (without building_id for now)
        $user = User::create([
            'name'     => $request->admin_name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role_id'  => $role->id,
            'status'   => 'active',  // self activate
        ]);

        // 2️⃣ Create Building
        $building = Building::create([
            'name'              => $request->building_name,
            'city'              => $request->city,
            'state'             => $request->state,
            'pincode'           => $request->pincode,
            'country'           => $request->country,
            'address'           => $request->address,
            'total_flats'       => $request->total_flats,
            'building_admin_id' => $user->id,
            'status'            => 'inactive', // no subscription yet
        ]);

        // 2b️⃣ Assign building_id to user
        $user->building_id = $building->id;
        $user->save();

        // 3️⃣ Auto login
        Auth::login($user);

        // 4️⃣ Redirect to upgrade plan (subscription setup) page
        return redirect('/building-admin/subscription/setup?upgrade=1');
    }
}
