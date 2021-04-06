@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 row">
            <div class="col-md-4 btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('employees.index') }}" class="btn btn-primary">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-4 btn-group text-center">
                <h2 class="m-auto font-weight-bold">{{ $employee->firstName }} {{ $employee->lastName }}</h2>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <table class="table table-bordered">
              <thead>
                <th>Attribute</th>
                <th>Value</th>
              </thead>
              <tbody>
                <tr>
                  <td>Full Name</td>
                  <td>{{ $employee->firstName }} {{ $employee->lastName }}</td>
                </tr>
                <tr>
                  <td>Company</td>
                  <td>{{ $employee->company()->first()->name }}</td>
                </tr>
                <tr>
                  <td>Phone</td>
                  <td>{{ $employee->phone }}</td>
                </tr>
                <tr>
                  <td>Email Address</td>
                  <td>{{ $employee->email }}</td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
