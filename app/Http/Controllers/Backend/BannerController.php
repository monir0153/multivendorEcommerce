<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function AllBanner(){
        $banner = Banner::latest()->get();
        return view('backend.banner.banner_all',['banner' => $banner]);
    }
    public function AddBanner() :View
    {
        return view('backend.banner.banner_add');
    }
    public function StoreBanner(Request $request)
    {
        $images = $request->file('banner_image');
        $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
        Image::make($images)->resize(768,450)->save('upload/banner/'.$name_gen);
        $save_url = 'upload/banner/'.$name_gen;

        Banner::insert([
            'banner_title' => $request->banner_title,
            'banner_url' => $request->banner_url,
            'banner_image' => $save_url,
        ]);

        return redirect()->route('all.banner')->with([
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success',
        ]);
    }
    public function EditBanner($id)
    {
        $banner = Banner::findorFail($id);
        return view('backend.banner.banner_edit',compact('banner'));
    }
    public function UpdateBanner(Request $request,$id)
    {
        $old_image = $request->old_image;

        if($request->file('banner_image'))
        {
            $images = $request->file('banner_image');
            $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(768,450)->save('upload/banner/'.$name_gen);
            $save_url = 'upload/banner/'.$name_gen;

            if(file_exists($old_image)){
                unlink($old_image);
            }

            Banner::findorFail($id)->update([
                'banner_title' => $request->banner_title,
                'banner_url' => $request->banner_url,
                'banner_image' => $save_url,
            ]);

            return redirect()->route('all.banner')->with([
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        else {
            Banner::findorFail($id)->update([
                'banner_title' => $request->banner_title,
                'banner_url' => $request->banner_url,
            ]);

            return redirect()->route('all.banner')->with([
                'message' => 'Banner updated successfully',
                'alert-type' => 'success',
            ]);
        }
    }
    public function DeleteBanner($id)
    {
        $banner = Banner::findorFail($id);
        $img = $banner->banner_image;
        if(file_exists($img)){
            unlink($img);
        }

        Banner::findOrFail($id)->delete();

        return redirect()->route('all.banner')->with([
            'message' => 'Banner Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
