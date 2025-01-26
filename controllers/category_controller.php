<?php
//connect to the user account class
include_once("../classes/category_class.php");


function addCategory($cat_name){
	$addCategory=new category_class();
	$result = $addCategory->addCategory($cat_name);
}

// Function to delete a category by ID
function deleteCategory($cat_name) {
    $deleteCategory = new category_class();
    return $deleteCategory->deleteCategory($cat_name);
}

// Function to view all categorys
function viewAllCategories() {
    $viewcategories = new category_class();
    return $viewcategories->viewCategories();
}


