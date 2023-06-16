<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    public function AllSubCategory():View
    {
        $subcategories = SubCategory::latest()->get();
        return view('backend.subcategory.subcategory_all',['subcategories' => $subcategories]);
    }
    public function AddSubCategory():View
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        return view('backend.subcategory.subcategory_add',['categories' => $categories]);
    }
    public function StoreSubCategory(Request $request) : RedirectResponse
    {

        SubCategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        return redirect()->route('all.subcategory')->with([
            'message' => 'SubCategory Inserted Successfully',
            'alert-type' => 'success',
        ]);
    }
    public function EditSubCategory($id)
    {
        $categories = Category::orderBy('category_name','ASC')->get();
        $subcategory = SubCategory::findorFail($id);
        return view('backend.subcategory.subcategory_edit',compact('categories', 'subcategory'));
    }
    public function UpdateSubCategory(Request $request, $id)
    {
        SubCategory::findorFail($id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),

        ]);

        return redirect()->route('all.subcategory')->with([
            'message' => 'SubCategory Updated Successfully',
            'alert-type' => 'success',
        ]);
    }
    public function DeleteSubCatgory($id)
    {
        SubCategory::findOrFail($id)->delete();

        return redirect()->back()->with([
            'message' => 'SubCategory Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
    public function GetSubCatgory($category_id)
    {
        $subcat = SubCategory::where('category_id', $category_id)->orderby('subcategory_name', 'asc')->get();
        return json_encode($subcat);
    }
}
