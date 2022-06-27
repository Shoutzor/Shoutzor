<?php

namespace App\Jobs;

use App\Exceptions\MediaDuplicateException;
use App\Models\Upload;
use App\Processors\UploadProcessor;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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
        try {
            Log::debug("Updating upload status to: processing",[$this->upload]);

            //Update the status
            $this->upload->status = Upload::STATUS_PROCESSING;
            $this->upload->save();

            Log::debug("Start processing upload");

            $processor->parse($this->upload);

            Log::debug("Processing successfully finished");
        }
        catch(Throwable $exception) {
            Log::error("An exception occured while processing the job: " . $exception->getMessage());

            // Upload Exists Exception has been thrown. Stop further processing of this job.
            if($exception instanceof MediaDuplicateException) {
                Log::debug("MediaExistsException thrown. Marking upload as failed (final)");
                $this->upload->status = Upload::STATUS_FAILED_FINAL;
            }
            // If the # of attempts has exceeded the allowed # of tries, Stop further processing of this job.
            elseif($this->attempts() >= $this->tries) {
                Log::debug("Upload processing failed and # of tries exceeded. Marking upload as failed (final)");
                $this->upload->status = Upload::STATUS_FAILED_FINAL;
            }
            // Update the status of the upload to failed_retry to indicate to the frontend that it has failed
            // but will be re-attempted
            else {
                Log::debug("Upload processing failed. Marking upload as failed (with retry)");
                $this->upload->status = Upload::STATUS_FAILED_RETRY;
            }
            $this->upload->save();

            // Check if the status indicates the job should be marked as failed.
            if($this->upload->status === Upload::STATUS_FAILED_FINAL) {
                Log::debug("Job failed, marking as failed");

                // Delete the current job
                $this->fail($exception);
            }
            else {
                Log::debug("Job failed, releasing back to queue");
                // Forward the exception
                $this->release($this->backoff);
            }
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
