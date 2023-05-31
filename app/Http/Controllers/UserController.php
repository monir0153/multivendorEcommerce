<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
}
