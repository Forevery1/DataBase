<?php

namespace Database\Query;

class First extends Query {

    public function compileEnd() {
        // 设置返回的条数
        $this->builder->limit(1);

        return parent::compileEnd();
    }
}
