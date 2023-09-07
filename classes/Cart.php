<?php

require_once './libs/Database.php';
include_once './classes/Product.php';


class Cart
{
    public function getItems()
    {

        if (isset($_SESSION['cart_items'])) {
            return $_SESSION['cart_items'];
        } else {
            return [];
        }
    }

    public function updateItemQuantity($productId, $quantity)
    {
        $cartItems = $this->getItems();


        if (isset($cartItems[$productId])) {

            $cartItems[$productId]['quantity'] = $quantity;


            $product = new Product();
            $productData = $product->getProductById($productId);
            if ($productData) {
                $cartItems[$productId]['price'] = $productData->Price * $quantity;
            }
        }

        $this->saveItems($cartItems);
    }

    public function addItem($productId, $quantity = 1)
    {
        $cartItems = $this->getItems();

        if (isset($cartItems[$productId])) {
            $cartItems[$productId]['quantity'] += $quantity;
            $product = new Product();
            $productData = $product->getProductById($productId);
            if ($productData) {
                $cartItems[$productId]['price'] = $productData->Price * $cartItems[$productId]['quantity'];
            }
        } else {
            $product = new Product();
            $productData = $product->getProductById($productId);
            if ($productData) {
                $cartItems[$productId] = [
                    'id' => $productId,
                    'quantity' => $quantity,
                    'price' => $productData->Price
                ];
            }
        }

        $this->saveItems($cartItems);
    }

    public function saveItems($cartItems)
    {
        $_SESSION['cart_items'] = $cartItems;
    }

    public function removeItem($productId)
    {
        $cartItems = $this->getItems();


        if (isset($cartItems[$productId])) {
            unset($cartItems[$productId]);
        }

        $this->saveItems($cartItems);
    }

    public function getTotalPrice()
    {
        $totalPrice = 0;
        $cartItems = $this->getItems();

        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['id'];
            $quantity = $cartItem['quantity'];
            $product = new Product();
            $product = $product->getProductById($productId);

            if ($product) {
                $productPrice = $product->Price;
                $subtotal = $productPrice * $quantity;
                $totalPrice += $subtotal;
            }
        }

        return $totalPrice;
    }

    public function clearCart()
    {
        $_SESSION['cart_items'] = array();
    }
}