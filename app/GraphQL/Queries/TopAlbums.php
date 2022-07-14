<?php

namespace App\GraphQL\Queries;

use App\Models\Album;

final class TopAlbums
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $artist = $args['artist'];
        $limit = array_key_exists("limit", $args) ? $args['limit'] : 10;

        return Album::query()
            ->leftJoin('media', 'media.album_id', '=', 'albums.id')
            ->leftJoin('artist_media', 'artist_media.media_id', '=', 'media.id')
            ->leftJoin('requests', 'requests.media_id', '=', 'media.id')
            ->addSelect('albums.*')
            ->selectRaw('albums.id as id')
            ->selectRaw('count(requests.media_id) as request_count')
            ->whereRaw('artist_media.artist_id = ?', [$artist])
            ->groupBy('albums.id')
            ->orderBy('request_count', 'DESC')
            ->limit($limit)
            ->get();
    }
}
