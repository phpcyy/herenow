<?php

namespace Controller;

use Http\Request;
use Model\PostModel;

class HomeController extends Controller
{
    public function indexAction(string $post = "", Request $request)
    {
        return $this->success(PostModel::getPosts(1));
    }

    public function userAction($id, $post)
    {

    }
}
