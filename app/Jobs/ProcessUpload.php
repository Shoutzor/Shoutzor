<?php

namespace App\Jobs;

use App\Models\Upload;
use App\Processors\UploadProcessor;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Upload $upload;

    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @param Upload $upload
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     *
     * @param UploadProcessor $processor
     * @return void
     */
    public function handle(UploadProcessor $processor)
    {
        //Update the status
        $this->upload->status = Upload::STATUS_PROCESSING;
        $this->upload->save();

        $processor->parse($this->upload);
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Upload Exists Exception has been thrown. Stop further processing of this job.
        if($exception && is_a($exception, "UploadExistsException")) {
            $this->upload->status = Upload::STATUS_FAILED_FINAL;
        }
        elseif($this->attempts() >= $this->tries) {
            $this->upload->status = Upload::STATUS_FAILED_FINAL;
        }
        else {
            $this->upload->status = Upload::STATUS_FAILED_RETRY;
        }
        $this->upload->save();

        if($this->upload->status === Upload::STATUS_FAILED_FINAL) {
            // Delete the current job
            $this->delete();
        }
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(5);
    }
}
