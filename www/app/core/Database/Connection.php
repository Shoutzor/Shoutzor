<?php

namespace Shoutzor\Database;

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;

class Connection
{

  private $config;
  private $connection;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function connect()
  {
    $class = 'Phalcon\Db\Adapter\Pdo\\' . $this->config->database->adapter;
    $params = [
        'host'     => $this->config->database->host,
        'username' => $this->config->database->username,
        'password' => $this->config->database->password,
        'dbname'   => $this->config->database->dbname,
        'charset'  => $this->config->database->charset
    ];

    if ($this->config->database->adapter == 'Postgresql') {
        unset($params['charset']);
    }

    $this->connection = new $class($params);
  }

  public function getConnection()
  {
    return $this->connection;
  }
}
