<?php
//connect to the user account class
include_once("../classes/brand_class.php");



function addBrand($brand_name){
	$addBrand=new brand_class();
	$result = $addBrand->addBrand($brand_name);
}

// Function to delete a brand by ID
function deleteBrand($brand_name) {
    $deleteBrand = new brand_class();
    return $deleteBrand->deleteBrand($brand_name);
}

// Function to view all brands
function viewBrands() {
    $viewBrands = new brand_class();
    return $viewBrands->viewBrands();
}