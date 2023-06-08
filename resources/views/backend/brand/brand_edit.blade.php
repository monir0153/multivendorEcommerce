@extends('admin.dashboard')
@section('admin')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Brand</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Brand</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                    <form  action="{{route('update.brand')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$brand->id}}">
                        <input type="hidden" name="old_image" value="{{$brand->brand_image}}">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Brand Name</h6>
                            </div>
                            <div class=" col-sm-9 text-secondary">
                                <input type="text" name="brand_name" class="form-control" value="{{$brand->brand_name}}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Brand Image</h6>
                            </div>
                            <div class=" col-sm-9 text-secondary">
                                <input type="file" class="form-control" name="brand_image" id="image"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Existed or select Image</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">

                                <img id="showImage" src="{{asset($brand->brand_image)}}" alt="" width="150px">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <button type="submit" class="btn btn-primary px-4">Save Change</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            const reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>
@endsection
