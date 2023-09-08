@extends('vendor.dashboard')
@section('vendor')
<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Product</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">All Product <span class="badge rounded-pill bg-success">{{count($products)}}</span> </li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
                <a href="{{route('vendor.add.product')}}" class="btn btn-primary">Add Product</a>
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
                            <th>Discount amount</th>
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
                            <td>@if ($item->discount_price == null)
                                <span class="badge rounded-pill bg-danger">No Discount</span>
                                @else
                                @php
                                    $amount = $item->discount_price / 100;
                                    $discount = $amount * $item->selling_price;
                                    $total_price = $item->selling_price - $discount;
                                @endphp
                                <span class="badge rounded-pill bg-success">{{round($discount)}}</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge rounded-pill bg-success">Active</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">InActive</span>
                                @endif
                             </td>
                            <td>
                                <a href="{{route('vendor.edit.product',$item->id)}}" title="Edit" class="btn btn-info"><i class="fa-solid fa-pencil"></i></a>
                                <a href="{{route('vendor.product.delete',$item->id)}}" title="Delete" id="delete" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                <a href="{{route('edit.category',$item->id)}}" title="Edit" class="btn btn-warning"><i class="fa-solid fa-eye"></i></a>
                                @if ($item->status == 1)
                                <a href="{{route('vendor.product.inactive',$item->id)}}" title="InActive" class="btn btn-danger"><i class="fa-regular fa-thumbs-down"></i></a>
                                @else
                                <a href="{{route('vendor.product.active',$item->id)}}" title="Active" class="btn btn-primary"><i class="fa-regular fa-thumbs-up"></i></a>
                                @endif
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
                            <th>Discount Amount</th>
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
