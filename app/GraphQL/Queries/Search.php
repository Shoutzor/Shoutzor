<?php

namespace App\GraphQL\Queries;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Media;

final class Search
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        $q = '%' . $args['q'] . '%';

        $media = Media::query()
            ->with('artists')
            ->leftJoin('artist_media', function($join) {
                $join->on('artist_media.media_id', '=', 'media.id');
            })
            ->leftJoin('artists', function($join) {
                $join->on('artists.id', '=', 'artist_media.artist_id');
            })
            ->selectRaw('SUM( (MATCH (media.title) AGAINST (?) * 2) + MATCH (artists.name) AGAINST (?) ) AS relevance', [$q, $q])
            ->addSelect('artists.id as artist_id')
            ->addSelect('media.*')
            ->addSelect('media.id as id')
            ->whereRaw('media.title LIKE ?', [$q])
            ->orWhereRaw('artists.name LIKE ?', [$q])
            // TODO: find out if you can partial match-against ? ie: WHERE x LIKE '%something%'
            //->whereRaw('MATCH (media.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            //->orWhereRaw('MATCH (artists.name) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->groupBy('media.id')
            ->orderBy('relevance', 'DESC')
            ->get();

        $artists = Artist::query()
            ->where('name', 'like', $q)
            ->get();

        $albums = Album::query()
            ->where('title', 'like', $q)
            ->get();

        return [
            'media' => $media,
            'artists' => $artists,
            'albums' => $albums
        ];
    }
}
