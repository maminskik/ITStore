<?php

require_once './libs/Database.php';

class Orders
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllOrders()
    {

        $this->db->query("SELECT * FROM orders");
        $orders = $this->db->resultSet();
        if ($orders) {
            return $orders;
        } else {
            return false;
        }
    }

    public function getAllOrdersById($id)
    {

        $this->db->query("SELECT * FROM orders_details WHERE OrderId = :orderid");
        $this->db->bind(':orderid', $id);
        $orders = $this->db->resultSet();
        return $orders;
    }



    public function countOrders()
    {
        $this->db->query('SELECT COUNT(*) AS total_orders FROM orders');
        $row = $this->db->single();
        return $row;
    }

    public function createOrder($orderData)
    {
        $this->db->query('INSERT INTO orders (Date_Invoice, Value, UserId) VALUES (:date_invoice, :value, :user_id)');
        $this->db->bind(':date_invoice', $orderData['Date_Invoice']);
        $this->db->bind(':value', $orderData['Value']);
        $this->db->bind(':user_id', $orderData['UserId']);

        return $this->db->lastInsertId();
    }

    public function createOrderDetail($orderId, $productid, $amount, $unitPrice)
    {
        $this->db->query("INSERT INTO orders_details (OrderId, ProductId, Amount, Unit_price)
            VALUES (:orderId, :productId, :amount, :unitPrice)");

        $this->db->bind(':orderId', $orderId);
        $this->db->bind(':productId', $productid);
        $this->db->bind(':amount', $amount);
        $this->db->bind(':unitPrice', $unitPrice);

        $this->db->execute();
    }
}