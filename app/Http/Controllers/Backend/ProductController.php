<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MultiImage;
use App\Models\Product;
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
            'product_slug' => strtolower(str_replace(' ','-',$request->product_slug)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

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
}
