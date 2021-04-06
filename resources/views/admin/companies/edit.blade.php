@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10" style="border: 1px solid #f1f1f1;">
          <h2 class="text-center" style="margin-top: 30px;">Update Company Record</h2>
          <form class="form" action="{{ route('companies.update', ['id' => $company->id]) }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="row form-group">
              <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ $company->name }}">
              </div>
              <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $company->email }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-6">
                <label>Logo</label>
                <input type="file" name="logo" class="form-control" value="{{ $company->logo }}">
              </div>
              <div class="col-md-6">
                <label>Website</label>
                <input type="url" name="website" class="form-control" value="{{ $company->website }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-md-6">
                <label>Is Active</label>
                <input type="checkbox"  name="is_active" class="custom_checkbox valid_check"
                       {{$company->is_active ? 'checked':''}}
                       value="1"/>
                <span class="checkmark"></span>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary float-right" name="save_company">Update Company Record</button>
                <a class="btn btn-secondary float-right mr-2" href="{{route('companies.index')}}">Back</a>
              </div>
            </div>
          </form>

        </div>
    </div>
</div>
@endsection
