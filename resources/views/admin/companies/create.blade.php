@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10" style="border: 1px solid #f1f1f1;">
                <h2 class="text-center" style="margin-top: 30px;">Add Company Record</h2>
                <form class="form" action="{{ route('companies.store') }}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}

                    <div class="row form-group">
                        <div class="col-md-6 <?php echo $errors->has('name') ? 'has-error' : '' ?>">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @if($errors->has('name'))
                                <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group <?php echo $errors->has('logo') ? 'has-error' : '' ?>">
                        <label>Logo</label>
                        <input type="file" name="logo" class="form-control" value="{{ old('logo') }}">
                        @if($errors->has('logo'))
                            <span class="help-block">{{ $errors->first('logo') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website') }}">
                    </div>
                    <div class="row form-group">
                      <div class="col-md-6">
                        <label>Is Active</label>
                        <input type="checkbox" name="is_active" checked="checked"/>
                      </div>
                      <div class="col-md-6">
                        <button type="submit" class="btn btn-primary float-right" name="save_company">Save Company Record</button>
                        <a class="btn btn-secondary float-right mr-2" href="{{route('companies.index')}}">Back</a>
                      </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
