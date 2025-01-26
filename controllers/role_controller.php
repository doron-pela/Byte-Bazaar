<?php
//connect to database class
require_once("../classes/role_class.php");


function fetchRolesByProjectId($project_id) {
    $role = new role_class();
    return $role->getRolesByProjectId($project_id);
}


function fetchRolesByProject_ctr($project_id) {
    $role = new role_class();
    return $role->fetchRolesByProject($project_id);
}

function createRole_ctr($project_id, $role_name, $role_description, $takings) {
    $role = new role_class();
    return $role->createRole($project_id, $role_name, $role_description,  $takings);
}

function fetchRoleById_ctr($role_id) {
    $role = new role_class();
    return $role->fetchRoleById($role_id);
}

function deleteRole_ctr($role_id) {
    $role = new role_class();
    return $role->deleteRole($role_id);
}

function fetchProjectRolesWithMembers_ctr($project_id) {
    $role = new role_class();
    return $role->fetchProjectRolesWithMembers($project_id);
}
