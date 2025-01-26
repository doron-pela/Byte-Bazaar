<?php
//connect to database class
require_once("../settings/db_class.php");

class cart_class extends db_connection
{
    // Function to add items to the cart
    public function addToCart($product_id, $ip_address, $customer_id, $quantity)
    {
        $ndb = new db_connection();

        // Escape and sanitize input data
        $product_id = mysqli_real_escape_string($ndb->db_conn(), $product_id);
        $ip_address = mysqli_real_escape_string($ndb->db_conn(), $ip_address);
        $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
        $quantity = mysqli_real_escape_string($ndb->db_conn(), $quantity);
        $quantity = (int)1;
        $product_id = (int)$product_id;

        // Check if the product already exists in the cart for the same customer or IP address
        $sql = "SELECT * FROM `cart` WHERE `c_id` = '$customer_id' AND `ip_add` = '$ip_address' AND `p_id` = '$product_id'";
        $result = $this->db_fetch_one($sql); // Fetching the result

        if (empty($result)) {
            // If product is not in the cart, insert it
            $sql = "INSERT INTO `cart` (`c_id`, `ip_add`, `p_id`, `qty`) 
                    VALUES ('$customer_id', '$ip_address', '$product_id', '$quantity')";
            return $this->db_query($sql);
        } else {
            // If product already exists, update the quantity
            $sql = "UPDATE `cart` SET `qty` = `qty` + $quantity 
                    WHERE `c_id` = '$customer_id' AND `ip_add` = '$ip_address' AND `p_id` = '$product_id'";
            return $this->db_query($sql);
        }
    }

     // Remove a product from the cart
     public function removeFromCart($product_id, $customer_id, $ip_address)
     {
         $ndb = new db_connection();
 
         // Escape and sanitize input data
         $product_id = mysqli_real_escape_string($ndb->db_conn(), $product_id);
         $ip_address = mysqli_real_escape_string($ndb->db_conn(), $ip_address);
         $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
 
         // Delete the product from the cart
         $sql = "DELETE FROM `cart` WHERE `p_id` = '$product_id'";
         return $this->db_query($sql);
     }
 
     // View all items in the cart for a specific customer (or guest using IP address)
     public function viewCart()
     {

        $customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null;
        $ip_address = $_SERVER['REMOTE_ADDR'];

        // Escape and sanitize input data
        $customer_id = mysqli_real_escape_string($this->db_conn(), $customer_id);
        $ip_address = mysqli_real_escape_string($this->db_conn(), $ip_address);

         // Fetch all items in the cart for the specified customer or guest using IP address
         $sql = "SELECT projects.*, projects.project_title, projects.project_price, cart.qty, cart.p_id 
         FROM `cart` 
         JOIN `projects` ON cart.p_id = projects.project_id";
         return $this->db_fetch_all($sql);
     }
 

     // Update quantity in cart
    public function updateCartQuantity($p_id, $ip_add, $c_id, $qty) {
        $query = "UPDATE cart SET qty = ? WHERE p_id = ? AND (ip_add = ? OR c_id = ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iisi", $qty, $p_id, $ip_add, $c_id);
        return $stmt->execute();
    }

     /* Update the quantity of a product in the cart
     public function updateCartQuantity($product_id, $customer_id, $ip_address, $new_quantity)
     {
         $ndb = new db_connection();
 
         // Escape and sanitize input data
         $product_id = mysqli_real_escape_string($ndb->db_conn(), $product_id);
         $ip_address = mysqli_real_escape_string($ndb->db_conn(), $ip_address);
         $customer_id = mysqli_real_escape_string($ndb->db_conn(), $customer_id);
         $new_quantity = (int) $new_quantity;
 
         // Update the quantity of the product in the cart
         $sql = "UPDATE `cart` SET `qty` = '$new_quantity' WHERE `c_id` = '$customer_id' AND `ip_add` = '$ip_address' AND `p_id` = '$product_id'";
         return $this->db_query($sql);
     }*/
}
