<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function BecomeVendor(): View
    {
        return View('auth.become_vendor');
    }
    public function VendorRegister(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string','max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'vendor',
            'status' => 'inactive',
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('vendor.login')->with([
            'message' => 'Vendor Registered successfully',
            'alert-type' => 'success',
        ]);

    }
    public function VendorLogin()
    {
        return view('vendor.vendor_login');
    }
    public function VendorDashboard()
    {
        return view('vendor.index');
    }
    public function VendorDestroy(Request $request):RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('vendor/login');
    }
    public function VendorProfile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('vendor.profile',['user' => $user]);
    }
    public function VendorProfileStore(Request $request):RedirectResponse
    {
        $id               = Auth::user()->id;
        $data             = User::find($id);
        $data->name       = $request->name;
        $data->email      = $request->email;
        $data->phone      = $request->phone;
        $data->address    = $request->address;
        $data->vendor_description = $request->vendor_description;
        $data->created_at = Carbon::now();
        if($request->file('image')){
            $file       = $request->file('image');
            @unlink(public_path('upload/vendor_image/'.$data->image));
            $filename   = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/vendor_image/'),$filename);
            $data['image'] = $filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Vendor Profile updated successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);

    }
    public function VendorChangePassword(){
        return view('vendor.change_password');
    }
    public function VendorUpdatePassword(Request $request): RedirectResponse
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
