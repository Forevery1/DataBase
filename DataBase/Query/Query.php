<?php

namespace DataBase\Query;

use DataBase\Schema\Grammar;

class Query extends Grammar {
    protected function compileStart() {
        $selects = implode(', ', $this->builder->columns);

        return "select {$selects} from {$this->builder->from} ";
    }
}
