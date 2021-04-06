@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 row">
                <div class="col-md-4 btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('home') }}" class="btn btn-primary mr-5">
                        <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back</a>
                </div>
                <div class="col-md-4 btn-group text-center">
                    <h2 class="m-auto font-weight-bold">Company Records</h2>
                </div>
                <div class="col-md-4 btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle ml-auto" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Company
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('companies.create') }}">Create Company</a>
                        <a class="dropdown-item" href="{{ Storage::url('templates/company_template.xlsx') }}">Download
                            Template</a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#uploadModal">Upload Companies</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-md-12 mt-5">
                @include('layouts.messages')
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead class="text-white" style="background-color: dodgerblue;">
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>No of Employees</th>
                    <th width="5"></th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($companies as $company)
                        <?php $id = encrypt($company->id);?>
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>
                                <a href="{{ route('companies.show', ['id' => $id]) }}">
                                    {{ $company->name }}
                                </a>
                            </td>
                            <td>{{ $company->email }}</td>
                            <td>{{ ($company->is_active) ? "Active" : "Inactive" }}</td>
                            <td class="text-center" style="font-size: 25px;">
                                <span class="badge badge-pill badge-secondary">{{ $company->employees_count }}</span>
                            </td>
                            <td>
                                <div class="col-md-4 btn-group">
                                    <button type="button" class="btn btn-white border-primary dropdown-toggle ml-auto"
                                            data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('companies.show', ['id' => $id]) }}">Details</a>
                                        <a class="dropdown-item" href="{{ route('companies.edit', ['id' => $id]) }}">Edit</a>
                                        <a class="dropdown-item" href="{{ route('companies.destroy', ['id' => $id]) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $companies->links() }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('companies.bulk_upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bulk Upload Companies</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <ul>
                                <li>The field column named email/website in excel should be in respective format</li>
                                <li>The field column named logo in excel should be file path</li>
                                <li>The field column named is_active in excel should be boolean</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="file" name="file" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
