<?php

namespace Shoutzor\Model;

use Phalcon\Mvc\Model;

class Artist extends Model
{

  /**
  * @Primary
  * @Identity
  * @Column(type="integer")
  */
  public $id;

  /** @Column(type="string") */
  public $name;

  /** @Column(type="string") */
  public $summary;

  /** @Column(type="string") */
  public $image;

  public function initialize()
  {
    $this->hasManyToMany(
      'id',
      AlbumArtist::class,
      'artist_id',
      'album_id',
      Album::class,
      'id'
    );

    $this->hasManyToMany(
      'id',
      ArtistMedia::class,
      'artist_id',
      'media_id',
      Media::class,
      'id'
    );
  }

  public function getTopMedia(): array
  {
    $resultset = $this->modelsManager->createBuilder()
      ->columns([
          'm' => 'DISTINCT m.*',
          'popularity' => 'COUNT(h.id)',
          'played_at' => 'h.played_at',
      ])
      ->addFrom(Media::class, 'm')
      ->leftJoin(ArtistMedia::class, 'm.id = ma.media_id AND ma.artist_id = :artistId:', 'ma')
      ->leftJoin(History::class, 'h.media_id = m.id', 'h')
      ->groupBy('m.id')
      ->orderBy('popularity DESC')
      ->limit(5)
      ->getQuery()
      ->execute(['artistId' => $this->id]);

    // foreach($resultset as $result) {
    //     /** @var ShoutzorMedia $media */
    //     $media = $result->m;
    //     $popularity = $result->popularity;
    //     $playedAt = $result->played_at;
    //     // if you have relations set up, you can access them like so:
    //     /** @var ShoutzorMediaArtist $artist */
    //     $artist = $media->ShoutzorMediaArtist;
    // }

    //TODO played_at might have to be set. Will need to be tested

    return array_column($resultset, 'm');
  }

  public function getAlbums(): array
  {
    $resultset = $this->modelsManager->createBuilder()
      ->addFrom(Album::class, 'a')
      ->leftJoin(AlbumArtist::class, 'aa.artist_id = :artistId:', 'aa')
      ->where('a.id = aa.album_id')
      ->getQuery()
      ->execute(['artistId' => $this->id]);

    return array_column($resultset, 'a');
  }

  /**
   * Checks if the artist is currently in the request-queue
   */
  public static function isRequested($id): bool
  {
    $resultset = $this->modelsManager->createBuilder()
      ->columns(['id'])
      ->addFrom(Media::class, 'm')
      ->leftJoin(ArtistMedia::class, 'am.artist_id = :artistId:', 'am')
      ->leftJoin(Request::class, 'r.media_id = am.media_id', 'r')
      ->limit(1)
      ->getQuery()
      ->execute(['artistId' => $this->id]);

    return count($resultset) > 0;
  }

  /**
   * Checks if this artist has been recently played
   * This does NOT check if the artist is currently in the request-queue
   */
  public static function isRecentlyPlayed($id, $maxTimeAgo): bool
  {
    $resultset = $this->modelsManager->createBuilder()
      ->columns(['id'])
      ->addFrom(Media::class, 'm')
      ->leftJoin(ArtistMedia::class, 'am.artist_id = :artistId:', 'am')
      ->leftJoin(History::class, 'h.media_id = am.media_id', 'h')
      ->where('h.played_at > :maxTimeAgo:')
      ->limit(1)
      ->getQuery()
      ->execute(['artistId' => $this->id, 'maxTimeAgo' => $maxTimeAgo]);

    return count($resultset) > 0;

    // $q = Media::query()
    //   ->select('m.id')
    //   ->from('@shoutzor_media m')
    //   ->where('m.id IN
    //             ( SELECT h.media_id
    //               FROM   @shoutzor_history h
    //               WHERE  h.media_id IN
    //                 (
    //                    SELECT tma.media_id
    //                    FROM   @shoutzor_media_artist tma
    //                    WHERE  tma.artist_id IN
    //                       (
    //                          SELECT ttma.artist_id
    //                          FROM   @shoutzor_media_artist ttma
    //                          WHERE  ttma.media_id = :id))
    //               AND h.played_at > :maxTime)) OR
    //             (
    //               m.id IN
    //               (
    //                  SELECT q.media_id
    //                  FROM   @shoutzor_requestlist q
    //                  WHERE  q.media_id IN
    //                     (
    //                        SELECT tma.media_id
    //                        FROM   @shoutzor_media_artist tma
    //                        WHERE  tma.artist_id IN
    //                           (
    //                              SELECT ttma.artist_id
    //                              FROM   @shoutzor_media_artist ttma
    //                              WHERE  ttma.media_id = :id)))
    //             ', ['id' => $id, 'maxTime' => $canRequestDateTime]);
  }

  public function jsonSerialize()
  {
    $data = $this->toArray([], []);
    //$data['url'] = App::url('@shoutzor/artist/view', ['id' => $this->id]);

    return $data;
  }
}
