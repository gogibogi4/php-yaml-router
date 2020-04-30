<?php

namespace Demo\Routes;

use Demo\Utils\JSONResponse;

class Hello
{
    /**
     * @return array
     */
    public function helloRequest()
    {
        return JSONResponse::respondSuccess('hello');
    }
}