<?php

namespace Database\Query;


use Database\Schema\Grammar;

class Delete extends Grammar {
    public function compileStart() {
        $start = "delete from {$this->builder->from} ";

        return $start;
    }
}
