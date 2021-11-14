<?php

namespace App\Http\Controllers\Api;

use App\Album;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlbumApiController extends Controller
{

    public function get(Request $request, string $uuid)
    {
        try {
            $album = Album::with(['artists', 'media.artists'])->find($uuid);
            dd($album);
        } catch(\Exception $e) {
            dd($e);
        }

        if (!$album) {
            return response()->json(['message' => 'Album with id '.$uuid.' not found'], 404);
        }

        return response()->json($album->toArray(), 200);
    }

}
