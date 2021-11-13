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
        $storeDataQuery = "INSERT INTO sheet_" . $data['sheet'];
        $storeRowArray = [];

        foreach ($data['data'] as $key=>$value){
            foreach ($value as $k => $v) {
                if($key !== sizeof($value) - 1 ) {
                    $storeDataQuery .= " (col_" . ($k + 1) . ", ";
                }else {
                    $storeDataQuery .= "col_". ($k + 1) .") VALUES (";
                }

                foreach ($value as $k => $v) {
                    if($key !== sizeof($value) - 1 ) {
                        $storeDataQuery .= "? , ";
                    }else{
                        $storeDataQuery .= "? )";
                    }
                }
            }

        }
//
//        foreach ($data['data'] as $key=>$value){
//            if($key !== sizeof($data['data']) - 1 ) {
//                $storeDataQuery .= $value . ", ";
//            }else{
//                $storeDataQuery .= "";
//            }
//        }

        $sql = $this->db->prepare("INSERT INTO sheet_". $data['sheet'] ." (id, type, colour) VALUES (:id, :name, :color)");
        $sql->execute(array('id' => $newId, 'name' => $name, 'color' => $color));
    }

}