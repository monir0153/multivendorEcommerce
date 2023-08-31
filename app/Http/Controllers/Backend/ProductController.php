<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = Product::latest()->get();
        return view('backend.product.product_all', compact('products'));
    }
    public function AddProduct(){
        $activevendor = User::where('status', 'active')->where('role','vendor')->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        return view('backend.product.product_add',compact('brands','categories','activevendor'));
    }
    public function StoreProduct(Request $request)
    {
        $images = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(800,800)->save('upload/products/thumbnail/'.$name_gen);
            $save_url = 'upload/products/thumbnail/'.$name_gen;
      $product_id =   Product::insertGetId([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'product_tags' => $request->product_tags,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_deals' => $request->special_deals,
            'special_offer' => $request->special_offer,

            'product_thumbnail' => $save_url,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
        // For multiple images upload
        $image = $request->file('multi_images');
        foreach ($image as $img){
            $create_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-images/'.$create_name);
            $upload_path = 'upload/products/multi-images/'.$create_name;

            MultiImage::insert([
                'product_id' => $product_id,
                'image_name' => $upload_path,
                'created_at' => Carbon::now(),
            ]);
        }//end foreach

        return redirect()->route('all.product')->with([
            'message' => 'Product Added successfully',
            'alert-type' => 'success',
        ]);
    }
    public function EditProduct($id){
        $multiImage = MultiImage::where('product_id',$id)->get();
        $activevendor = User::where('status', 'active')->where('role','vendor')->get();
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategory = SubCategory::latest()->get();
        $products = Product::findOrFail($id);
        return view('backend.product.product_edit',compact('brands','categories','activevendor','subcategory','products','multiImage'));
    }
    public function UpdateProduct(Request $request,$id){
        $old_image = $request->old_image;
        if($request->file('product_thumbnail')){

            $images = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()).'.'.$images->getClientOriginalExtension();
            Image::make($images)->resize(800,800)->save('upload/products/thumbnail/'.$name_gen);
            $save_url = 'upload/products/thumbnail/'.$name_gen;
            if(file_exists($old_image)){
                unlink($old_image);
            }

            Product::findOrFail($id)->update([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'product_tags' => $request->product_tags,

                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

                'hot_deals' => $request->hot_deals,
                'featured' => $request->featured,
                'special_deals' => $request->special_deals,
                'special_offer' => $request->special_offer,

                'product_thumbnail' => $save_url,
                'vendor_id' => $request->vendor_id,
                'status' => 1,
                'updated_at' => Carbon::now(),
            ]);
        }else {
            Product::findOrFail($id)->update([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ','-',$request->product_name)),

                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'product_tags' => $request->product_tags,

                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,

                'hot_deals' => $request->hot_deals,
                'featured' => $request->featured,
                'special_deals' => $request->special_deals,
                'special_offer' => $request->special_offer,


                'vendor_id' => $request->vendor_id,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('all.product')->with([
            'message' => 'Product Updated successfully',
            'alert-type' => 'success',
        ]);
    }
    public function UpdateProductMultiImage(Request $request,$id){
        $image = $request->multi_image;
        foreach($image as $id => $img){
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->image_name);

            $create_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(800,800)->save('upload/products/multi-images/'.$create_name);
            $upload_path = 'upload/products/multi-images/'.$create_name;

            MultiImage::where('id', $id)->update([
                'image_name' => $upload_path,
                'updated_at' => Carbon::now(),
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Multi Image Updated successfully',
            'alert-type' => 'success',
        ]);
    }
    public function ProductMultiImageDelete($id){
        $old_image = MultiImage::findOrFail($id);
        unlink($old_image->image_name);

        MultiImage::findOrFail($id)->delete();

        return redirect()->back()->with([
            'message' => 'Multi Image Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
    public function ProductInactive($id){
        Product::findOrFail($id)->update(['status' => 0]);
        return redirect()->back()->with([
            'message' => 'Product Inactive successfully',
            'alert-type' => 'success',
        ]);
    }
    public function ProductActive($id){
        Product::findOrFail($id)->update(['status' => 1]);
        return redirect()->back()->with([
            'message' => 'Product Active successfully',
            'alert-type' => 'success',
        ]);
    }
    public function ProductDelete($id){
        $product = Product::findOrFail($id);
        unlink($product->product_thumbnail);
        Product::findOrFail($id)->delete();

        $image = MultiImage::where('product_id',$id)->get();
        foreach($image as $img){
            unlink($img->image_name);
            MultiImage::where('product_id',$id)->delete();
        }
        return redirect()->back()->with([
            'message' => 'Product Deleted successfully',
            'alert-type' => 'success',
        ]);
    }

}
