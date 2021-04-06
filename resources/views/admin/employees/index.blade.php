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
                    <h2 class="m-auto font-weight-bold">Employees Records</h2>
                </div>
                <div class="col-md-4 btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle ml-auto" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Employee
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" data-toggle="modal" data-target="#createEmployeeModal">Create
                            Employee</a>
                        <a class="dropdown-item" href="{{ Storage::url('templates/employee_template.xlsx') }}">Download
                            Template</a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#uploadModal">Upload Employees</a>
                    </div>
                </div>
                <hr>
            </div>
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
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th width="5"></th>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($employees as $employee)
                        <?php $id = encrypt($employee->id);?>
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $employee->firstName }} {{ $employee->lastName }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->company()->first()->name }}</td>
                            <td>{{ ($employee->is_active) ? "Active" : "Inactive" }}</td>
                            <td>
                                <div class="col-md-4 btn-group">
                                    <button type="button" class="btn btn-white dropdown-toggle ml-auto border-primary"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('employees.show', ['id' => $id]) }}">Details</a>
                                        <a class="dropdown-item" href="{{ route('employees.edit', ['id' => $id]) }}">Edit</a>
                                        <a class="dropdown-item" href="{{ route('employees.destroy', ['id' => $id]) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $employees->links() }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('employees.bulk_upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bulk Upload Employees</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <ul>
                                <li>The field column named company in excel should have integer of company id</li>
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

    <!-- Modal -->
    <div class="modal fade" id="createEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="createEmployeeForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Employee</h5>
                        <div class="alert alert-success alert-block" style="display: none;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                <strong class="success-msg"></strong>
                            </button>
                        </div>

                    </div>
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label class="control-label">First Name</label>
                                <input type="text" id="firstName" name="firstName" class="form-control">
                                <span class="text-danger error-text firstName_err"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Last Name</label>
                                <input type="text" id="lastName" name="lastName" class="form-control">
                                <span class="text-danger error-text lastName_err"></span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control">

                                <span class="text-danger error-text email_err"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Phone</label>
                                <input type="tel" id="phone" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <select class="form-control" id="company" name="company">
                                <option value=""></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label>Is Active</label>
                                <input type="checkbox" name="is_active" checked="checked"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary create-employee-btn">Create Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".create-employee-btn").click(function (e) {
                e.preventDefault();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('employees.store') }}",
                    type: 'POST',
                    data: $("#createEmployeeForm").serialize(),
                    dataType: "JSON",
                    success: function (data) {
                        displayMessage(data);
                    }
                });
            });

            function displayMessage(msg) {
                if ($.isEmptyObject(msg.error)) {
                    console.log(msg.success);
                    $('.alert-block').css('display', 'block').append('<strong>' + msg.success + '</strong>');
                } else {
                    $.each(msg.error, function (key, value) {
                        $('.' + key + '_err').text(value);
                    });
                }
            }

            $('#createEmployeeModal').on('hidden.bs.modal', function () {
                location.reload();
            });
        });
    </script>
@endsection
