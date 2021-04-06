@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 row">
            <div class="col-md-4 btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('companies.index') }}" class="btn btn-primary">
                    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back</a>
            </div>
            <div class="col-md-4 btn-group text-center">
                <h3 class="m-auto font-weight-bold">{{ $company->name }}</h3>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td>Name</td>
                  <td>{{ $company->name }}</td>
                </tr>
                <tr>
                  <td>Logo</td>
                  <td>
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="" width="100" height="100">
                  </td>
                </tr>
                <tr>
                  <td>Website</td>
                  <td>
                    <a href="{{ $company->website }}">
                      {{ $company->website }}
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>Email Address</td>
                  <td>{{ $company->email }}</td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
