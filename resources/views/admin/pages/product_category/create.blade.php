@extends('admin.layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Product Category Create</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        {{-- {{ dd($errors->all()) }} --}}


        <form role="form" action="{{ route('admin.product_category.store') }}" method="post">
            @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{ old('name') }}">
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
              <label for="slug">Slug</label>
              <input type="text" class="form-control" id="slug" placeholder="Enter Slug" name="slug" value="{{ old('slug') }}">
            </div>
            @error('slug')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">---Please select---</option>
                <option {{ old('status') === '1' ? 'selected' : '' }} value="1">Show</option>
                <option {{ old('status') === '0' ? 'selected' : '' }} value="0">Hide</option>
            </select>
            @error('status')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
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