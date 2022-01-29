<?php

namespace Src\Presentation\Controllers\Utils;

use Src\Presentation\Controllers\Contracts\HttpResponse;

class HttpHelper
{
    public static function ok($data) : HttpResponse
    {
        return new HttpResponse(200, $data);
    }
    
    public static function created($data) : HttpResponse
    {
        return new HttpResponse(201, $data);
    }
    
    public static function forbidden($error) : HttpResponse
    {
        return new HttpResponse(403, $error);
    }
    
    public static function badRequest($error) : HttpResponse
    {
        return new HttpResponse(400, $error);
    }
    
    public static function serverError($error) : HttpResponse
    {
        return new HttpResponse(500, $error);
    }    
}