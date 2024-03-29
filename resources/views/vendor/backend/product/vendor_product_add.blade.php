@extends('vendor.dashboard')
@section('vendor')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Vendor Product</li>
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Add New Product</h5>
          <hr>
          <form action="{{route('vendor.store.product')}}" id="myForm" method="POST" enctype="multipart/form-data">
            @csrf
           <div class="form-body mt-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="border border-3 p-4 rounded">
                        <div class="form-group mb-3">
                            <label for="inputProductTitle" class="form-label">Product name</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Enter product name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Tags</label>
                            <input type="text" name="product_tags" class="form-control visually-hidden" data-role="tagsinput">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Size</label>
                            <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Color</label>
                            <input type="text" name="product_color" class="form-control visually-hidden" data-role="tagsinput">
                        </div>
                        <div class="form-group mb-3">
                            <label for="inputProductDescription" class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="inputProductDescription" class="form-label">Long Description</label>
                            <textarea class="form-control" id="mytextarea" name="long_description" rows="3"></textarea>
                          </div>
                          <div class="form-group mb-3">
                            <label for="inputProductDescription" class="form-label">Product Thumbnail</label>
                            <input class="form-control" name="product_thumbnail" type="file" id="formFile" onchange="mainThumUrl(this)">
                            <img src="" class="pt-3 pb-3" id="mainThumb" width="200px" height="200px">
                          </div>
                          <div class="mb-3">
                            <label for="inputProductDescription" class="form-label">Multiple Product Image</label>
                            <input class="form-control" type="file" name="multi_images[]" id="multiImg" multiple="">
                            <div class="row" id="preview_img"></div>
                          </div>
                     </div>
                </div>
               <div class="col-lg-4">
                <div class="border border-3 p-4 rounded">
                  <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label for="inputPrice" class="form-label">Product Price</label>
                        <input type="text" class="form-control" name="selling_price" placeholder="00.00">
                      </div>
                      <div class="col-md-6">
                        <label for="inputCompareatprice" class="form-label">Discount (0-100%) </label>
                        <input type="text" class="form-control" name="discount_price" placeholder="00.00">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputCostPerPrice" class="form-label">Product Code</label>
                        <input type="text" class="form-control" name="product_code" >
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputStarPoints" class="form-label">Product Qunatity</label>
                        <input type="text" class="form-control" name="product_qty" placeholder="1,2,3">
                      </div>
                      <div class="form-group col-12">
                        <label for="inputProductType" class="form-label">Product Brand</label>
                        <select class="form-select" name="brand_id">
                            <option></option>
                            @foreach ($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                            @endforeach

                          </select>
                      </div>
                      <div class="form-group col-12">
                        <label for="inputVendor" class="form-label">Product Category</label>
                        <select class="form-select" name="category_id" >
                            <option></option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                          </select>
                      </div>
                      <div class="form-group col-12">
                        <label for="inputCollection" class="form-label">Product Subcategory</label>
                        <select class="form-select" name="subcategory_id" >
                            <option></option>

                          </select>
                      </div>

                        <div class="col-12">
                          <div class="row g-3">
                            <div class="col-md-6">
                              <div class="form-check">
                                <input class="form-check-input" name="hot_deals" type="checkbox" value="1">
                                <label class="form-check-label" for="flexCheckDefault">Hot Deals</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-check">
                                <input class="form-check-input" name="featured" type="checkbox" value="1" >
                                <label class="form-check-label" for="flexCheckDefault">Featured</label>
                              </div>
                            </div>
                          </div>
                          <div class="row g-3">
                            <div class="col-md-6">
                              <div class="form-check">
                                <input class="form-check-input" name="special_deals" type="checkbox" value="1">
                                <label class="form-check-label" for="flexCheckDefault">Special Deals</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-check">
                                <input class="form-check-input" name="special_offer" type="checkbox" value="1" >
                                <label class="form-check-label" for="flexCheckDefault">Special Offer</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      <div class="col-12">
                          <div class="d-grid">
                             <button type="submit" class="btn btn-primary">Save Product</button>
                          </div>
                      </div>
                    </div>
                </div>
              </div>
           </div><!--end row-->
        </div>
        </form>
      </div>
  </div>

</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                product_name: {
                    required : true,
                },
                short_description: {
                    required : true,
                },
                product_thumbnail: {
                    required : true,
                },
                multi_images: {
                    required : true,
                },
                selling_price: {
                    required : true,
                },
                product_code: {
                    required : true,
                },
                product_qty: {
                    required : true,
                },
                brand_id: {
                    required : true,
                },
                category_id: {
                    required : true,
                },
                subcategory_id: {
                    required : true,
                },
            },
            messages :{
                product_name: {
                    required : 'Please Enter Product Name',
                },
                short_description: {
                    required : 'Please Enter Short Description',
                },
                product_thumbnail: {
                    required : 'Please Enter Product Thumbnail',
                },
                multi_images: {
                    required : 'Please Enter Product Thumbnail',
                },
                selling_price: {
                    required : 'Please Enter Product Price',
                },
                product_code: {
                    required : 'Please Enter Product Code',
                },
                product_qty: {
                    required : 'Please Enter Product Quantity',
                },
                brand_id: {
                    required : 'Please Enter Brand Name',
                },
                category_id: {
                    required : 'Please Enter Category Name',
                },
                subcategory_id: {
                    required : 'Please Enter SubCategory Name',
                },
            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>
<script type="text/javascript">
  function mainThumUrl(input) {
    if(input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#mainThumb').attr('src',e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
<script>
    $(document).ready(function(){
     $('#multiImg').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data

            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                    .height(80); //create image element
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });

        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });

    </script>
    <script>
      $(document).ready(function(){
        $('select[name="category_id"]').on('change', function(){
          const category_id = $(this).val();
          if(category_id){
            $.ajax({
              url : "{{ url('vendor/subcategory/ajax')}}/"+category_id,
              type: 'GET',
              dataType: 'json',
              success: function(data){
                $('select[name="subcategory_id"]').html('');
                var d = $('select[name="subcategory_id"]').empty();
                $.each(data, function(key, value){
                  $('select[name="subcategory_id').append('<option value="'+value.id+'">'+value.subcategory_name+'</option>')
                })
              }
            })
          }else{
            alert('danger');
          }
        })
      })
    </script>
@endsection
