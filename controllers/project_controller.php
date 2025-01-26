<?php
//connect to the user account class
require_once("../classes/project_class.php");



/*function addProject($project_name, $project_brand, $project_price){
	$addproject=new project_class();
	$result = $addproject->addproject($project_name, $project_brand, $project_price);
}*/

// Function to delete a project by ID
function deleteProject($project_name) {
    $deleteproject = new project_class();
    return $deleteproject->deleteproject($project_name);
}

function viewCategories() {
    // Fetch categories logic from the database
    $categories = new project_class();
    return $categories->viewCategories(); // Assuming `viewCategories()` exists in `project_class`
}

// Function to view all projects
function viewProjects() {
    $viewprojects = new project_class();
    return $viewprojects->viewprojects();
}

// Fetch unpublished projects for a specific seller
function fetchAllUnpublishedProjects()
{
    $project = new project_class();
    return $project->fetchAllUnpublishedProjects();
}

function fetchProjectsBySeller($seller_id) {
    $project = new project_class();
    return $project->getProjectsBySeller($seller_id);
}

function fetchProjectsByMembership($seller_id) {
    $project = new project_class();
    return $project->getProjectsByMembership($seller_id);
}

function addProject_ctr($title, $description, $price, $keywords, $category, $seller_id, $creator_takings) {
    $project = new project_class();
    return $project->addProject($title, $description, $price, $keywords, $category, $seller_id, $creator_takings);
}

function grantProjectMembership_ctr($role_id, $seller_id) {
    $project = new project_class();
    return $project->grantProjectMembership($role_id, $seller_id);
}


function addRole($project_id, $role_name, $role_description, $role_takings, $role_availability) {
    $project = new project_class();
    return $project->addRole($project_id, $role_name, $role_description, $role_takings, $role_availability);
}


// Fetch project members by project
function fetchProjectMembersByProject_ctr($project_id) {
    $project = new project_class();
    return $project->getProjectMembersByProject($project_id);
}

// Remove a project member
function removeProjectMember_ctr($membership_id) {
    $project = new project_class();
    return $project->removeProjectMember($membership_id);
}


// Fetch a single project by ID
function fetchProjectById($project_id) {
    $project = new project_class();
    return $project->getProjectById($project_id);
}

function fetchProjectMembershipsBySeller_ctr($seller_id)
{
    $project = new project_class();
    return $project->fetchProjectMembershipsBySeller($seller_id);
}

function fetchRolesBySeller_ctr($seller_id) {
    $seller_id = (int)$seller_id;
    $project = new project_class(); 
    return $project->getRolesBySeller($seller_id);
}


function fetchJoinedProjects($seller_id) {
    $project_model = new project_class();
    return $project_model->getJoinedProjects($seller_id);
}

function fetchProjectMembers_ctr($project_id)
{
    $project = new project_class();
    return $project->fetchProjectMembers($project_id);
}

function fetchProjectCreator($project_id) {
    $project = new project_class();
    return $project->getProjectCreator($project_id);
}

function updateProjectDetails_ctr(
    $project_id,
    $project_title,
    $project_desc,
    $project_price,
    $project_keywords,
    $project_category,
    $link,
    $project_image,
    $file,
    $sc1,
    $sc2,
    $sc3,
    $published
) {
    $project = new project_class();
    return $project->updateProjectDetails(
        $project_id,
        $project_title,
        $project_desc,
        $project_price,
        $project_keywords,
        $project_category,
        $link,
        $project_image,
        $file,
        $sc1,
        $sc2,
        $sc3,
        $published
    );
}

function fetchPublishedProjects() {
    $project_model = new project_class();
    return $project_model->getPublishedProjects();
}



function deleteProjectID($project_id) {
    $project = new project_class();
    return $project->deleteProjectID($project_id);
}


function fetchAllProjects() {
    $project = new project_class();
    return $project->fetchAllProjects();
}

function fetchPublishedProjectsBy($keyword = '', $min_price = '', $max_price = '', $category_id = '') {
    $project = new project_class();
    return $project->getFilteredProjects($keyword, $min_price, $max_price, $category_id);
}

/*function fetchProjectsByOrder($order_id) {
    $order_id = (int)$order_id;
    $project = new project_class();
    return $project->getProjectsByOrder($order_id); // Add this method in the project_class
}*/
