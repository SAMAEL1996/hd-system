<?php

require_once 'init.php';

class Job {
    protected static $tablename = "jobs";
    protected static $db_fields = array('id', 'job', 'title', 'description', 'status', 'date_created');
    public $id;
    public $job;
    public $title;
    public $description;
    public $status;
    public $date_created;
    public $statusvalue = array(
        10 => "Hiring",
        20 => "Closed"
    );

    public static function find_all() {
        $query = self::find_by_sql("select * from " . self::$tablename);
        return $query;
    }
    
    public static function find_all_active() {
        $query = self::find_by_sql("select * from " . self::$tablename . " where status = 10");
        return $query;
    }

    public static function find_by_id($id = 0) {
        global $database;
        $query = self::find_by_sql("select * from " . self::$tablename . " where id ='" . $database->escape_value($id) . "' LIMIT 1");
        return !empty($query) ? array_shift($query) : false;
    }
    
    public static function find_by_userid($userid = 0) {
        global $database;
        $query = self::find_by_sql("select * from " . self::$tablename . " where userid ='" . $database->escape_value($userid) . "' LIMIT 1");
        return !empty($query) ? array_shift($query) : false;
    }
    
  
    public static function find_by_job($job = "", $title = "") {
        global $database;
        $query = self::find_by_sql("SELECT * FROM " . self::$tablename . " where job = '" . $database->escape_value($job) . "' AND title = '" . $database->escape_value($title) . "' LIMIT 1");
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
    
    public static function find_latest_status($id = 0) {
        global $database;
        $sql = "select * from " . self::$tablename . " WHERE id = '" . $database->escape_value($id) . "' ORDER BY id DESC LIMIT 1";
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
        $sql = "select * from " . self::$tablename . " WHERE emailadd= '" . $database->escape_value($emailadd) . "' AND password = '" . $database->escape_value($password) . "' LIMIT 1";
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
        $sql = "UPDATE " . self::$tablename . " SET " . join(",", $attribute_pairs) . " WHERE id='" . $database->escape_value($this->id) . "';";
        if ($database->query($sql)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete() {
        global $database;
        $sql = "DELETE FROM " . self::$tablename . " WHERE id='" . $database->escape_value($this->id) . "' LIMIT 1";
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
