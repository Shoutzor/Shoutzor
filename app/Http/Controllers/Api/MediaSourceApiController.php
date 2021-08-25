<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaSourceApiController extends Controller
{

    public function get(Request $request, int $id)
    {

        return response()->json([], 200);
    }

}
