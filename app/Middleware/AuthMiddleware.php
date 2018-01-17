<?php

namespace Middleware;
class AuthMiddleware implements Middleware
{
    public function handle()
    {
        $token = \App::getRequest()->getCookie("token");
    }
}