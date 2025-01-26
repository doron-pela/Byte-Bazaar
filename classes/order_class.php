<?php
require_once("../settings/db_class.php");

class order_class extends db_connection {
    // Create an order and return the inserted order_id
    public function createOrder($customer_id, $order_date, $order_status) {
        $customer_id = (int)$customer_id;
        $order_date = mysqli_real_escape_string($this->db_conn(), $order_date);
        $order_status = mysqli_real_escape_string($this->db_conn(), $order_status);

        $sql = "INSERT INTO orders (customer_id, order_date, order_status) 
                VALUES ('$customer_id', '$order_date', '$order_status')";

        if ($this->db_query($sql)) {
            $last_id = mysqli_insert_id($this->db_conn());
            if ($last_id) {
                return $last_id; // Return the inserted order_id
            } else {
                error_log("Failed to retrieve last inserted ID for orders.");
                return false;
            }
        } else {
            error_log("Failed to execute query for orders: " . mysqli_error($this->db_conn()));
            return false;
        }
    }

    // Fetch the last inserted order_id for a customer
    public function getLastOrderId($customer_id) {
        $customer_id = (int)$customer_id;
        $sql = "SELECT order_id FROM orders WHERE customer_id = '$customer_id' ORDER BY order_date DESC LIMIT 1";

        $result = $this->db_fetch_one($sql);
        if ($result) {
            return $result['order_id']; // Return the last order_id
        } else {
            error_log("No orders found for Customer ID: $customer_id.");
            return false;
        }
    }

    // Add order details to the orderdetails table
    public function addOrderDetails($order_id, $product_id, $quantity) {
        $order_id = (int)$order_id;
        $product_id = mysqli_real_escape_string($this->db_conn(), $product_id);
        $quantity = mysqli_real_escape_string($this->db_conn(), $quantity);

        $sql = "INSERT INTO orderdetails (order_id, product_id, qty) 
                VALUES ('$order_id', '$product_id', '$quantity')";
        if ($this->db_query($sql)) {
            return true;
        } else {
            error_log("Failed to add order details for Order ID: $order_id, Product ID: $product_id.");
            return false;
        }
    }

    // Retrieve cart items for a customer
    public function getCartItems($customer_id) {
        $customer_id = (int)$customer_id;

        $sql = "SELECT * FROM cart WHERE c_id = '$customer_id'";
        return $this->db_fetch_all($sql);
    }

    // Clear cart after order processing
    public function clearCart($customer_id) {
        $customer_id = (int)$customer_id;

        $sql = "DELETE FROM cart WHERE c_id = '$customer_id'";
        if ($this->db_query($sql)) {
            return true;
        } else {
            error_log("Failed to clear cart for Customer ID: $customer_id.");
            return false;
        }
    }

    // Fetch projects associated with an order
    public function getOrderProjects($order_id) {
        $order_id = (int)$order_id;
        $sql = "SELECT p.*, p.project_price
                FROM orderdetails od
                JOIN projects p ON od.product_id = p.project_id
                WHERE od.order_id = '$order_id'";
        return $this->db_fetch_all($sql);
    }
}
?>
