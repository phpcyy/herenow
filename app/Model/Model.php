<?php

namespace Model;
class Model
{
    private static $connection;

    /**
     * @return \PDO
     */
    public static function getConnection()
    {
        if (!is_a(self::$connection, \PDO::class)) {
            $mysqlConfig = \App::getConfig("mysql");
            $connection = new \PDO(
                "mysql:host={$mysqlConfig['host']};port={$mysqlConfig['port']};dbname={$mysqlConfig['database']}",
                $mysqlConfig['username'],
                $mysqlConfig['password']
            );
            if (!is_a(self::$connection, \PDO::class)) {
                self::$connection = $connection;
            }
        }
        return self::$connection;
    }

    /**
     * @param $sql
     * @return array
     * @throws \Exception
     */
    public static function query($sql)
    {
        $query = self::getConnection()->query($sql);
        if (!$query && $err = self::getConnection()->errorInfo()) {
            throw new \Exception($err[2] . "\nsql is '$sql'");
        }
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        if (!self::getConnection()->inTransaction() && $query) {
            $query->closeCursor();
        }

        return $result;
    }

    public static function begin()
    {
        self::getConnection()->beginTransaction();
    }

    public static function commit()
    {
        self::getConnection()->commit();
    }

    public static function rollback()
    {
        self::getConnection()->rollBack();
    }

    public static function execute($sql)
    {
        return self::getConnection()->exec($sql);
    }

    public static function buildSQL($sql, $where = [], $limit = "", $group = "", $order = "")
    {
        $sql .= " where " . implode(" and ", $where);

        if ($group) {
            $sql .= " $group";
        }
        if ($order) {
            $sql .= " $order";
        }
        if ($limit) {
            $sql .= " $limit";
        }
        return $sql;
    }
}