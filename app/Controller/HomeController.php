<?php

namespace Controller;

use Http\Request;

class HomeController extends Controller
{
    public function indexAction(string $post = "", Request $request)
    {
        return $this->success();
    }

    public function userAction($id, $post)
    {

    }
}
