<?php

namespace Model;
class PostModel extends Model
{
    protected $table = "articles";

    public static function get($user, $limit = 10, $offset = 0, $search = "")
    {
        $sql = "select `id`, `author_id`, `content`, `created_at`, `updated_at`, `looktime` from `articles`";
        $where = [];
        if ($user) {
            $where[] = "`author_id` = $user";
        }

        if ($search) {
            $where[] = "`content` likes $search";
        }

        $limit = "limit $limit offset $offset";

        $sql = self::buildSQL($sql, $where, $limit, "", "order by created_at desc");

        return self::query($sql);
    }


}