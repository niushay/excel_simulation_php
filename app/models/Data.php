<?php
class Data {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createTable($data)
    {
        //drop table if exists then create new table
        $createTableQuery = "DROP TABLE IF EXISTS sheet_" . $data['sheet'] . "; Create TABLE sheet_". $data['sheet'] ." (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";

        //Create table query
        foreach ($data['data'][0] as $key=>$value){
            $createTableQuery .= "col_" . ($key + 1) . " VARCHAR(255) NOT NULL";

            if($key !== sizeof($data['data'][0]) - 1 ){
                $createTableQuery .= ",";
            }else{
                $createTableQuery .= ");";
            }
        }

        $this->db->query($createTableQuery);
        $this->db->execute();

        return true;
    }

    public function storeData($data)
    {
        $storeDataQuery = "INSERT INTO sheet_" . $data['sheet'] . " (";

        foreach ($data['data'][0] as $key=>$value){
            if($key !== sizeof($data['data'][0]) - 1) {
                $storeDataQuery .= "col_" . ($key + 1) . ", ";
            }else {
                $storeDataQuery .= "col_". ($key + 1) .") VALUES (";
            }
        }

        foreach ($data['data'][0] as $key=>$value) {
            if ($key !== sizeof($data['data'][0]) - 1) {
                $storeDataQuery .= "? , ";
            } else {
                $storeDataQuery .= "? );";
            }
        }

        $this->db->query($storeDataQuery);

        foreach ($data['data'] as $key=>$value){
            foreach ($data['data'][$key] as $k => $v){
                $this -> db -> bind($k+1, $v);
            }
            $this -> db -> execute();
        }

        return true;
    }

    public function fetchAll($sheetNumber)
    {
        //Check if table exists
        $table = 'sheet_' . $sheetNumber;
        try {
            $this->db->query("SELECT 1 FROM {$table} LIMIT 1");
            $result = $this->db->execute();
        } catch (Exception $e) {
            return false;
        }

        //Get table data
        if($result){
            $stmt = "SELECT * FROM {$table}";
            $this -> db -> query($stmt);
            $data = $this -> db -> resultSet();
        }
        return $data;
    }

}