@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          @if(session('msg'))
            @if (session('msg') === 'success')
              <div class="alert alert-success">Success</div>  
            @else
              <div class="alert alert-danger">Failed</div>  
            @endif
         @endif  
          <h3 class="card-title">Product List</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered">
            <thead>                  
              <tr>
                <th style="width: 10px">#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>
                <th>Product Category Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($datas as $data)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $data->name }}</td>
                  <td>{{ number_format($data->price, 2) }}</td>
                  <td>
                    <img src="{{ asset('images/'.$data->main_image )}}" width="320" alt="{{ $data->name }}">
                  </td>
                  <td>
                    <button class="btn {{ $data->status ? 'btn-success' : 'btn-danger' }}">{{ $data->status ? 'Show' : 'Hide' }}</button>
                  </td>
                  <td>{{ $data->productCategory?->name }}</td>
                  <td>{{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('m/d/Y H:i:s') : '-' }}</td>
                  <td>
                    <a href="{{ route('admin.product_category.detail', ['productCategory' => $data->id]) }}" class="btn btn-primary">Detail</a> 
                    <form action="{{ route('admin.product_category.destroy', ['productCategory' => $data->id]) }}" method="post">
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          {{ $datas->links() }}
        </div>
      </div>
      <!-- /.card -->
    </div>
</div>
@endsection