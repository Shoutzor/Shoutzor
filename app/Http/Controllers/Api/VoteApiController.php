<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class VoteApiController extends Controller
{

    public function count()
    {
        $votes = Vote::with(['Media', 'Media.Artists'])
            ->select('media_id', DB::raw('count(*) as count'))
            ->groupBy('media_id')
            ->get()
            ->toArray();

        return response()->json($votes, 200);
    }

}
