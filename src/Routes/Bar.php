<?php

namespace Demo\Routes;

use Klein\Request;
use Demo\Utils\JSONResponse;

class Bar
{
    /**
     * @param Request $request
     * @return string
     */
    public function foo(Request $request): string
    {
        return JSONResponse::respondSuccess(['foo' => $request->name]);
    }
}