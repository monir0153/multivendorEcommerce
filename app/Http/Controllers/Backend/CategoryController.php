<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function AllCategory():View
    {
        $categories = Category::latest()->get();
        return view('backend.category.category_all',['categories' => $categories]);
    }
    public function AddCategory() :View
    {
        return view('backend.category.category_add');
    }
    public function StoreCategory(Request $request) : RedirectResponse
    {
        $images = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
        Image::make($images)->resize(300,300)->save('upload/category/'.$name_gen);
        $save_url = 'upload/category/'.$name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            'category_image' => $save_url,
        ]);

        return redirect()->route('all.category')->with([
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success',
        ]);
    }
    public function EditCategory($id)
    {
        $categories = Category::findorFail($id);
        return view('backend.category.category_edit',compact('categories'));
    }
    public function UpdateCategory(Request $request)
    {
        $category_id = $request->id;
        $old_image = $request->old_image;

        if($request->file('category_image'))
        {
            $images = $request->file('category_image');
            $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(300,300)->save('upload/category/'.$name_gen);
            $save_url = 'upload/category/'.$name_gen;

            if(file_exists($old_image)){
                unlink($old_image);
            }

            Category::findorFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'categorybrand_image' => $save_url,
            ]);

            return redirect()->route('all.category')->with([
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        else {
            Category::findorFail($category_id)->update([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
            ]);

            return redirect()->route('all.category')->with([
                'message' => 'Category Name updated successfully',
                'alert-type' => 'success',
            ]);
        }
    }
    public function DeleteCatgory($id)
    {
        $categories = Category::findorFail($id);
        $img = $categories->category_image;
        unlink($img);

        Category::findOrFail($id)->delete();

        return redirect()->route('all.category')->with([
            'message' => 'Category Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
