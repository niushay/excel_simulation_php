<?php
    class Pages extends Controller {
        private $dataModel;

        public function __construct()
        {
            $this -> dataModel = $this -> model('Data');
        }

        public function index($sheetNumber = 1)
        {
            $data = $this -> dataModel -> fetchAll($sheetNumber);

            if ($data == false){
                $data = [
                    'items' => [
                        ['Text', 'Text', 'Text'],
                        ['Text', 'Text', 'Text'],
                        ['Text', 'Text', 'Text']
                    ],
                    'numberOfCols' => 4
                ];
            }else{
                $data = [
                    'items' => $data,
                    'numberOfCols' => count((array)$data[0])
                ];
            }

            $this -> view('pages/index', $data);
        }

        public function store()
        {
            //Get Data
           $data = $_POST;

            //Create Table
            $this -> dataModel -> createTable($data);

            //Insert data into the table
            $this -> dataModel -> storeData($data);

            return [
                'status' => true,
                'message' => 'Data have been inserted successfully'
            ];
        }
    }