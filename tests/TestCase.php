<?php

namespace Juksta\LaravelRawSqlBuilder\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Illuminate\Database\Connection;
use Mockery;

use Illuminate\Database\Query\Processors\MySqlProcessor;
use Illuminate\Support\Facades\DB;

class TestCase extends PHPUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $dbConnection = Mockery::mock(Connection::class);
        $dbConnection->shouldReceive('getPostProcessor')->andReturn(new MySqlProcessor());

        DB::shouldReceive('connection')
            ->once()
            ->andReturn($dbConnection);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
