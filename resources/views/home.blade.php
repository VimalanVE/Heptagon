@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="container">
                    <div class="jumbotron text-center bg-white">
                        <h2 class="text-center">Welcome to Heptagon</h2>
                        <img style="height: 150px;" src="{{url('/images/heptagon.png')}}">
                        <div class="mt-5">
                            <p class="text-center lead">You can manage companies and employees using this system</p>
                            <a href="{{ route('companies.index') }}" class="btn btn-lg btn-primary">
                                <i class="fa fa-building" aria-hidden="true"></i> Companies</a>
                            <a href="{{ route('employees.index') }}" class="btn btn-lg btn-primary">
                                <i class="fa fa-users" aria-hidden="true"></i> Employees</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
