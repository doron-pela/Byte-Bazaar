<?php
require_once "../settings/db_class.php";
require_once "../classes/commission_class.php"; // Include the commission class

class Payment extends db_connection
{

    // Insert a new payment and return its ID
    public function insertPayment($amount, $customer_id, $order_id, $currency) {
        $amount = (float)$amount;
        $customer_id = (int)$customer_id;
        $order_id = (int)$order_id;
        $currency = mysqli_real_escape_string($this->db_conn(), $currency);

        $sql = "INSERT INTO payment (amt, customer_id, order_id, currency, payment_date) 
                VALUES ('$amount', '$customer_id', '$order_id', '$currency', NOW())";

        if ($this->db_query($sql)) {
            $payment_id = mysqli_insert_id($this->db_conn());
            return $payment_id;
        } else {
            error_log("Failed to insert payment: " . mysqli_error($this->db_conn()));
            return false;
        }
    }


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

    public function getLastPaymentId($customer_id) {
        $customer_id = (int)$customer_id;
        $sql = "SELECT pay_id FROM payment ORDER BY payment_date DESC LIMIT 1";

        $result = $this->db_fetch_one($sql);
        if ($result) {
            return $result['pay_id']; // Return the last order_id
        } else {
            error_log("No payments found for Customer ID: $customer_id.");
            return false;
        }
    }

    // Get the last payment entry for a given order ID
    public function getPaymentId($order_id) {
        $order_id = (int)$order_id;

        $sql = "SELECT * FROM payment WHERE order_id = '$order_id' ORDER BY payment_date DESC LIMIT 1";

        return $this->db_fetch_one($sql);
    }




    /*public function processPayment($order_id, $amount, $customer_id, $currency)
    {
        $order_id = mysqli_real_escape_string($this->db_conn(), $order_id);
        $amount = mysqli_real_escape_string($this->db_conn(), $amount);
        $customer_id = mysqli_real_escape_string($this->db_conn(), $customer_id);
        $currency = mysqli_real_escape_string($this->db_conn(), $currency);
        $payment_date = date('Y-m-d H:i:s'); 

        // Check if the order_id exists in the orders table
        $checkOrder = "SELECT * FROM orders WHERE order_id = '$order_id'";
        $orderExists = $this->db_query($checkOrder);

        if ($orderExists) {
            // Insert payment details into the `payment` table
            $sql = "INSERT INTO payment (amt, customer_id, order_id, currency, payment_date) 
                    VALUES ('$amount', '$customer_id', '$order_id', '$currency', '$payment_date')";
            $payment_result = $this->db_query($sql);

            if ($payment_result) {
                // Update order status to 'paid'
                $update_sql = "UPDATE orders SET order_status = 'paid' WHERE order_id = '$order_id'";
                $this->db_query($update_sql);

                // Fetch project details for commission processing
                $projectQuery = "SELECT project_id, project_price FROM orders
                                 JOIN orderdetails ON orders.order_id = orderdetails.order_id
                                 JOIN projects ON orderdetails.product_id = projects.project_id
                                 WHERE orders.order_id = '$order_id'";
                $projectDetails = $this->db_fetch_all($projectQuery);

                if ($projectDetails) {
                    $commission = new commission_class();

                    // Process commission and seller credits for each project in the order
                    foreach ($projectDetails as $project) {
                        $project_id = $project['project_id'];
                        $project_price = $project['project_price'];

                        // Calculate and distribute commission and seller credits
                        $payment_id = mysqli_insert_id($this->db_conn());
                        $commission->processPaymentCommission($payment_id, $project_id, $project_price);}
                }

                return true; // Payment processed successfully
            }
        }

        return false; // Payment failed
    }*/
}

?>
