<?php

namespace Demo\Dependency;

class NumberProvider
{
    /** @var int */
    private $x = 7;

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->x;
    }
}