<?php
require_once "../vendor/autoload.php";
try {
    $app = new App();
    $app->dispatch()->response();
} catch (Throwable $throwable) {
    (new \Http\Response([
        "code" => $throwable->getCode(),
        "message" => $throwable->getMessage()
    ]))->send();
}
