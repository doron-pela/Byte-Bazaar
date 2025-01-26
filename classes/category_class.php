<?php
//connect to database class
require_once("../settings/db_class.php");

class category_class extends db_connection
{
	public function addCategory($cat_name)
    {
        $ndb = new db_connection();
        
        // Escape and sanitize input data
        $cat_name = mysqli_real_escape_string($ndb->db_conn(), $cat_name);
        
        
        $sql = "INSERT INTO `categories`(`cat_name`) VALUES ('$cat_name')";
        return $this->db_query($sql);
	}

    // Function to delete a brand by its ID
    public function deleteCategory($cat_name) 
    {
        $ndb = new db_connection();
        $cat_name = mysqli_real_escape_string($ndb->db_conn(), $cat_name);
        
        $sql = "DELETE FROM `categories` WHERE `cat_name` = '$cat_name'";
        return $this->db_query($sql);
    }

    // Function to retrieve all cats
    public function viewCategories()
    {
        $sql = "SELECT * FROM `categories`";
        return $this->db_fetch_all($sql);  // Fetch all records
    }

}