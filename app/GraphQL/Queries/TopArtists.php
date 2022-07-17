<?php

namespace App\GraphQL\Queries;

use App\Models\Album;
use App\Models\Artist;

final class TopArtists
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $album = $args['album'];
        $limit = array_key_exists("limit", $args) ? $args['limit'] : 10;

        // Return most popular artists, ordered by who has their media requested the most

        return Artist::query()
            ->leftJoin('artist_media', 'artist_media.artist_id', '=', 'artists.id')
            ->leftJoin('requests', 'requests.media_id', '=', 'artist_media.media_id')
            ->leftJoin('media', 'media.id', '=', 'artist_media.media_id')
            ->addSelect('artists.*')
            ->selectRaw('artists.id as id')
            ->selectRaw('count(requests.media_id) as request_count')
            ->whereRaw('media.album_id = ?', [$album])
            ->groupBy('artists.id')
            ->orderBy('request_count', 'DESC')
            ->limit($limit)
            ->get();
    }
}
