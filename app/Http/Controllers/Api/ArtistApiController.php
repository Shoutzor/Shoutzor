<?php

namespace App\Http\Controllers\Api;

use App\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistApiController extends Controller {

    public function get(Request $request, int $id) {
        $artist = Artist::find($id);

        if(!$artist) {
            return response()->json(['message' => 'Album with id '.$id.' not found'], 404);
        }

        return response()->json($artist->toArray(), 200);
    }

}
