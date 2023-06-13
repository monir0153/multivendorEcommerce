<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function AdminLogin()
    {
        return view('admin.admin_login');
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
        $notification = array(
            'message' => 'Admin Logout successfully',
            'alert-type' => 'success',
        );

        return redirect('admin/login')->with($notification);
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
        $data->updated_at = Carbon::now();
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

    public function InactiveVendor()
    {
        $inactivevendor = User::where('role', 'vendor')->where('status', 'inactive')->latest()->get();
        return view('backend.vendor.inactive_vendor',compact('inactivevendor'));
    }
    public function ActiveVendor()
    {
        $activevendor = User::where('role', 'vendor')->where('status', 'active')->latest()->get();
        return view('backend.vendor.active_vendor',compact('activevendor'));
    }
    public function InactiveVendorDetails($id)
    {
        $vendoruser = User::findorFail($id);
        return view('backend.vendor.inactive_vendor_details',compact('vendoruser'));
    }
}
