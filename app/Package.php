<?php

namespace App;

use App\Packages\PackageLoader;
use App\Packages\PackageManager;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    //This model doesn't utilize an SQL table
    protected $table    = '';
    public $timestamps  = false;

    //Stores the instance of the related package
    protected PackageLoader $package;

    protected $fillable = [
        'name',
        'author',
        'website',
        'description',
        'version',
        'license',
        'enabled'
    ];

    /**
     * Create a new Package Model instance
     *
     * @param PackageLoader $package
     */
    public function __construct(PackageLoader $package) {
        parent::__construct();

        //Set the package reference
        $this->package = $package;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach($this->fillable as $key) {
            $result[$key] = $this->{$key};
        }

        return $result;
    }

    /**
     * Get an attribute from the package for the model
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key) {
        if($key === 'enabled') {
            return app(PackageManager::class)->isEnabled($this->package);
        } else {
            return $this->package->getProperty($key, null);
        }
    }

    /**
     * DISABLED - Since this is effectively read-only from the package file, this method is unused
     *
     * @param $key
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function __set($key, $value) {
        throw new Exception("Not implemented");
    }

    /**
     * DISABLED - Not a SQL Table Model
     *
     * @return void
     * @throws Exception
     */
    public function getConnection() {
        throw new Exception("Not implemented");
    }

    /**
     * DISABLED - Not a SQL Table Model
     *
     * @param array|\Illuminate\Support\Collection|int|string $ids
     * @return int|void
     * @throws Exception
     */
    public static function destroy($ids) {
        throw new Exception("Not implemented");
    }

    /**
     * DISABLED - Not a SQL Table Model
     *
     * @return bool|void|null
     * @throws Exception
     */
    public function delete() {
        throw new Exception("Not implemented");
    }

    /**
     * DISABLED - Not a SQL Table Model
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return Package|\Illuminate\Database\Eloquent\Builder|void
     * @throws Exception
     */
    public function newEloquentBuilder($query) {
        throw new Exception("Not implemented");
    }
}
