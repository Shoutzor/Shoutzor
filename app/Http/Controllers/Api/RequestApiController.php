<?php

namespace App\Http\Controllers\Api;

use App\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;

class RequestApiController extends Controller {

    public function index() {
        $requests = Request::all();

        return response()->json($requests, 200);
    }

}
