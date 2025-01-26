<?php
//connect to database class
require_once("../settings/db_class.php");

class user_class extends db_connection
{

    

	public function registerCustomer($customer_name, $email, $password, $country, $city, $contact_no, $user_role)
    {
        $ndb = new db_connection();
        
        // Escape and sanitize input data
        $customer_name = mysqli_real_escape_string($ndb->db_conn(), $customer_name);
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $country = mysqli_real_escape_string($ndb->db_conn(), $country);
		$city = mysqli_real_escape_string($ndb->db_conn(), $city);
        $contact_no = mysqli_real_escape_string($ndb->db_conn(), $contact_no);
        $user_role = mysqli_real_escape_string($ndb->db_conn(), $user_role);

        $sql = "INSERT INTO `customer`(`customer_name`, `customer_email`, `customer_pass`, `customer_country`, `customer_city`, `customer_contact`, `bb_role`) 
        VALUES ('$customer_name', '$email', '$password', '$country', '$city', '$contact_no', '$user_role')";
        return $this->db_query($sql);

        
	}

    public function registerSeller($seller_name, $email, $password, $country, $city, $contact_no, $user_role)
    {
        $ndb = new db_connection();
        
        // Escape and sanitize input data
        $seller_name = mysqli_real_escape_string($ndb->db_conn(), $seller_name);
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $country = mysqli_real_escape_string($ndb->db_conn(), $country);
		$city = mysqli_real_escape_string($ndb->db_conn(), $city);
        $contact_no = mysqli_real_escape_string($ndb->db_conn(), $contact_no);
        $user_role = mysqli_real_escape_string($ndb->db_conn(), $user_role);

        $sql = "INSERT INTO `seller`(`seller_name`, `seller_email`, `seller_pass`, `seller_country`, `seller_city`, `seller_contact`, `bb_role`) 
        VALUES ('$seller_name', '$email', '$password', '$country', '$city', '$contact_no', '$user_role')";
        return $this->db_query($sql);
	}
	
    public function loginCustomer($email, $password)
    {
        $ndb = new db_connection();
        
        
        // Escape and sanitize input data
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $password = mysqli_real_escape_string($ndb->db_conn(), $password);
        
        // Retrieve user from database based on email
        $sql = "SELECT * FROM `customer` WHERE `customer_email` = '$email'";
        $result = $this->db_fetch_one($sql);


        // Check for SQL query execution errors
        if (!$result) {
            // Handle query execution error
            echo "Error: " . mysqli_error($ndb->db_conn());
            return false;
        }
        
        // Check if user exists
        if ($result != null){

            echo "There is a record in db";
            // $user = mysqli_fetch_assoc($result);
            $customer = $result;
            // Verify password
            if (password_verify($password, $customer['customer_pass'])) {
                // Password is correct, return user data
                return $customer;
            } else {
                echo "password is wrong";
                // Password is incorrect
                return false;
            }
        } else {
            echo "Not Found";
            return false;
        }
    }

    public function loginSeller($email, $password)
    {
        $ndb = new db_connection();
        
        // Escape and sanitize input data
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $password = mysqli_real_escape_string($ndb->db_conn(), $password);
        
        // Retrieve user from database based on email
        $sql = "SELECT * FROM `seller` WHERE `seller_email` = '$email'";
        $result = $this->db_fetch_one($sql);

        // Check for SQL query execution errors
        if (!$result) {
            // Handle query execution error
            echo "Error: " . mysqli_error($ndb->db_conn());
            return false;
        }
        
        // Check if user exists
        if ($result != null){

            echo "There is a record in db";
            // $user = mysqli_fetch_assoc($result);
            $seller = $result;
            // Verify password
            if (password_verify($password, $seller['seller_pass'])) {
                // Password is correct, return user data
                return $seller;
            } else {
                echo "password is wrong";
                // Password is incorrect
                return false;
            }
        } else {
            echo "Not Found";
            return false;
        }
    
    }

    public function loginAdmin($email, $password)
    {
        $ndb = new db_connection();
        
        // Escape and sanitize input data
        $email = mysqli_real_escape_string($ndb->db_conn(), $email);
        $password = mysqli_real_escape_string($ndb->db_conn(), $password);
        
        // Retrieve user from database based on email
        $sql = "SELECT * FROM `admin` WHERE `admin_email` = '$email'";
        $result = $this->db_fetch_one($sql);

        // Check for SQL query execution errors
        if (!$result) {
            // Handle query execution error
            echo "Error: " . mysqli_error($ndb->db_conn());
            return false;
        }
        
        // Check if user exists
        if ($result != null){

            echo "There is a record in db";
            // $user = mysqli_fetch_assoc($result);
            $admin = $result;
            // Verify password
            if (password_verify($password, $admin['admin_pass'])) {
                // Password is correct, return user data
                return $admin;
            } else {
                echo "password is wrong";
                // Password is incorrect
                return false;
            }
        } else {
            echo "Not Found";
            return false;
        }
    
    }

    public function updateSellerProfile($seller_id, $seller_name = null, $country = null, $city = null, $contact_no = null, $profile_picture = null, $password = null) {
        $fields = [];
    
        if ($seller_name) {
            $fields[] = "seller_name = '" . mysqli_real_escape_string($this->db_conn(), $seller_name) . "'";
        }
        if ($country) {
            $fields[] = "seller_country = '" . mysqli_real_escape_string($this->db_conn(), $country) . "'";
        }
        if ($city) {
            $fields[] = "seller_city = '" . mysqli_real_escape_string($this->db_conn(), $city) . "'";
        }
        if ($contact_no) {
            $fields[] = "seller_contact = '" . mysqli_real_escape_string($this->db_conn(), $contact_no) . "'";
        }
        if ($profile_picture) {
            $fields[] = "seller_image = '" . mysqli_real_escape_string($this->db_conn(), $profile_picture) . "'";
        }
        if ($password) {
            $fields[] = "seller_pass = '$password'";
        }
    
        if (empty($fields)) {
            return false;
        }
    
        $sql = "UPDATE seller SET " . implode(', ', $fields) . " WHERE seller_id = '$seller_id'";
        return $this->db_query($sql);
    }
    
    
    public function updateCustomerProfile($customer_id, $customer_name, $email, $country, $city, $contact_no) {
        $customer_id = (int)$customer_id;
        $customer_name = mysqli_real_escape_string($this->db_conn(), $customer_name);
        $email = mysqli_real_escape_string($this->db_conn(), $email);
        $country = mysqli_real_escape_string($this->db_conn(), $country);
        $city = mysqli_real_escape_string($this->db_conn(), $city);
        $contact_no = mysqli_real_escape_string($this->db_conn(), $contact_no);
    
        $sql = "UPDATE customer 
                SET customer_name = '$customer_name', 
                    customer_email = '$email', 
                    customer_country = '$country', 
                    customer_city = '$city', 
                    customer_contact = '$contact_no' 
                WHERE customer_id = '$customer_id'";
        return $this->db_query($sql);
    }
    
    public function deleteCustomer($customer_id) {
        $sql = "DELETE FROM customer WHERE customer_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        return $stmt->execute();
    }
    
    public function deleteSeller($seller_id) {
        $sql = "DELETE FROM seller WHERE seller_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("i", $seller_id);
        return $stmt->execute();
    }

    public function fetchAllCustomers() {
        $sql = "SELECT * FROM customer";
        return $this->db_fetch_all($sql);
    }
    
    public function fetchAllSellers() {
        $sql = "SELECT * FROM seller";
        return $this->db_fetch_all($sql);
    }

    public function fetchSellerDetails($seller_id) {
        $seller_id = (int)$seller_id; // Ensure $seller_id is an integer to prevent SQL injection
        $sql = "SELECT * FROM seller WHERE seller_id = '$seller_id'";
        return $this->db_fetch_one($sql);
    }
    
    public function fetchCustomerDetails($customer_id) {
        $customer_id = (int)$customer_id; // Ensure $seller_id is an integer to prevent SQL injection
        $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id'";
        return $this->db_fetch_one($sql);
    }
}

?>


    