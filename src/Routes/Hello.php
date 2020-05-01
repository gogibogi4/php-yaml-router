<?php

namespace Demo\Routes;

use Demo\Dependency\NumberProvider;
use Demo\Utils\JSONResponse;

class Hello
{
    private $x;

    public function __construct(NumberProvider $x)
    {
        $this->x = $x;
    }

    /**
     * @return array
     */
    public function helloRequest()
    {
        return JSONResponse::respondSuccess($this->x->getNumber());
    }
}