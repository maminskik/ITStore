<?php

require_once './libs/Database.php';

class Product {
    private $db;

    public function __construct(){
        $this->db= new Database;
    }

    public function addProduct($name, $image, $price, $desc, $catid){

        $this->db->query('INSERT INTO products (Name, Image, Price, Description, CategoryId)
        VALUES (:name, :image, :price, :desc, :categoryid)');

        $this->db->bind(':name', $name);
        $this->db->bind(':image', $image);
        $this->db->bind(':price', $price);
        $this->db->bind(':desc', $desc);
        $this->db->bind(':categoryid', $catid);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function editProduct($name, $price, $desc, $catid, $productId){

        $this->db->query('UPDATE products SET Name = :name, Price = :price, Description = :desc, CategoryId = :categoryid WHERE ProductId = :productid');
    
        $this->db->bind(':productid', $productId);
        $this->db->bind(':name', $name);
        $this->db->bind(':price', $price);
        $this->db->bind(':desc', $desc);
        $this->db->bind(':categoryid', $catid);
        
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function countProducts()
    {
        $this->db->query('SELECT COUNT(*) AS total_products FROM products');
        $row = $this->db->single();
        return $row;
    }

    public function editProductImage($image, $productId){

        $this->db->query('UPDATE products SET Image = :image WHERE ProductId = :productid');
    
        $this->db->bind(':productid', $productId);
        $this->db->bind(':image', $image);
    
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function getProductByCategory($categoryId){
        $this->db->query("SELECT * FROM products WHERE CategoryId = :categoryId");
        $this->db->bind(':categoryId', $categoryId);
        $products = $this->db->resultSet();
        return $products;

   }

   public function getAllProducts(){
        $this->db->query("SELECT * FROM products");
        $products = $this->db->resultSet();
        return $products;
    }

    public function getProductById($productId)
    {
        $this->db->query('SELECT * FROM products WHERE ProductId = :productId');
        $this->db->bind(':productId', $productId);
        $product = $this->db->single();

        return $product;
    }

    public function deleteProduct($productId){
        $this->db->query("DELETE FROM products WHERE ProductId = :productId");
        $this->db->bind(':productId', $productId);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    

    
}



