<?php
declare(strict_types=1);

namespace Ecommerce\Models;


abstract class Model extends Database
{
    protected function __construct(string $class, string $table)
    {
        parent::__construct($class, $table);
    }
}