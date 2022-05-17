<?php

require_once 'config.php';

class MySQLDatabase {

    private $connection;

    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_USERPW);
        if (!$this->connection) {
            //die("Database connection failed".mysql_error()); //displaying mysql error message is dangerous
            die("Database connection failed");
        } else {
            $db_select = mysqli_select_db($this->connection, DB_NAME);
            if (!$db_select) {
                //die ("DB Select command connection failed".mysql_error());
                die("DB Select command connection failed");
            }
        }
    }

    public function query($sql) {
        if (isset($this->connection)) {
            $result = mysqli_query($this->connection, $sql);
            if (!$result) {
                die("Database query failed." . mysqli_error($this->connection));
            }
            return $result;
        }
    }

    public function close_connection() {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
            print "Connection is closing";
        }
    }

    public function escape_value($value) {
//        $magic_quotes_active = get_magic_quotes_gpc();
//        $new_enough_php = function_exists("mysqli_real_escape_string");
//        if ($new_enough_php) {
//            //for php v.4.3.0 or higher, do as follows:
//            if ($magic_quotes_active) {
//                $value = stripslashes($value);
//            }
//            $value = mysqli_real_escape_string($this->connection, $value);
//        } else {
//            //for older php versions, do as follows
//            if (!$magic_quotes_active) {
//                $value = addslashes($value);
//            }
//        }
        return $value;
    }

    public function insert_id() {
        return mysqli_insert_id($this->connection);
    }

}

$database = new MySQLDatabase();
