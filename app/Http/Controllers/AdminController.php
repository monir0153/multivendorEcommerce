<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
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
            $filename   = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_image'),$filename);
            $data['image'] = $filename;
        }
        $data->save();
        return redirect()->back();

    }
}
