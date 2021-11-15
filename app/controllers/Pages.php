<?php
    class Pages extends Controller {
        private $dataModel;

        public function __construct()
        {
            $this -> dataModel = $this -> model('Data');
        }

        public function index($sheetNumber = 1)
        {
            //Get data of selected sheet
            $data = $this -> dataModel -> fetchAll($sheetNumber);

            if ($data == false){
                $data = [
                    'items' => [
                        [1,'Text', 'Text', 'Text'],
                        [2,'Text', 'Text', 'Text'],
                        [3,'Text', 'Text', 'Text']
                    ],
                    'numberOfCols' => 4,
                    'sheetNumber' => $sheetNumber
                ];
            }else{
                $data = [
                    'items' => $data,
                    'numberOfCols' => count((array)$data[0]),
                    'sheetNumber' => $sheetNumber
                ];
            }

            //create sheet table
            $this->createSheet(1);

            //get Number of sheets
            $data['sheets'] = $this->dataModel->getNumberOfSheets();

            //create sheet table
//            $this->createSheet(1);

            $this -> view('pages/index', $data);
        }

        public function store()
        {
            //Get Data
           $data = $_POST;

            //Create data Table
            $this -> dataModel -> createTable($data);

            //Create sheet Table
            $this->createSheet($_POST['sheet']);

            //Insert data into the table
            $this -> dataModel -> storeData($data);

            return [
                'status' => true,
                'message' => 'Data have been inserted successfully'
            ];
        }

        public function createSheet($data = null)
        {
            if($data == null)
                $data = $_POST['sheet'];

            $this -> dataModel -> createSheetTable($data);
            $this -> dataModel -> storeCreatedSheets($data);
        }
    }