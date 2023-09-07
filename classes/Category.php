<?php

require_once './libs/Database.php';

class Category {
    private $db;

    public function __construct(){
        $this->db= new Database;
    }

    public function getAllCategories(){
           
        $this->db->query("SELECT * FROM category");
        $categories = $this->db->resultSet();
        if($categories){
            return $categories;
        }else {
            return false;
        }
    }

    public function checkCategoryExists($categoryName) {
        
        $categoryName = strtolower($categoryName);

        $this->db->query("SELECT COUNT(*) as count FROM category WHERE LOWER(Name) = :name");
        $this->db->bind(':name', $categoryName);
        $categories = $this->db->resultSet();

        return $categories['count'] > 0;
    }

    public function addCategory($name){

        $this->db->query('INSERT INTO category (Name) VALUES (:name)');

        $this->db->bind(':name', $name);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
   

    

    
}

