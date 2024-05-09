<?php
require "Config.php";
class Crud
{
    private $bus;

    public function __construct($bus)
    {
        $this->bus = $bus;
    }

    public function buslogin($username, $password, $tblname)
    {
        
            if ($tblname == "admin") {
            $q = "SELECT * FROM " . $tblname . " WHERE username='" . $username . "' AND password='" . $password . "'";
            return $this->bus->query($q)->num_rows;
        } else {
            $q = "SELECT * FROM " . $tblname . " WHERE email='" . $username . "' AND password='" . $password . "'";
            return $this->bus->query($q)->num_rows;
        }
        
    }

    public function businsertdata($field, $data, $table)
    {
        $field_values = implode(",", $field);
        $data_values = implode("','", $data);

        $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
        return $this->bus->query($sql);
    }

    

    public function businsertdata_id($field, $data, $table)
    {
        $field_values = implode(",", $field);
        $data_values = implode("','", $data);

        $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
        $result = $this->bus->query($sql);
        return $this->bus->insert_id;
    }

    public function businsertdata_Api($field, $data, $table)
    {
        $field_values = implode(",", $field);
        $data_values = implode("','", $data);

        $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
        return $this->bus->query($sql);
    }

    public function businsertdata_Api_Id($field, $data, $table)
    {
        $field_values = implode(",", $field);
        $data_values = implode("','", $data);

        $sql = "INSERT INTO $table($field_values)VALUES('$data_values')";
        $result = $this->bus->query($sql);
        return $this->bus->insert_id;
    }

    public function busupdateData($field, $table, $where)
    {
        $cols = [];

        foreach ($field as $key => $val) {
            
                // check if value is not null then only add that colunm to array
                $cols[] = "$key = '$val'";
            
        }
        $sql = "UPDATE $table SET " . implode(", ", $cols) . " $where";
        return $this->bus->query($sql);
    }

    

    public function busupdateData_Api($field, $table, $where)
    {
        $cols = [];

        foreach ($field as $key => $val) {
            if ($val != null) {
                // check if value is not null then only add that colunm to array
                $cols[] = "$key = '$val'";
            }
        }
        $sql = "UPDATE $table SET " . implode(", ", $cols) . " $where";
        return $this->bus->query($sql);
    }

    public function busupdateData_single($field, $table, $where)
    {
        $query = "UPDATE $table SET $field";

        $sql = $query . " " . $where;
        return $this->bus->query($sql);
    }

    public function busDeleteData($where, $table)
    {
        $sql = "Delete From $table $where";
        return $this->bus->query($sql);
    }

    public function busDeleteData_Api($where, $table)
    {
        $sql = "Delete From $table $where";
        return $this->bus->query($sql);
    }
}
?>
