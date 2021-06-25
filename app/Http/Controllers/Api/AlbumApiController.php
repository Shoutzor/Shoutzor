<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlbumApiController extends Controller
{

    public function get(Request $request, int $id)
    {
        $album = Album::find($id);

        if (!$album) {
            return response()->json(['message' => 'Album with id '.$id.' not found'], 404);
        }

        return response()->json($album->toArray(), 200);
    }

}
