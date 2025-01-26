<?php
//connect to the user account class
include_once("../classes/user_class.php");




function registerCustomer_ctr($customer_name, $email, $password, $country, $city, $contact_no, $user_role){
	$addcustomer=new user_class();
	$result = $addcustomer->registerCustomer($customer_name, $email, $password, $country, $city, $contact_no, $user_role);
}

function loginCustomer_ctr($email, $password) {
	$logincustomer = new user_class();
	$result = $logincustomer->loginCustomer($email, $password);

    // Call the login_user method in the general_class
    return $result;
}


function registerSeller_ctr($seller_name, $email, $password, $country, $city, $contact_no, $user_role){
	$addseller=new user_class();
	$result = $addseller->registerSeller($seller_name, $email, $password, $country, $city, $contact_no, $user_role);
} 

function loginSeller_ctr($email, $password) {
	$loginseller = new user_class();
	$result = $loginseller->loginSeller($email, $password);

    // Call the login_user method in the general_class
    return $result;
}



function deleteCustomer($customer_id) {
    $user = new user_class();
    return $user->deleteCustomer($customer_id);
}

function deleteSeller($seller_id) {
    $user = new user_class();
    return $user->deleteSeller($seller_id);
}



function loginAdmin_ctr($email, $password) {
	$loginadmin = new user_class();
	$result = $loginadmin->loginAdmin($email, $password);

    // Call the login_user method in the general_class
    return $result;
}



function updateSellerProfile_ctr($seller_id, $seller_name = null, $country = null, $city = null, $contact_no = null, $profile_picture = null, $password = null) {
    $user = new user_class();
    return $user->updateSellerProfile($seller_id, $seller_name, $country, $city, $contact_no, $profile_picture, $password);
}


function updateCustomerProfile_ctr($customer_id, $customer_name, $email, $country, $city, $contact_no) {
    $updateCustomer = new user_class();
    return $updateCustomer->updateCustomerProfile($customer_id, $customer_name, $email, $country, $city, $contact_no);
}


function fetchAllCustomers() {
    $user = new user_class();
    return $user->fetchAllCustomers();
}

function fetchAllSellers() {
    $user = new user_class();
    return $user->fetchAllSellers();
}

function fetchSellerDetails($seller_id) {
    $user_instance = new user_class();
    return $user_instance->fetchSellerDetails($seller_id);
}

function fetchCustomerDetails($customer_id) {
    $user_instance = new user_class();
    return $user_instance->fetchCustomerDetails($customer_id);
}