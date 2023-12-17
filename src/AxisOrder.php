<?php

declare(strict_types=1);

namespace MatanYadaev\EloquentSpatial;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use PDO;

class AxisOrder
{
  public function __construct()
  {
  }

  public function supported(ConnectionInterface $connection): bool
  {
    if ($this->isPostgres($connection)) {
      // @codeCoverageIgnoreStart
      return false;
      // @codeCoverageIgnoreEnd
    }

    /** @var MySqlConnection $connection */
    if ($this->isMariaDb($connection)) {
      // @codeCoverageIgnoreStart
      return false;
      // @codeCoverageIgnoreEnd
    }

    if ($this->isMySql57($connection)) {
      // @codeCoverageIgnoreStart
      return false;
      // @codeCoverageIgnoreEnd
    }

    return true;
  }

  private function isPostgres(ConnectionInterface $connection): bool
  {
    return $connection instanceof PostgresConnection;
  }

  private function isMariaDb(MySqlConnection $connection): bool
  {
    return $connection->isMaria();
  }

  private function isMySql57(MySqlConnection $connection): bool
  {
    /** @var string $version */
    $version = $connection->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);

    return version_compare($version, '5.8.0', '<');
  }
}
