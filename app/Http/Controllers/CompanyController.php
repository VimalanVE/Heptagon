<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Jobs\FileUploadJob;
use App\Repositories\FileUploadRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Company;

class CompanyController extends Controller
{

    /**
     * @var FileUploadRepository
     */
    private $fileUploadRepo;

    /**
     * CompanyController constructor.
     * @param FileUploadRepository $fileUploadRepository
     */
    public function __construct(FileUploadRepository $fileUploadRepository)
    {
        /*Used File upload Repository for Bulk Upload of Companies and Upload Company logo*/
        $this->fileUploadRepo = $fileUploadRepository;
    }


    /**
     * Display a listing of companies
     *
     * @return Response
     */
    public function index()
    {
        /*Added withCount relationship of Employees to display in Listview with Pagination*/
        $companies = Company::withCount(['employees'])->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }


    /**
     * Show the form for creating a new company.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.companies.create');
    }


    /**
     * Store a newly created company in the database.
     *
     * @param StoreCompanyRequest $request
     * @return Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $validated = $request->validated();

        /*
         * For Company Module I've used Input Array and create function to insert record
         * WhereAs in Employee Modules I've implemented Fill option to insert record
         * Just to use multiple methods, I've used different functions in different places
        */
        $input = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'is_active' => ($request->input('is_active')) ? 1 : 0
        ];

        // processing logo file
        if ($request->hasFile('logo')) {
            $input['logo'] = $this->fileUploadRepo->saveAndGetFileName($request);
        }

        /*
         * Create Companies based on Given input
         * Though we didn't have any unique validations on inserting/updating data
         * Haven't used firstOrFail and createOrUpdate functions
        */
        Company::create($input);


        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'New company record created');
        return redirect()->route('companies.index');
    }


    /**
     * Display details about a specified company.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        /*Decrypt the Id which is encrypted in blade for security reasons*/
        $company = Company::find(decrypt($id));
        return view('admin.companies.show', compact('company'));
    }


    /**
     * Show the form for editing the specified company.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /*Decrypt the Id which is encrypted in blade for security reasons*/
        $company = Company::find(decrypt($id));
        return view('admin.companies.edit', compact('company'));
    }


    /**
     * Update the specified company in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $validated = $request->validated();

        /*
         * For Company Module I've used Input Array and create function to insert record
         * WhereAs in Employee Modules I've implemented Fill option to insert record
         * Just to use multiple methods, I've used different functions in different places
        */
        $input = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
            'is_active' => ($request->input('is_active')) ? 1 : 0
        ];

        if ($request->hasFile('logo')) {
            $input['logo'] = $this->fileUploadRepo->saveAndGetFileName($request);
        }

        /*
         * Update Company based on Given input
         * Though we didn't have any unique validations on inserting/updating data
         * Haven't used findOrFail and updateOrInsert functions
        */
        $oldCompanyRecord = Company::find($id);
        $oldCompanyRecord->update($input);

        Session::flash('alert-class', 'alert-success');
        Session::flash('message', 'Company record updated');

        return redirect()->route('companies.index');
    }


    /**
     * Remove the specified company from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        /*Decrypt the Id which is encrypted in blade for security reasons*/
        $company = Company::find(decrypt($id));
        /*
         * Delete company logo in public folder
        */
        if (!empty($company->logo)) {
            Storage::delete('public/' . $company->logo);
        }
        $company->delete();
        return redirect()->route('companies.index');
    }


    /**
     * @param FileUploadRequest $request
     * @return RedirectResponse
     */
    public function bulkUpload(FileUploadRequest $request)
    {
        /*
         * This function uses common Form request validation ~ FileUploadRequest
         * That which is shared by employee bulk upload function too
         * First get File from Input request and save it in public path uploads
        */
        $fileName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $fileName);

        /*
         * Upload type is configured in config/constants.php where we can use constants globally
        */
        $fileUploadType = \Config::get('constants.options.UPLOAD_TYPE_COMPANIES');

        /*
         * As requested to do the bulk upload functionality using Queue concept
         * I've used php artisan make:job command to create a Job that which implements ShouldQueue
         * Though I have used dispatch instead of dispatchNow it will run in background queue
        */
        FileUploadJob::dispatch($fileName, $fileUploadType);

        return back()->with('success', 'Bulk upload Job starts running ..!');
    }
}
