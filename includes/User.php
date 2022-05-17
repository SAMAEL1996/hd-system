<?php

require_once 'init.php';

class User {
    protected static $tablename = "useraccounts";
    protected static $db_fields = array('userid', 'name', 'iduser', 'usertype', 'emailadd', 'password', 'gender', 'age', 'birthday', 'mobileno', 'address', 'recadddate');
    public $userid;
    public $name;
    public $iduser;
    public $usertype;
    public $emailadd;
    public $password;
    public $gender;
    public $age;
    public $birthday;
    public $mobileno;
    public $address;
    public $recadddate;
    public $usertypevalue = array(
        10 => "Admin",
        20 => "Client"
    );
    public $userstatusvalue = array(
        0 => "Deactivated",
        1 => "Active"
    );

    public static function find_all() {
        $query = self::find_by_sql("select * from " . self::$tablename);
        return $query;
    }
    
    public static function find_all_users() {
        $query = self::find_by_sql("select * from " . self::$tablename . " where usertype not in ( 20 )");
        return $query;
    }

    public static function find_by_id($userid = 0) {
        global $database;
        $query = self::find_by_sql("select * from " . self::$tablename . " where userid ='" . $database->escape_value($userid) . "' LIMIT 1");
        return !empty($query) ? array_shift($query) : false;
    }
    
  
    public static function find_by_email($emailadd = "") {
        global $database;
        $query = self::find_by_sql("SELECT * FROM " . self::$tablename . " where emailadd = '" . $database->escape_value($emailadd) . "' LIMIT 1");
        return !empty($query) ? array_shift($query) : false;
    }
    

    public static function check_if_emailaddress_exists($emailadd = "") {
        $emsh = sha1($emailadd);
        $emcr = crypt($emsh, "em");
        $emcr1 = substr($emcr, 2);
        global $database;
        $query = self::find_by_sql("SELECT * FROM " . self::$tablename . " where emailadd = '" . $database->escape_value($emcr1) . "' LIMIT 1");
        return !empty($query) ? true : false;
    }
    
    public static function authenticate_password($userid = "", $password = "") {
        global $database;
        $shpw = sha1($password);
        $cpw = crypt($shpw, "us");
        $cpw1 = substr($cpw, 2);
        $sql = "select * from " . self::$tablename . " WHERE userid= '" . $database->escape_value($userid) . "' AND password = '" . $database->escape_value($cpw1) . "' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function count_record_by_sql($sql) {
        global $database;
        $query_result = $database->query($sql);
        $fetched_row = mysqli_fetch_row($query_result);
        return !empty($fetched_row) ? array_shift($fetched_row) : FALSE;
    }

    public static function find_by_sql($sql = "") {
        global $database;
        $query = $database->query($sql);
        $query_in_array_form = array();
        while ($row = mysqli_fetch_array($query)) {
            $query_in_array_form[] = self::instantiate($row);
        }
        return $query_in_array_form; //even if there is only one record, we have to use foreach to display the record.
    }
    
    public static function find_latest_status($userid = 0) {
        global $database;
        $sql = "select * from " . self::$tablename . " WHERE userid = '" . $database->escape_value($userid) . "' ORDER BY userid DESC LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    private static function instantiate($record) {
        $object = new self;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    private function has_attribute($attribute) {
        $object_vars = get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }

    public static function authenticate($emailadd = "", $password = "") {
        global $database;
        $shpw = sha1($password);
        $cpw = crypt($shpw, "us");
        $cpw1 = substr($cpw, 2);
        $sql = "select * from " . self::$tablename . " WHERE emailadd= '" . $database->escape_value($emailadd) . "' AND password = '" . $database->escape_value($cpw1) . "' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function create() {
        global $database;
        $attributes = $this->sanitized_attribute();
        $sql = "INSERT INTO " . self::$tablename . " (" . join(", ", array_keys($attributes)) . ") VALUES ('" . join("', '", array_values($attributes)) . "')";
        return ($database->query($sql)) ? TRUE : FALSE;
    }

    public function insert_id() {
        global $database;
        return $database->insert_id();
    }

    public function update() {
        global $database;
        $attributes = $this->sanitized_attribute();
        $attribute_pairs = array();
        foreach ($attributes as $keys => $values) {
            $attribute_pairs[] = "{$keys}='{$values}'";
        }
        $sql = "UPDATE " . self::$tablename . " SET " . join(",", $attribute_pairs) . " WHERE userid='" . $database->escape_value($this->userid) . "';";
        if ($database->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete() {
        global $database;
        $sql = "DELETE FROM " . self::$tablename . " WHERE userid='" . $database->escape_value($this->userid) . "' LIMIT 1";
        return $database->query($sql) ? TRUE : FALSE;
    }

    protected function sanitized_attribute() {
        global $database;

        $clean_attributes = array();
        foreach ($this->attributes()as $key => $value) {
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function attributes() {
        $attributes = array();
        foreach (self::$db_fields as $field) {
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }
    
}
