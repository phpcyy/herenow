<?php
/**
 * Created by PhpStorm.
 * User: phpcyy
 * Date: 05/01/2018
 * Time: 10:02 AM
 */

namespace Controller;


use Http\Request;
use Model\UserModel;

class SessionController extends Controller
{
    public function getAction()
    {

    }

    public function postAction(Request $request)
    {
        $username = $request->getPostField("username");
        $password = $request->getPostField("password");
        UserModel::checkPassword($username, $password);
    }

    public function put()
    {

    }

    public function delete()
    {

    }
}