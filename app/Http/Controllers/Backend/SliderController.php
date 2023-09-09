<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class SliderController extends Controller

{
    public function AllSlider():View
    {
        $sliders = Slider::latest()->get();
        return view('backend.slider.slider_all',['sliders' => $sliders]);
    }
    public function AddSlider() :View
    {
        return view('backend.slider.slider_add');
    }
    public function StoreSlider(Request $request){
        $images = $request->file('slider_image');
        $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
        Image::make($images)->resize(2376,807)->save('upload/slider/'.$name_gen);
        $save_url = 'upload/slider/'.$name_gen;

        Slider::insert([
            'slider_title' => $request->slider_title,
            'short_title' => $request->short_title,
            'slider_image' => $save_url,
        ]);

        return redirect()->route('all.slider')->with([
            'message' => 'Slider Inserted Successfully',
            'alert-type' => 'success',
        ]);
    }
    public function EditSlider($id)
    {
        $slider = Slider::findorFail($id);
        return view('backend.slider.slider_edit',compact('slider'));
    }
    public function UpdateSlider(Request $request,$id)
    {
        $old_image = $request->old_image;

        if($request->file('slider_image'))
        {
            $images = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(2376,807)->save('upload/slider/'.$name_gen);
            $save_url = 'upload/slider/'.$name_gen;

            if(file_exists($old_image)){
                unlink($old_image);
            }

            Slider::findorFail($id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
                'slider_image' => $save_url,
            ]);

            return redirect()->route('all.slider')->with([
                'message' => 'Slider Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        else {
            Slider::findorFail($id)->update([
                'slider_title' => $request->slider_title,
                'short_title' => $request->short_title,
            ]);

            return redirect()->route('all.slider')->with([
                'message' => 'Slider updated successfully',
                'alert-type' => 'success',
            ]);
        }
    }
    public function DeleteSlider($id)
    {
        $slider = Slider::findorFail($id);
        $img = $slider->slider_image;
        if(file_exists($img)){
            unlink($img);
        }

        Slider::findOrFail($id)->delete();

        return redirect()->route('all.slider')->with([
            'message' => 'SLider Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
