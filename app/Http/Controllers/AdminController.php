<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function AdminDashboard()
    {
        return view('admin.index');
    }
    public function AdminDestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('admin.profile',['user' => $user]);
    }
    public function AdminProfileStore(Request $request):RedirectResponse
    {
        $id               = Auth::user()->id;
        $data             = User::find($id);
        $data->name       = $request->name;
        $data->email      = $request->email;
        $data->phone      = $request->phone;
        $data->address    = $request->address;
        if($request->file('image')){
            $file       = $request->file('image');
            @unlink(public_path('upload/admin_image/'.$data->image));
            $filename   = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_image/'),$filename);
            $data['image'] = $filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Admin Profile updated successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }
    public function AdminChangePassword(){
        return view('admin.change_password');
    }
    public function AdminUpdatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:6',
        ],['current_password' => 'The old password is incorrect']
    );

        // User::whereId(Auth::ser()->id)->update([
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
}
