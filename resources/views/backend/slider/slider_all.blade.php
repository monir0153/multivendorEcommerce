@extends('admin.dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Tables</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Slider Table</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
                <a href="{{route('add.slider')}}" class="btn btn-primary">Add Slider</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Slider Title</th>
                            <th>Short Title</th>
                            <th>Slider Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                       @foreach ($sliders as $key => $item)
                       <tr>
                            <td>{{$key++}}</td>
                            <td>{{$item->slider_title}}</td>
                            <td>{{$item->short_title}}</td>
                            <td><img src="{{asset($item->slider_image)}}" alt="slider image" width="60px"></td>
                            <td>
                                <a href="{{route('edit.slider',$item->id)}}" class="btn btn-info">Edit</a>
                                <a href="{{route('delete.slider',$item->id)}}" id="delete" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>Slider Title</th>
                            <th>Short Title</th>
                            <th>Slider Image</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
