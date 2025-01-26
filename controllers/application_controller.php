<?php
// Include the application class
require_once("../classes/application_class.php");

/**
 * Submit a new application for a role
 * 
 * @param int $role_id
 * @param int $seller_id
 * @param string|null $reason
 * @return bool
 */
function submitApplication_ctr($role_id, $seller_id, $reason = null)
{
    $application = new application_class();
    return $application->submitApplication($role_id, $seller_id, $reason);
}

/**
 * Fetch all applications for a specific project
 * 
 * @param int $project_id
 * @return array|false
 */
function fetchApplicationsByProject_ctr($project_id)
{
    $application = new application_class();
    return $application->getApplicationsByProject($project_id);
}

/**
 * Approve an application
 * 
 * @param int $application_id
 * @return bool
 */
function approveApplication_ctr($application_id)
{
    $application = new application_class();

    // Fetch the application details to grant project membership
    $app_details = $application->getApplicationById($application_id);

    if ($app_details) {
        $role_id = $app_details['role_id'];
        $seller_id = $app_details['seller_id'];

        // Approve application and grant membership
        if (
            $application->approveApplication($application_id) &&
            $application->grantProjectMembership($role_id, $seller_id)
        ) {
            return true;
        }
    }
    return false;
}

/**
 * Reject an application
 * 
 * @param int $application_id
 * @return bool
 */
function rejectApplication_ctr($application_id)
{
    $application = new application_class();
    return $application->rejectApplication($application_id);
}

/**
 * Fetch a single application by ID
 * 
 * @param int $application_id
 * @return array|false
 */
function fetchApplicationById_ctr($application_id)
{
    $application = new application_class();
    return $application->getApplicationById($application_id);
}
