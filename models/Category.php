<?php

    class Category {
        //DB stuff
        private $conn;
        private $table = 'categories';

        //Properties
        public $id;
        public $name;
        public $created_at;

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        //get categories
        public function read() {
            //create query
            $query = 'SELECT
                id,
                name,
                created_at
            FROM
                ' . $this->table . '
            ORDER BY
                created_at DESC';

            //prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;

        }

        //Get single Post
        public function read_single() {
            //create query
            $query = 'SELECT
                id,
                name,
                created_at
            FROM
                ' . $this->table . '
            WHERE
                id = ?
            LIMIT 0,1';
            
            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind ID
            $stmt->bindParam(1,$this->id);

            //Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->name = $row['name'];


        }

        //Create Post
        public function create() {
            //Create query
            $query = 'INSERT INTO ' . 
                $this->table . '
                SET
                    name = :name';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->name = htmlspecialchars(strip_tags($this->name));


            //bind the data
            $stmt ->bindParam(':name',$this->name);

            //execute query
            if ($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Update Post
        public function update() {
            //Create query
            $query = 'UPDATE ' . 
                $this->table . '
                SET
                    name = :name
                WHERE
                    id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt ->bindParam(':name',$this->name);
            $stmt ->bindParam(':id',$this->id);

            //execute query
            if ($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;
        }

        //Delete Post
        public function delete() {
            //Create Query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            //bind the data
            $stmt ->bindParam(':id',$this->id);

            //execute query
            if ($stmt->execute()){
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);
            return false;

        }

    }