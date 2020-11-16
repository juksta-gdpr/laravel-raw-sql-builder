<?php

namespace Juksta\LaravelRawSqlBuilder\Database\Query\Grammars;

use Illuminate\Database\Query\Grammars\Grammar as BaseGrammar;
use Illuminate\Database\Query\Builder;

class Grammar extends BaseGrammar
{
    public function compileWheresSql(Builder $query)
    {
        return $this->compileWheres($query);
    }

    public function compileOrdersSql(Builder $query)
    {
        return $this->compileOrders($query, $query->orders);
    }

    public function compileLimitSql(Builder $query)
    {
        return $this->compileLimit($query, $query->limit);
    }

    public function compileOffsetSql(Builder $query)
    {
        return $this->compileOffset($query, $query->offset);
    }
}
