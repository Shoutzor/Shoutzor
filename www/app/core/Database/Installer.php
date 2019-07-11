<?php

namespace Shoutzor\Database;

use Phalcon\Db\Column;
use Phalcon\Db\Index;

class Installer
{

  private $connection;

  public function __construct(Connection $connection)
  {
    $this->connection = $connection->getConnection();
  }

  /**
   * Creates the required tables for Shoutzor to run
   */
  public function createTables()
  {
    /*
     * Create the "album" table
     */
    $this->connection->createTable(
      'album', null, [ 'columns' => [
        new Column('id',      [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('title',   [ 'type' => Column::TYPE_VARCHAR, 'size' => 70, 'notNull' => true ]),
        new Column('summary', [ 'type' => Column::TYPE_TEXT, 'notNull' => true ]),
        new Column('image',   [ 'type' => Column::TYPE_VARCHAR, 'size' => 255, 'notNull' => true ])
    ]]);

    /*
     * Create the "artist" table
     */
    $this->connection->createTable(
      'artist', null, [ 'columns' => [
        new Column('id',      [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('name',    [ 'type' => Column::TYPE_VARCHAR, 'size' => 70, 'notNull' => true ]),
        new Column('summary', [ 'type' => Column::TYPE_TEXT, 'notNull' => true ]),
        new Column('image',   [ 'type' => Column::TYPE_VARCHAR, 'size' => 255, 'notNull' => true ])
    ]]);

    /*
     * Create the "media" table
     */
    $this->connection->createTable(
      'media', null, [ 'columns' => [
        new Column('id',          [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('title',       [ 'type' => Column::TYPE_VARCHAR, 'size' => 255, 'notNull' => true ]),
        new Column('filename',    [ 'type' => Column::TYPE_VARCHAR, 'size' => 255, 'notNull' => true ]),
        new Column('uploader_id', [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true]),
        new Column('status',      [ 'type' => Column::TYPE_INTEGER, 'size' => 1, 'notNull' => true, 'default' => 0]),
        new Column('created',     [ 'type' => Column::TYPE_DATETIME ]),
        new Column('crc',         [ 'type' => Column::TYPE_TEXT, 'notNull' => true]),
        new Column('duration',    [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'unsigned' => true])
      ],
      'indexes' => [
        new Index("uploader_index", ['uploader_id']),
        new Index("status_index",   ['status']),
        new Index("created_index",  ['created']),
    ]]);

    /*
     * Create the "request" table
     */
    $this->connection->createTable(
      'request', null, [ 'columns' => [
        new Column('id',            [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('media_id',      [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true]),
        new Column('requester_id',  [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true]),
        new Column('requesttime',   [ 'type' => Column::TYPE_DATETIME ]),
      ],
      'indexes' => [
        new Index("media_index",        ['media_id']),
        new Index("requester_index",    ['requester_id']),
        new Index("requesttime_index",  ['requesttime']),
    ]]);

    /*
     * Create the "history" table
     */
    $this->connection->createTable(
      'history', null, [ 'columns' => [
        new Column('id',            [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('media_id',      [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true]),
        new Column('requester_id',  [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true]),
        new Column('played_at',     [ 'type' => Column::TYPE_DATETIME ]),
      ],
      'indexes' => [
        new Index("media_index",      ['media_id']),
        new Index("requester_index",  ['requester_id']),
        new Index("played_at_index",  ['played_at']),
    ]]);

    /*
     * Create the "user" table
     */
    $this->connection->createTable(
      'user', null, [ 'columns' => [
        new Column('id',          [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('username',    [ 'type' => Column::TYPE_VARCHAR, 'size' => 25, 'notNull' => true ]),
        new Column('email',       [ 'type' => Column::TYPE_VARCHAR, 'size' => 255, 'notNull' => true ]),
        new Column('verified',    [ 'type' => Column::TYPE_INTEGER, 'size' => 1, 'notNull' => true, 'default' => 0]),
        new Column('banned',      [ 'type' => Column::TYPE_INTEGER, 'size' => 1, 'notNull' => true, 'default' => 0]),
        new Column('created',     [ 'type' => Column::TYPE_DATETIME ]),
      ],
      'indexes' => [
        new Index("username_index", ['username']),
        new Index("verified_index", ['verified']),
        new Index("banned_index",   ['banned'])
    ]]);

    /*
     * Create the "album_artist" table
     */
    $this->connection->createTable(
      'album_artist', null, [ 'columns' => [
        new Column('id',        [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('album_id',  [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true ]),
        new Column('artist_id', [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true])
      ],
      'indexes' => [
        new Index("album_artist_index", ['album_id', 'artist_id'], "UNIQUE")
    ]]);

    /*
     * Create the "album_media" table
     */
    $this->connection->createTable(
      'album_media', null, [ 'columns' => [
        new Column('id',        [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('album_id',  [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true ]),
        new Column('media_id',  [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true ])
      ],
      'indexes' => [
        new Index("album_media_index", ['album_id', 'media_id'], "UNIQUE")
    ]]);

    /*
     * Create the "artist_media" table
     */
    $this->connection->createTable(
      'album_media', null, [ 'columns' => [
        new Column('id',        [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true, 'autoIncrement' => true, 'primary' => true ]),
        new Column('artist_id', [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true ]),
        new Column('media_id',  [ 'type' => Column::TYPE_INTEGER, 'size' => 10, 'notNull' => true ])
      ],
      'indexes' => [
        new Index("artist_media_index", ['artist_id', 'media_id'], "UNIQUE")
    ]]);
  }

}
