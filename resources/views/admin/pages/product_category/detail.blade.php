@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Product Category Detail</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->


        <form role="form" action="{{ route('admin.product_category.update', ['productCategory' => $data->id]) }}" method="post">
            @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ $data->name }}">
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" placeholder="Enter Slug" name="slug" value="{{ $data->slug }}">
            </div>
            @error('slug')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">---Please select---</option>
                <option {{ $data->status == '1' ? 'selected' : '' }} value="1">Show</option>
                <option {{ $data->status == '0' ? 'selected' : '' }} value="0">Hide</option>
            </select>
            @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection

@section('my-js')
  <script type="text/javascript">
      $(document).ready(function(){
          $('#name').on('keyup', function(){
            var slug = $(this).val();

            $.ajax({
                method: "GET", //method of form
                url: "{{ route('admin.product_category.make_slug') }}", //action of form
                data: {slug: slug}, //input name of form,
                success: function(response) {
                  $('#slug').val(response.slug);
                }
            });
          });
      });
  </script>
@endsection