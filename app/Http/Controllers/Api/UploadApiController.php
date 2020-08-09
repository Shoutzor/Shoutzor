<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessUpload;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadApiController extends Controller {

    public function store(Request $request) {
        //Check if a file has been provided with the request
        if($request->hasFile('media') !== true) {
            return;
        }

        //Check if there are any errors with the file upload
        if($request->file('media')->isValid() !== true) {
            return;
        }

        //Get the name and extension of the file
        $name   = $request->file('media')->getClientOriginalName();
        $ext    = $request->file('media')->extension();

        //Set the new destination and name for the file
        $destination = 'temp/upload';
        $newName     = time().$name.'.'.$ext;

        //Move the file to a temporary directory while it's awaiting processing.
        $request->file('media')->storeAs($destination, $newName);

        //Store the upload in the database for use in the Job
        $upload = new Upload();
        $upload->filename   = $newName;
        //$upload->user_id    = $request->user()->id;
        $upload->user_id    = 1;
        $upload->status     = Upload::STATUS_QUEUED;
        $upload->save();

        //Queue the job for processing
        ProcessUpload::dispatch($upload)->onQueue('uploads');
    }

}