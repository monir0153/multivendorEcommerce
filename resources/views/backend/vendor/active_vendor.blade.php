@extends('admin.dashboard')
@section('admin')

<div class="page-content">
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Vendor user</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor inactive Table</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Shop Name</th>
                            <th>Vendor UserName</th>
                            <th>Email</th>
                            <th>joined Date</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>

                       @foreach ($activevendor as $key => $item)
                       <tr>
                            <td>{{$key++}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{\Carbon\Carbon::parse($item->from_date)->format('d/m/Y')}}</td>
                            <td><span class="btn btn-success ">{{$item->status}}</span></td>
                            <td>
                                <a href="{{route('active.vendor.details',$item->id)}}"><span class="btn btn-info">Vendor Details</span></a>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>Shop Name</th>
                            <th>Vendor UserName</th>
                            <th>Email</th>
                            <th>joined Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
