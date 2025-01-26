<?php
//connect to database class
require("../settings/db_class.php");

class brand_class extends db_connection
{
	public function addBrand($brand_name)
    {
        $ndb = new db_connection();
        
        // Escape and sanitize input data
        $brand_name = mysqli_real_escape_string($ndb->db_conn(), $brand_name);
        

        
        $sql = "INSERT INTO `brands`(`brand_name`) VALUES ('$brand_name')";
        return $this->db_query($sql);
	}

    // Function to delete a brand by its ID
    public function deleteBrand($brand_name)
    {
        $ndb = new db_connection();
        $brand_name = mysqli_real_escape_string($ndb->db_conn(), $brand_name);
        
        $sql = "DELETE FROM `brands` WHERE `brand_name` = '$brand_name'";
        return $this->db_query($sql);
    }

    // Function to retrieve all brands
    public function viewBrands()
    {
        $sql = "SELECT * FROM `brands`";
        return $this->db_fetch_all($sql);  // Fetch all records
    }

}