<?php

namespace App\Jobs;

use App\Processors\UploadProcessor;
use App\Upload;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessUpload implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $upload;

    /**
     * Create a new job instance.
     *
     * @param Upload $podcast
     * @return void
     */
    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    /**
     * Execute the job.
     *
     * @param UploadProcessor $processor
     * @return void
     */
    public function handle(UploadProcessor $processor) {
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
    public function failed() {
        $this->upload->status = Upload::STATUS_FAILED;
        $this->upload->save();
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return DateTime
     */
    public function retryUntil() {
        return now()->addMinutes(5);
    }
}
