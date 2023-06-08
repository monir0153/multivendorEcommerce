<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandController extends Controller
{
    public function AllBrand()
    {
        $brands = Brand::latest()->get();
        return view('backend.brand.brand_all',['brands' => $brands]);
    }
    public function AddBrand()
    {
        return view('backend.brand.brand_add');
    }
    public function StoreBrand(Request $request): RedirectResponse
    {
        $images = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
        Image::make($images)->resize(512,300)->save('upload/brand/'.$name_gen);
        $save_url = 'upload/brand/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
            'brand_image' => $save_url,
        ]);

        $notification = array([
            'message' => 'Brand Inserted Successfully',
            'alert-type' => 'success',
        ]);

        return redirect()->route('all.brand')->with($notification);
    }
    public function EditBrand($id)
    {
        $brand = Brand::findorFail($id);
        return view('backend.brand.brand_edit',compact('brand'));
    }
    public function UpdateBrand(Request $request)
    {
        $brand_id = $request->id;
        $old_image = $request->old_image;

        if($request->file('brand_image'))
        {
            $images = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(512,300)->save('upload/brand/'.$name_gen);
            $save_url = 'upload/brand/'.$name_gen;

            if(file_exists($old_image)){
                unlink($old_image);
            }

            Brand::findorFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
                'brand_image' => $save_url,
            ]);

            return redirect()->route('all.brand')->with([
                'message' => 'Brand Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        else {
            Brand::findorFail($brand_id)->update([
                'brand_name' => $request->brand_name,
                'brand_slug' => strtolower(str_replace(' ', '-', $request->brand_name)),
            ]);

            return redirect()->route('all.brand')->with([
                'message' => 'Brand Name updated successfully',
                'alert-type' => 'success',
            ]);
        }
    }
    public function DeleteBrand($id)
    {
        $brand = Brand::findorFail($id);
        $img = $brand->brand_image;
        unlink($img);

        Brand::findOrFail($id)->delete();

        return redirect()->route('all.brand')->with([
            'message' => 'Brand Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
