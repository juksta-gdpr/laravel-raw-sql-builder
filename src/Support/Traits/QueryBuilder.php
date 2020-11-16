<?php

namespace Juksta\LaravelRawSqlBuilder\Support\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Juksta\LaravelRawSqlBuilder\Database\Query\Grammars\Grammar;

trait QueryBuilder
{
    public function getQueryBuilder()
    {
        $q = new Builder(
            DB::connection(),
            new Grammar
        );

        return $q;
    }

    public function compileWheresSql($queryBuilder)
    {
        return $queryBuilder->getGrammar()->compileWheresSql($queryBuilder);
    }

    public function compileOrdersSql($queryBuilder)
    {
        return $queryBuilder->getGrammar()->compileOrdersSql($queryBuilder);
    }

    public function compileLimitSql($queryBuilder)
    {
        return $queryBuilder->getGrammar()->compileLimitSql($queryBuilder);
    }

    public function compileOffsetSql($queryBuilder)
    {
        return $queryBuilder->getGrammar()->compileOffsetSql($queryBuilder);
    }
}
