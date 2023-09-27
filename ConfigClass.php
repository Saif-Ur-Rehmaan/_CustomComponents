<?php 
session_start();
$connection = mysqli_connect("localhost", "root", "", "freshcart");
if (!$connection) {
    header("location: pages/404.php");
    die();
} 
class DatabaseManager
{
    public static function connect()
    {
        $connection = mysqli_connect("localhost", "root", "", "freshcart");
        if (!$connection) {
            header("location: pages/404.php");
            die();
        }
        return $connection;
    }
    public static function query($sql)
    {
        $connection = self::connect();
        if (!$connection) {
            header("location: pages/404.php");
            die();
        }
        return mysqli_query($connection, $sql);
    }
    public static function fetch_Assoc($sql)
    {
        $a = self::query($sql);
        return mysqli_fetch_assoc($a);
    }
    public static function fetch_Assoc_All($sql)
    {
        $result = self::query($sql);
        $array = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }

        return $array;
    }
    public static function getColumnNames($table)
    {
        $connection = self::connect();

        $sql = "DESCRIBE $table";
        $result = self::query($sql);

        $columns = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }

        self::close($connection);

        return $columns;
    }
    public static function getTableNames()
    {
        $connection = self::connect();

        $sql = "SHOW TABLES";
        $result = self::query($sql);

        $tables = [];

        while ($row = mysqli_fetch_array($result)) {
            $tables[] = $row[0];
        }

        self::close($connection);

        return $tables;
    }

    public static function close($connection)
    {
        mysqli_close($connection);
    }

    public static function select($table, $columns = "*", $conditions = "")
    {
        $connection = self::connect();

        $sql = "SELECT $columns FROM $table";
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        $result = self::fetch_Assoc_All($sql);


        return $result;
    }

    public static function insert($table, $data)
    {
        $connection = self::connect();

        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $result = self::query($sql);

        self::close($connection);

        return $result;
    }

    public static function update($table, $data, $conditions)
    {
        $connection = self::connect();

        $updates = [];
        foreach ($data as $column => $value) {
            $updates[] = "$column = '$value'";
        }

        $updates = implode(", ", $updates);

        $sql = "UPDATE $table SET $updates WHERE $conditions";
        $result = self::query($sql);

        self::close($connection);

        return $result;
    }

    public static function delete($table, $conditions)
    {
        $connection = self::connect();

        $sql = "DELETE FROM $table WHERE $conditions";
        $result = self::query($sql);

        self::close($connection);

        return $result;
    }
}

?>

 