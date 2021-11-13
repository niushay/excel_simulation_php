<?php
    class Pages extends Controller {
        private $dataModel;

        public function __construct()
        {
            $this -> dataModel = $this -> model('Data');
        }

        public function index()
        {
//            $user = $this -> userModel->getUsers();
            $data = [
                'title' => 'Home Page',
                'name' => 'Dary'
            ];

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