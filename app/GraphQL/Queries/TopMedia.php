<?php

namespace App\GraphQL\Queries;

use App\Models\Media;

final class TopMedia
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $artist = array_key_exists("artist", $args) ? $args['artist'] : null;
        $album = array_key_exists("album", $args) ? $args['album'] : null;
        $limit = array_key_exists("limit", $args) ? $args['limit'] : null;

        $media = Media::query()
            ->with(['artists'])
            ->leftJoin('artist_media', 'artist_media.media_id', '=', 'media.id')
            ->leftJoin('artists', 'artists.id', '=', 'artist_media.artist_id')
            ->leftJoin('requests', 'requests.media_id', '=', 'media.id')
            ->addSelect('artists.id as artist_id')
            ->addSelect('media.*')
            ->addSelect('media.id as id')
            ->selectRaw('count(requests.media_id) as request_count')
            ->groupBy('media.id')
            ->orderBy('request_count', 'DESC');

        if($artist) {
            $media->whereRaw('artist_media.artist_id = ?', [$artist]);
        }

        if($album) {
            $media->whereRaw('media.album_id = ?', [$album]);
        }

        if($limit) {
            $media->limit($limit);
        }

        return $media->get();
    }
}
