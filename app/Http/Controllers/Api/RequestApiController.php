<?php

namespace App\Http\Controllers\Api;

use App\Request;
use App\Http\Controllers\Controller;

class RequestApiController extends Controller {

    public function index() {
        $requests = Request::with(['Media', 'Media.Artists', 'User'])->get();

        return response()->json($requests, 200);
    }

}
