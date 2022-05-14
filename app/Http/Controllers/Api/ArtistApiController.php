<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistApiController extends Controller
{

    public function get(Request $request, string $uuid)
    {
        $artist = Artist::find($uuid);

        if (!$artist) {
            return response()->json(['message' => 'Album with id '.$uuid.' not found'], 404);
        }

        return response()->json($artist->toArray(), 200);
    }

}
