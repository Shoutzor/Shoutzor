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

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 3;

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
        // If the # of attempts has exceeded the allowed # of tries, Stop further processing of this job.
        elseif($this->attempts() >= $this->tries) {
            $this->upload->status = Upload::STATUS_FAILED_FINAL;
        }
        // Update the status of the upload to failed_retry to indicate to the frontend that it has failed
        // but will be re-attempted
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
