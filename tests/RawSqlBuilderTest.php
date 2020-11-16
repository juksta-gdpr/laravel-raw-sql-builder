<?php

namespace Juksta\LaravelRawSqlBuilder\Tests;

use Juksta\LaravelRawSqlBuilder\Tests\TestCase as BaseTestCase;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;

use Juksta\LaravelRawSqlBuilder\Support\Traits\QueryBuilder as QueryBuilderTrait;

class RawSqlBuilderTest extends BaseTestCase
{
    use QueryBuilderTrait;

    public function testComplexSql()
    {
        $targetSql = <<<EOT
SELECT 
            b.id,
            b.name,
            pp.name as product_plan,
            b.created_at
        
            FROM
                business b
                LEFT JOIN business_product_plan bpp ON (bpp.business_id = b.id AND bpp.active = 1)
                LEFT JOIN product_plan pp ON (pp.id = bpp.product_plan_id)
        where b.name like ? order by "b"."name" asc limit 10 offset 10
EOT;

        $bindings = [];

        $fields = "
            b.id,
            b.name,
            pp.name as product_plan,
            b.created_at
        ";

        $sql = "
            SELECT :fields
            FROM
                business b
                LEFT JOIN business_product_plan bpp ON (bpp.business_id = b.id AND bpp.active = 1)
                LEFT JOIN product_plan pp ON (pp.id = bpp.product_plan_id)
        ";


        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder->where(new Expression('b.name'), 'like', '%LTD%');
        $sql .= $this->compileWheresSql($queryBuilder) . ' ';

        $bindings += $queryBuilder->getBindings();

        if (true) {
            $orderColumn = 'b.name';
            $orderDirection = 'ASC';

            $queryBuilder->orderBy($orderColumn, $orderDirection);
        }

        if (true) {
            $offset = 10;
            $length = 10;
            $queryBuilder->offset($offset);
            $queryBuilder->limit($length);
        }

        $totalSql = $sql;

        $sql .= $this->compileOrdersSql($queryBuilder) . ' ';
        $sql .= $this->compileLimitSql($queryBuilder) . ' ';
        $sql .= $this->compileOffsetSql($queryBuilder);

        $sql = trim(str_replace(":fields", $fields, $sql));

        $this->assertEquals($targetSql, $sql);

        //$items = DB::select(DB::raw($sql), $bindings);
    }
}
