<?php
// Connect to the database class
require_once("../settings/db_class.php");

class role_class extends db_connection
{
    /**
     * Fetch roles by project ID
     *
     * @param int $project_id
     * @return array|false
     */
    public function getRolesByProjectId($project_id)
    {
        $project_id = (int)$project_id;

        $sql = "SELECT * FROM project_role WHERE project_id = '$project_id'";
        return $this->db_fetch_all($sql);
    }

    /**
     * Fetch roles by project (wrapper function for more explicit usage)
     *
     * @param int $project_id
     * @return array|false
     */
    public function fetchRolesByProject($project_id)
    {
        return $this->getRolesByProjectId($project_id);
    }

    /**
     * Create a new role
     *
     * @param int $project_id
     * @param string $role_name
     * @param string $role_description
     * @return bool
     */
    public function createRole($project_id, $role_name, $role_description, $takings)
    {
        $project_id = (int)$project_id;
        $takings = (int)$takings;
        $role_name = mysqli_real_escape_string($this->db_conn(), $role_name);
        $role_description = mysqli_real_escape_string($this->db_conn(), $role_description);

        $sql = "INSERT INTO project_role (project_id, role_name, description, takings) 
                VALUES ('$project_id', '$role_name', '$role_description', '$takings')";

        return $this->db_query($sql);
    }

    /**
     * Fetch a single role by its ID
     *
     * @param int $role_id
     * @return array|false
     */
    public function fetchRoleById($role_id)
    {
        $role_id = (int)$role_id;

        $sql = "SELECT * FROM project_role WHERE role_id = '$role_id'";
        return $this->db_fetch_one($sql);
    }

    public function deleteRole($role_id) {
        $role_id = (int)$role_id;
    
        // Delete the role from the project_role table
        $sql = "DELETE FROM project_role WHERE role_id = '$role_id'";
        return $this->db_query($sql);
    }
    

    public function fetchProjectRolesWithMembers($project_id) {
        $project_id = (int)$project_id;
    
        $sql = "
            SELECT pr.role_id, pr.role_name, s.seller_id, s.seller_name
            FROM project_role pr
            LEFT JOIN project_membership pm ON pr.role_id = pm.role_id
            LEFT JOIN seller s ON pm.seller_id = s.seller_id
            WHERE pr.project_id = '$project_id'
        ";
    
        $result = $this->db_fetch_all($sql);
    
        $roles = [];
        foreach ($result as $row) {
            if (!isset($roles[$row['role_id']])) {
                $roles[$row['role_id']] = [
                    'role_name' => $row['role_name'],
                    'members' => []
                ];
            }
            if (!empty($row['seller_id'])) {
                $roles[$row['role_id']]['members'][] = [
                    'seller_id' => $row['seller_id'],
                    'seller_name' => $row['seller_name']
                ];
            }
        }
    
        return array_values($roles);
    }
    

}
