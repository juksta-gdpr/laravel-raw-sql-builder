# Laravel Raw SQL Builder #

Laravel Raw SQL Builder is a library that helps build raw sql text queries. It's
built on top of the Eloquent query builder. 

## Usage

```php
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
                LEFT JOIN business_unit bu ON (bu.business_id = b.id AND bu.active = 1)
        ";


        $queryBuilder = $this->getQueryBuilder();

        $queryBuilder->where(new Expression('b.name'), 'like', '%LTD%');
        $sql .= $this->compileWheresSql($queryBuilder) . ' ';

        $bindings += $queryBuilder->getBindings();

        if ($condition) {
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

        $items = DB::select(DB::raw($sql), $bindings);
```
