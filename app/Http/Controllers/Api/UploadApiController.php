<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadApiController extends Controller {

    public function store(Request $request) {

        //@TODO create a Task for each file that's uploaded, to queue them for processing.
        //Move the file to a temporary directory while it's awaiting processing.

        //$request->file('media')->extension();
        //$request->file('media')->storeAs('where/to/store', 'filename.ext');

    }

}
