<?php

namespace App\Helper;

use PhpParser\Node\Stmt\Return_;
use Symfony\Component\HttpFoundation\Request;

abstract class ResponseFactory
{

    // MAKE RESPONSES RETURNS
    public static function responseMaker($data, Request $request)
    {
        return is_null($data) === true ?
            [
                "success" => false,
                "path" => $request->getPathInfo()
            ] :
            [
                "success" => true,
                "path" => $request->getPathInfo(),
                "data" => $data
            ];
    }

    // MAKE EXECEPTIONS RETURNS
    public static function exceptionMaker($message)
    {
        return [
            "success" => false,
            "info" => $message
        ];
    }
}
