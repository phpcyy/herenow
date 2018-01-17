<?php
/**
 * Created by PhpStorm.
 * User: phpcyy
 * Date: 05/01/2018
 * Time: 9:20 AM
 */

namespace Model;


class UserModel extends Model
{
    public function find($id, $fields = [])
    {
        $sql = self::buildSQL();
    }

    public static function checkPassword($username, $password)
    {
        $sql = "select `password` from `user`";
        $where = [
            "username = '$username'"
        ];
        $sql = self::buildSQL($sql, $where, 'limit 1');
        $result = self::query($sql);
        if (count($result) < 1) {
            throw new \Exception("用户尚未注册", -2);
        }
        if (password_verify($password, $result[0]['password'])) {
            return true;
        }
        throw new \Exception("用户密码错误", -2);
    }
}