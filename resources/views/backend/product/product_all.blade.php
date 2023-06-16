@extends('admin.dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Product </li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
                <a href="{{route('add.category')}}" class="btn btn-primary">Add Product</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Image</th>
                            <th>Discount</th>
                            <th>status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                       @foreach ($products as $key => $item)
                       <tr>
                            <td>{{$key++}}</td>
                            <td>{{$item->product_name}}</td>
                            <td>{{$item->selling_price}}</td>
                            <td>{{$item->product_qty}}</td>
                            <td><img src="{{asset($item->product_thumbnail)}}" alt="brand image" width="60px"></td>
                            <td>{{$item->discount_price	}}</td>
                            <td>{{$item->status }}</td>
                            <td>
                                <a href="{{route('edit.category',$item->id)}}" class="btn btn-info">Edit</a>
                                <a href="{{route('delete.category',$item->id)}}" id="delete" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Image</th>
                            <th>Discount</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
