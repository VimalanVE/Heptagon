<?php


namespace App\Repositories;


use App\Imports\CompanyImport;
use App\Imports\EmployeeImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadRepository
{
    /**
     * @param $request
     * @return string
     */
    public function saveAndGetFileName($request)
    {
        /*
         * Get Uploaded Client logo and Save it in public folder
         * And then Return the file name with timestamp to save in DB
        */
        $file = $request->logo;
        $name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fullName = $name . '.' . date('Y-m-d') . '.' . $extension;
        Storage::putFileAs('public', $file, $fullName, 'public');
        return  $fullName;
    }
    /**
     * @param $fileName
     * @param $fileUploadType
     * @return string
     */
    public function bulkUploadFile($fileName, $fileUploadType)
    {
        /*
         * Get File Upload class based on Input passed from the Job, Whether it needs Company or Employee.
         * Upload type is configured in config/constants.php where we can use constants globally
        */
        $getFileUploadClass = ($fileUploadType == \Config::get('constants.options.UPLOAD_TYPE_COMPANIES') ? new CompanyImport() : new EmployeeImport());
        /*
         * Used Maatwebsite Library for excel upload feature
         * Used php artisan make:import feature to create company and employee imports
        */
        Excel::import($getFileUploadClass, public_path('uploads/' . $fileName));
        return $fileName;
    }
}