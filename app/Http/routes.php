<?php
return [
    "get" => [
        "/" => "home@index",
        "/post/{post:\d+}" => "home@get"
    ]
];