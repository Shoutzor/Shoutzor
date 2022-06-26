<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessUpload;
use App\Models\Upload;
use Illuminate\Http\Request;

class UploadApiController extends Controller
{
    public function store(Request $request)
    {
        //Check if a file has been provided with the request
        if ($request->hasFile('media') !== true) {
            return response()->json(['error' => 'No file with name media uploaded'], 400);
        }

        //Check if there are any errors with the file upload
        if ($request->file('media')->isValid() !== true) {
            return response()->json(['error' => 'The uploaded file did not upload correctly'], 400);
        }

        //Get the name and extension of the file
        $name = md5($request->file('media')->getClientOriginalName());
        $ext = $request->file('media')->extension();

        // TODO supported media extensions should dynamically be provided by modular processing modules
        $validExtensions = [
            //Audio extensions
            'mp3', 'ogg', 'wav', 'flac', 'm4a', 'wma', 'weba'

            //Video is not implemented yet
            //'webm', 'avi', 'mp4', 'mkv'
        ];

        if(!in_array($ext, $validExtensions)) {
            return response()->json(['error' => 'The uploaded file format is unsupported'], 400);
        }

        //Set the new filename (format: timestamp-md5hash.ext)
        $newName = time() . '-' . $name . '.' . $ext;

        //Move the file to a temporary directory while it's awaiting processing.
        $request->file('media')->storeAs(Upload::STORAGE_PATH, $newName);

        //Store the upload in the database for use in the Job
        $upload = new Upload([
            'filename' => $newName,
            'uploaded_by' => $request->user()->id,
            'status' => Upload::STATUS_QUEUED
        ]);
        $upload->save();

        //Add the Upload as a job to the Queue for processing
        ProcessUpload::dispatch($upload)->onQueue(Upload::QUEUE_NAME);

        return response()->json(['message' => 'Upload queued for processing'], 200);
    }

}
