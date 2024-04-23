
<?php
define('QUERY_INSTANCE', 'conn,data,sql,insertId,success,error,count');

class Query //Query Builder : Query
{
    private $conn; //connection Object

    private $data = []; //data;
    private $sql; //SQL
    private $insertId = 0; //Insert --->new ID  

    private $success = [];
    private $error = [];
    private $count = 0;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;

    }

    //Create The Query Method
    public function create($sql = "") //$query->create()->commit()
    {
        if (empty($sql)) {
            exit('SQL Query is Required');
        } else {
            $this->sql = $sql;
        }
        return $this;
    }

    //Create The Make Method
    public static function make($sql = "")
    {
        $query = new self(); // Instantiate the class
        return $query->create($sql); // Call the create method on the newly created object
    }

    public function getQuery()
    {
        return $this->sql;
    }

    //Insert Query.
    public function insert($tablename = '', $data = [])
    {
        $formData = [];
        $sql = "";
        if (empty($tablename)) {
            exit('Tablename cannot be blank');
        }

        if (count($data) == 0) {
            foreach ($this as $key => $value) {
                if (!in_array($key, explode(',', QUERY_INSTANCE))) {
                    $formData[$key] = $value;
                }
            }
        }

        if (count($data) > 0) {
            $formData = $data;
        }
        $columns_arr = array_keys($formData);
        $columns = implode(',', $columns_arr);

        $values_arr = array_values($formData);
        $values = implode("','", $values_arr);
        $sql = $sql . " INSERT INTO {$tablename}({$columns}) values('{$values}')";
        $this->sql = trim($sql);

        return $this;
    }

    //update Query
    public function update($tablename = '', $data = [])
    {
        $formData = [];
        $sql = "";
        if (empty($tablename)) {
            exit('Tablename cannot be blank');
        }

        if (count($data) == 0) {
            foreach ($this as $key => $value) {
                if (!in_array($key, explode(',', QUERY_INSTANCE))) {
                    $formData[$key] = $value;
                }
            }
        }
        if (count($data) > 0) {
            $formData = $data;
        }
        $column_value_str = "";
        foreach ($formData as $column => $value) {
            $column_value_str = $column_value_str . "{$column}='{$value}',";
        }
        $sql = $sql . " UPDATE {$tablename} SET " . $column_value_str;
        $sql = substr($sql, 0, -1);
        $this->sql = trim($sql);

        return $this;
    }

    public function delete($tablename = '', $Ids = [])
    {
        $sql = "";
        $where = "WHERE";
        if (empty($tablename)) {
            exit('Table Name Cannot Be Blank');
        }
        if (count($Ids) == 0) {
            exit('Min 1 ID Is Mendatory For Deleting The Record');
        }
        if (count($Ids) > 0) {
            if (count($Ids) == 1) {
                $column_arr = array_keys($Ids);
                $column = $column_arr[0];
                $value_arr = array_values($Ids);
                $valueArr = $value_arr[0];
                if (is_array($valueArr)) {
                    $value = implode("','", $valueArr);
                    $value = "IN ('{$value}')";
                    //$value = $value . " IN ({$value})";
                } else if (is_string($valueArr) or is_numeric($valueArr)) {
                    $value = $value_arr[0];
                    $value = explode(',', $value);
                    $value = implode("','", $value);
                    $value = "IN ('{$value}')";
                }
                $column_str = "{$column} {$value}";
                $sql = $sql . "DELETE FROM {$tablename} " . $where . " " . $column_str;

                $this->sql = $sql;
                return $this;

            } else {

                $columns_value_str = "";
                foreach ($Ids as $column => $value) {
                    $columns_value_str = $columns_value_str . "{$column}='{$value}' AND ";
                }

                $sql = $sql . "DELETE FROM {$tablename} " . $where . " " . $columns_value_str;
                $sql = trim($sql);
                $sql = substr($sql, 0, -3);
                $sql = trim($sql);

                $this->sql = $sql;
                return $this;

            }


        }


    }

    //commit method : execute
    public function commit()
    {
        try {
            if (mysqli_query($this->getConnection(), $this->getQuery())) {
                if (preg_match("/insert/i", $this->getQuery())) {
                    $this->insertId = mysqli_insert_id($this->getConnection());

                    if ($this->insertId > 0) {
                        $this->success = 'Record Inserted';
                        return true;
                    } else {
                        $this->error = 'Oops Something went Wrong';
                        return false;
                    }

                } else if (preg_match("/update/i", $this->getQuery())) {
                    $effected_rows = mysqli_affected_rows($this->getConnection());
                    if ($effected_rows > 0) {
                        $this->success = 'Record Updated';
                        return true;
                    } else {
                        $this->error = 'Oops Something went Wrong';
                        return false;
                    }
                } else if (preg_match("/delete/i", $this->getQuery())) {
                    $effected_rows = mysqli_affected_rows($this->getConnection());
                    if ($effected_rows > 0) {
                        $this->success = 'Record Deleted';
                        return true;
                    } else {
                        $this->error = 'Oops Something went Wrong';
                        return false;
                    }

                } else if (preg_match("/select/i", $this->getQuery())) {

                    $data = [];
                    $resultSet = mysqli_query($this->getConnection(), $this->getQuery());
                    $row_count = mysqli_num_rows($resultSet);
                    if ($row_count > 0) {
                        while ($row = mysqli_fetch_assoc($resultSet)) {
                            $data[] = $row;
                        }
                        $this->data = $data;
                        $this->success = $row_count . ' Records Found';
                    } else {
                        $data = [];
                        $this->data = $data;
                        $this->error = 'No Record Found';
                    }

                    return $this;
                }



            } else {
                throw new mysqli_sql_exception();
            }
        } catch (mysqli_sql_exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    //To get success Message
    public function getSuccessMessage()
    {
        return json_encode($this->success);
    }
    //To get Error Message
    public function getErrorMessage()
    {
        return json_encode($this->error);
    }

    //to get new Inserted ID:-
    public function getInsertedID()
    {
        return $this->insertId;
    }


    //where method
    public function where($column = '', $operator = '', $value = '', $AndOR = '')
    {
        $sql = "";
        if ($this->count == 0) {
            $where = "WHERE";
        } else {
            $where = "";
        }
        $this->count++;
        $this->where = $where;
        $this->sql = $this->sql . trim($sql) . " {$where} {$column}{$operator}'{$value}' {$AndOR}";
        $this->sql = trim($this->sql);
        return $this;
    }

    //Select Query
    public function select($tablename = '', $columns = '')
    {
        if (empty($tablename)) {
            exit('Tablename Is Required');
        }
        $column = '';
        $sql = 'SELECT';
        if (empty($columns)) {
            $column = '*';
        }
        if (!empty($columns) and is_array($columns)) {
            $column = implode(',', $columns);
        }
        if (!empty($columns) and is_string($columns)) {
            $column = $columns;
        }
        $sql = $sql . " {$column} FROM {$tablename}";
        $this->sql = $sql;
        return $this;
    }


    //To select Single Record
    public function getRow()
    {
        if (count($this->data) == 1) {
            return $this->data[0];
        } else {
            return [];
        }

    }
    //To Select All Records
    public function getAllRecords()
    {
        if (count($this->data) > 0) {
            return $this->data;
        } else {
            return [];
        }
    }

    //To get connection
    private function getConnection()
    {
        return $this->conn;
    }


}