<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function UserDashboard(Request $request)
    {
        $userdata = $request->user();
        return view('index',['userdata' => $userdata]);

        // YOU can use any of this mehod

        // $id = Auth::user()->id;
        // $user = User::find($id);
        // return view('index',['user' => $user]);
    }
    public function UserStore(Request $request)
    {

        $id               = Auth::user()->id;
        $data             = User::find($id);
        $data->username       = $request->username;
        $data->name      = $request->name;
        $data->email      = $request->email;
        $data->phone      = $request->phone;
        $data->address    = $request->address;
        $data->updated_at = Carbon::now();
        if($request->file('image')){
            $file       = $request->file('image');
            @unlink(public_path('upload/user_image/'.$data->image));
            $filename   = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_image/'),$filename);
            $data['image'] = $filename;
        }
        $data->save();
        $notification = array(
            'message' => 'User Profile updated successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }
    public function UserChangePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:6',
        ],['current_password' => 'The old password is incorrect']
        );

        // User::whereId(Auth::user()->id)->update([
        //     'password' => Hash::make($request->password)
        // ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with([
            'message' => 'Password updated successfully',
            'alert-type' => 'success',
        ]);
    }
    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification = array(
            'message' => 'User Logout successfully',
            'alert-type' => 'success',
        );


        return redirect('login')->with($notification);
    }
}
