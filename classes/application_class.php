<?php
//connect to database class
require_once("../settings/db_class.php");

class application_class extends db_connection
{
    /**
     * Submit a new application for a role
     */
    public function submitApplication($role_id, $seller_id, $reason = null)
    {
        $role_id = (int)$role_id;
        $seller_id = (int)$seller_id;
        $reason = mysqli_real_escape_string($this->db_conn(), $reason);

        $sql = "INSERT INTO application (role_id, seller_id, application_statement, status)
                VALUES ('$role_id', '$seller_id', '$reason', 0)"; // 0 = Pending by default

        return $this->db_query($sql);
    }

    /**
     * Fetch all applications for a specific project (used for role management by project creators)
     */
    public function getApplicationsByProject($project_id)
    {
        $project_id = (int)$project_id;

        $sql = "SELECT a.*, s.seller_name, r.role_name 
                FROM application AS a
                JOIN seller AS s ON a.seller_id = s.seller_id
                JOIN project_role AS r ON a.role_id = r.role_id
                WHERE r.project_id = '$project_id'";

        return $this->db_fetch_all($sql);
    }

    /**
     * Approve an application
     */
    public function approveApplication($application_id)
    {
        $application_id = (int)$application_id;

        // Fetch application details
        $application = $this->getApplicationById($application_id);

        if ($application) {
            $role_id = $application['role_id'];
            $seller_id = $application['seller_id'];

            // Grant project membership
            if ($this->grantProjectMembership($role_id, $seller_id)) {
                // Reject all other applications for the same role
                $sql_reject_others = "UPDATE application SET status = 2 WHERE role_id = '$role_id' AND application_id != '$application_id'";
                $this->db_query($sql_reject_others);

                // Delete the approved application from the database
                $sql_delete_approved = "DELETE FROM application WHERE application_id = '$application_id'";
                return $this->db_query($sql_delete_approved);
            }
        }

        return false;
    }

    /**
     * Reject an application
     */
    public function rejectApplication($application_id)
{
    $application_id = (int)$application_id;

    // Fetch application details
    $application = $this->getApplicationById($application_id);

    if ($application) {
        // Delete the application after rejection
        $sql = "DELETE FROM application WHERE application_id = '$application_id'";
        return $this->db_query($sql);
    }

    return false;
}

    /**
     * Grant project membership upon application approval
     */
    public function grantProjectMembership($role_id, $seller_id)
    {
    $role_id = (int)$role_id;
    $seller_id = (int)$seller_id;

    // Get the project_id from the project_role table
    $sql_project_id = "SELECT project_id FROM project_role WHERE role_id = '$role_id'";
    $project_data = $this->db_fetch_one($sql_project_id);

    if ($project_data) {
        $project_id = $project_data['project_id'];

        // Check if the membership already exists
        $checkMembership = "SELECT * FROM project_membership WHERE role_id = '$role_id' AND seller_id = '$seller_id'";
        $existingMembership = $this->db_fetch_one($checkMembership);

        if ($existingMembership) {
            // Membership already exists, no need to insert again
            return true;
        }

        // Insert into project_membership table
        $sql = "INSERT INTO project_membership (role_id, seller_id)
                VALUES ('$role_id', '$seller_id')";

        if ($this->db_query($sql)) {
            // Update the role's "taken" column to indicate the role is now taken
            $updateRole = "UPDATE project_role SET taken = 1 WHERE role_id = '$role_id'";
            $updateResult = $this->db_query($updateRole);

            if (!$updateResult) {
                // Log if the update role query fails
                error_log("Failed to update 'taken' status for role_id $role_id");
            }

            return $updateResult;
        } else {
            // Log if the insert membership query fails
            error_log("Failed to insert project membership for role_id $role_id and seller_id $seller_id");
        }
    } else {
        // Log if the role_id does not exist in the project_role table
        error_log("No project_id found for role_id $role_id");
    }

    return false;
    }

    /**
     * Fetch application details by ID
     */
    public function getApplicationById($application_id)
    {
        $application_id = (int)$application_id;

        $sql = "SELECT a.*, s.seller_name, r.role_name, r.project_id
                FROM application AS a
                JOIN seller AS s ON a.seller_id = s.seller_id
                JOIN project_role AS r ON a.role_id = r.role_id
                WHERE a.application_id = '$application_id'";

        return $this->db_fetch_one($sql);
    }
}
