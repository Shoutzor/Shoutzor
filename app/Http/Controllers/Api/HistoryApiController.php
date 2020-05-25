<?php

namespace App\Http\Controllers\Api;

use App\History;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;

class HistoryApiController extends Controller {

    public function index() {
        $history = History::with(['Media', 'Media.Artists', 'User'])->latest()->get();

        return response()->json($history, 200);
    }

    public function last() {
        $history = History::with(['Media', 'Media.Artists', 'User'])->latest()->first();

        return response()->json($history, 200);
    }

}
