<?php

namespace App\Jobs;

use App\Repositories\FileUploadRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FileUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $fileType;
    private $fileName;
    private $fileUploadRepo;

    /**
     * Create a new job instance.
     *
     * @param $fileName
     * @param $fileType
     */
    public function __construct($fileName, $fileType)
    {
        $this->fileUploadRepo = resolve(FileUploadRepository::class);
        $this->fileName = $fileName;
        $this->fileType = $fileType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->fileUploadRepo->bulkUploadFile($this->fileName, $this->fileType);
    }
}
