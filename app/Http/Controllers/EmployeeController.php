<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Employee;
use App\Company;
use App\Jobs\FileUploadJob;
use App\Repositories\FileUploadRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class EmployeeController extends Controller
{

    /**
     * @var FileUploadRepository
     */
    private $fileUploadRepo;

    /**
     * EmployeeController constructor.
     * @param FileUploadRepository $fileUploadRepository
     */
    public function __construct(FileUploadRepository $fileUploadRepository)
    {
        /*Used File upload Repository for Bulk Upload of Companies*/
        $this->fileUploadRepo = $fileUploadRepository;
    }


    /**
     * Display a listing of the Employees.
     *
     * @return Response
     */
    public function index()
    {
        /*
         * To display company name in List view and paginate employee data
        */
        $companies = Company::select('id', 'name')->get();
        $employees = Employee::with('company')->paginate(10);
        return view('admin.employees.index', compact(['employees', 'companies']));
    }


    /**
     * Show the form for creating a new Employee
     *
     * @return Response
     */
    public function create()
    {
        /*Sending company details for dropdown listing for specific Employee*/
        $companies = Company::select('id', 'name')->get();
        return view('admin.employees.create', compact('companies'));
    }


    /**
     * Store a newly created Employee in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        /*
         * Here Instead of Using separate request I've used Request
         * The reason because this function is an AJAX function as requested to do
         * For AJAX function I am in need to send json response from here
         * That's the reason why I choose default request over custom one
        */
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'email' => 'required|email',
            'lastName' => 'required',
            'company' => 'required',
        ]);

        if ($validator->passes()) {
            /*
             * For Employee Module I've used fill function to insert record
             * WhereAs in Company Modules I've implemented create option to insert record
             * Just to use multiple methods, I've used different functions in different places
            */
            $employee = new Employee();
            $employee->fill($request->all());
            $employee->is_active = ($request->input('is_active')) ? 1 : 0;
            $employee->save();
            return response()->json(['success' => 'Added new records.']);
        }

        return response()->json(['error' => $validator->errors()]);
    }


    /**
     * Display the specified Employee.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $employee = Employee::find(decrypt($id));
        return view('admin.employees.show', compact('employee'));
    }


    /**
     * Show the form for editing the specified Employee.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $employee = Employee::find(decrypt($id));
        $companies = Company::select('id', 'name')->get();
        return view('admin.employees.edit', compact(['employee', 'companies']));
    }


    /**
     * Update the specified Employee in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $validated = $request->validated();

        /*
         * For Employee Module I've used fill function to insert record
         * WhereAs in Company Modules I've implemented create option to insert record
         * Just to use multiple methods, I've used different functions in different places
        */
        $employee = Employee::find($id);
        $employee->fill($request->all());
        $employee->is_active = ($request->input('is_active')) ? 1 : 0;
        $employee->save();

        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'Employee record updated');

        return redirect()->route('employees.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /*Decrypt the Id which is encrypted in blade for security reasons*/
        $employee = Employee::find(decrypt($id));
        $employee->delete();

        return redirect()->route('employees.index');
    }


    /**
     * @param FileUploadRequest $request
     * @return RedirectResponse
     */
    public function bulkUpload(FileUploadRequest $request)
    {
        /*
         * This function uses common Form request validation ~ FileUploadRequest
         * That which is shared by company bulk upload function too
         * First get File from Input request and save it in public path uploads
        */
        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);

        /*
        * Upload type is configured in config/constants.php where we can use constants globally
       */
        $fileUploadType = \Config::get('constants.options.UPLOAD_TYPE_EMPLOYEES');

        /*
         * As requested to do the bulk upload functionality using Queue concept
         * I've used php artisan make:job command to create a Job that which implements ShouldQueue
         * Though I have used dispatch instead of dispatchNow it will run in background queue
        */
        FileUploadJob::dispatch($fileName, $fileUploadType);

        return back()->with('success', 'Bulk upload Job starts running ..!');
    }
}
