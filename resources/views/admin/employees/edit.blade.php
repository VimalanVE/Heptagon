@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10" style="border: 1px solid #f1f1f1;">
          <h2 class="text-center" style="margin-top: 30px;">Update Employee Record</h2>
          <form class="form" action="{{ route('employees.update', ['id' => $employee->id]) }}" method="post">
            {{ csrf_field() }}

            {{ method_field('put') }}

            <div class="row form-group">
              <div class="col-md-6 <?php echo $errors->has('firstName') ? 'has-error' : '' ?>">
                <label class="control-label">First Name</label>
                <input type="text" name="firstName" class="form-control" value="{{ $employee->firstName }}">
                @if($errors->has('firstName'))
                  <span class="help-block">{{ $errors->first('firstName') }}</span>
                @endif
              </div>
              <div class="col-md-6 <?php echo $errors->has('lastName') ? 'has-error' : '' ?>">
                <label class="control-label">Last Name</label>
                <input type="text" name="lastName" class="form-control" value="{{ $employee->lastName }}">
                @if($errors->has('lastName'))
                  <span class="help-block">{{ $errors->first('lastName') }}</span>
                @endif
              </div>
            </div>

            <div class="row form-group">
              <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $employee->email }}">
              </div>
              <div class="col-md-6">
                <label>Phone</label>
                <input type="tel" name="phone" class="form-control" value="{{ $employee->phone }}">
              </div>
            </div>

            <div class="form-group">
              <label>Company</label>
              <select class="form-control" name="company">
                <option value=""></option>
                @foreach($companies as $company)
                  @if($employee->company === $company->id)
                    <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                  @else
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="row form-group">
              <div class="col-md-6">
                <label>Is Active</label>
                <input type="checkbox"  name="is_active" class="custom_checkbox valid_check"
                       {{$employee->is_active ? 'checked':''}}
                       value="1"/>
                <span class="checkmark"></span>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-primary float-right" name="save_company">Update Employee Record</button>
                <a class="btn btn-secondary float-right mr-2" href="{{route('employees.index')}}">Back</a>
              </div>
            </div>
          </form>

        </div>
    </div>
</div>
@endsection
