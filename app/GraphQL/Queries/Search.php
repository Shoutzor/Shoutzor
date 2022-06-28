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
        $q = $args['q'];

        // TODO query input sanitization

        $media = Media::query()
            ->with(['artists'])
            ->leftJoin('artist_media', 'artist_media.media_id', '=', 'media.id')
            ->leftJoin('artists', 'artists.id', '=', 'artist_media.artist_id')
            ->leftJoin('albums', 'media.album_id', '=', 'albums.id')
            ->selectRaw('SUM(
                (MATCH (media.title) AGAINST (?) * 3) +
                (MATCH (artists.name) AGAINST (?) * 2) +
                MATCH (albums.title) AGAINST (?)
            ) AS relevance', [$q, $q, $q])
            ->addSelect('artists.id as artist_id')
            ->addSelect('media.*')
            ->addSelect('media.id as id')
            // TODO: find out if you can partial match-against ? ie: WHERE x LIKE '%something%'
            ->whereRaw('MATCH (media.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->orWhereRaw('MATCH (artists.name) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->orWhereRaw('MATCH (albums.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->groupBy('media.id')
            ->orderBy('relevance', 'DESC')
            ->get();

        $artists = Artist::query()
            ->leftJoin('artist_media', 'artist_media.artist_id', '=', 'artists.id')
            ->leftJoin('media', 'media.id', '=', 'artist_media.media_id')
            ->leftJoin('albums', 'media.album_id', '=', 'albums.id')
            ->selectRaw('SUM(
                (MATCH (artists.name) AGAINST (?) * 3) +
                (MATCH (media.title) AGAINST (?) * 2) +
                MATCH (albums.title) AGAINST (?)
            ) AS relevance', [$q, $q, $q])
            ->addSelect('artists.*')
            // TODO: find out if you can partial match-against ? ie: WHERE x LIKE '%something%'
            ->whereRaw('MATCH (media.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->orWhereRaw('MATCH (artists.name) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->orWhereRaw('MATCH (albums.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->groupBy('artists.id')
            ->orderBy('relevance', 'DESC')
            ->get();

        $albums = Album::query()
            ->leftJoin('media', 'albums.id', '=', 'media.album_id')
            ->leftJoin('artist_media', 'artist_media.media_id', '=', 'media.id')
            ->leftJoin('artists', 'artist_media.artist_id', '=', 'artists.id')
            ->selectRaw('SUM(
                (MATCH (albums.title) AGAINST (?) * 3) +
                (MATCH (media.title) AGAINST (?) * 2) +
                MATCH (artists.name) AGAINST (?)
            ) AS relevance', [$q, $q, $q])
            ->addSelect('albums.*')
            // TODO: find out if you can partial match-against ? ie: WHERE x LIKE '%something%'
            ->whereRaw('MATCH (media.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->orWhereRaw('MATCH (artists.name) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->orWhereRaw('MATCH (albums.title) AGAINST (? IN BOOLEAN MODE)', [$q])
            ->groupBy('albums.id')
            ->orderBy('relevance', 'DESC')
            ->get();

        return [
            'media' => $media,
            'artists' => $artists,
            'albums' => $albums
        ];
    }
}
