<?php
//connect to database class
require_once("../settings/db_class.php");

class project_class extends db_connection
{

    public function addProject($title, $description, $price, $keywords, $category, $seller_id, $creator_takings) {
        // Escape and sanitize input data
        $title = mysqli_real_escape_string($this->db_conn(), $title);
        $description = mysqli_real_escape_string($this->db_conn(), $description);
        $price = (float)$price;
        $keywords = mysqli_real_escape_string($this->db_conn(), $keywords);
        $category = (int)$category;
        $seller_id = (int)$seller_id;
        $creator_takings = (float)$creator_takings;

        // Insert the project
        $sql = "INSERT INTO projects (project_title, project_desc, project_price, project_keywords, project_cat, seller_id) 
                VALUES ('$title', '$description', '$price', '$keywords', '$category', '$seller_id')";

        if (!$this->db_query($sql)) {
            die("Query Failed: " . mysqli_error($this->db)); // Log the SQL error
        }

        // Get the last inserted project ID
        $last_project_id = mysqli_insert_id($this->db);
        if (!$last_project_id) {
            die("Failed to retrieve last inserted project ID.");
        }

        // Add creator role to `project_role`
        $role_sql = "INSERT INTO project_role (project_id, role_name, description, takings, taken) 
                     VALUES ('$last_project_id', 'Creator', 'Creator', '$creator_takings', 1)";
        if (!$this->db_query($role_sql)) {
            die("Failed to create Creator role: " . mysqli_error($this->db));
        }

        // Get the role ID for the creator
        $last_role_id = mysqli_insert_id($this->db);

        // Grant the creator project membership
        if (!$this->grantProjectMembership($last_role_id, $seller_id)) {
            die("Failed to grant project membership to creator.");
        }

        return $last_project_id;
    }

    public function grantProjectMembership($role_id, $seller_id) {
        $role_id = (int)$role_id;
        $seller_id = (int)$seller_id;

        // Check if the membership already exists
        $checkMembership = "SELECT * FROM project_membership WHERE role_id = '$role_id' AND seller_id = '$seller_id'";
        $existingMembership = $this->db_fetch_one($checkMembership);

        if ($existingMembership) {
            return true; // Membership already exists
        }

        // Insert into project_membership table
        $sql = "INSERT INTO project_membership (role_id, seller_id) VALUES ('$role_id', '$seller_id')";
        if ($this->db_query($sql)) {
            // Update the role's "taken" column to indicate it's now taken
            $updateRole = "UPDATE project_role SET taken = 1 WHERE role_id = '$role_id'";
            return $this->db_query($updateRole);
        }

        return false;
    }

    
    
    public function addRole($project_id, $role_name, $role_description, $role_takings, $role_availability) {

        $project_id = (int)$project_id;
        $role_name = mysqli_real_escape_string($this->db_conn(), $role_name);
        $role_description = mysqli_real_escape_string($this->db_conn(), $role_description);
        $role_takings = (float)$role_takings;
        $role_availability = (int)$role_availability;

        $sql = "INSERT INTO project_role (project_id, role_name, description, takings, taken) 
                VALUES ('$project_id', '$role_name', '$role_description', '$role_takings', '$role_availability')";
        return $this->db_query($sql);
    }

    // Function to delete a project by its ID
    public function deleteProject($project_id)
    {
        $ndb = new db_connection();
        $project_name = mysqli_real_escape_string($ndb->db_conn(), $project_id);
        
        $sql = "DELETE FROM `projects` WHERE `project_id` = '$project_id'";
        return $this->db_query($sql);
    }

    // Function to retrieve all projects
    public function viewProjects()
    {
        $sql = "SELECT projects.*, categories.cat_name
                FROM projects
                JOIN categories ON projects.project_cat = categories.cat_id";
        return $this->db_fetch_all($sql);  // Fetch all records
    }

    public function viewCategories() {
        $sql = "SELECT * FROM categories";
        return $this->db_fetch_all($sql); // Fetch all records as an associative array
    }
    

    public function fetchAllUnpublishedProjects()
    {
        $sql = "SELECT p.project_id, p.project_title, p.project_desc, p.project_price, p.published, c.cat_name 
                FROM projects AS p
                JOIN categories AS c ON p.project_cat = c.cat_id
                WHERE p.published = 0";

        $result = $this->db_fetch_all($sql);
        return $result; // Returns an array or false
    }

    public function getProjectsBySeller($seller_id) {
        $sql = "SELECT * FROM projects WHERE seller_id = '$seller_id'";
        return $this->db_fetch_all($sql);
    }

    public function getProjectsByMembership($seller_id) {
        $seller_id = (int)$seller_id;
    
        $sql = "SELECT DISTINCT p.project_id, p.*, p.project_desc, p.project_price, c.cat_name, pr.role_name, pr.takings 
        FROM project_membership pm 
        JOIN project_role pr ON pm.role_id = pr.role_id 
        JOIN projects p ON pr.project_id = p.project_id 
        JOIN categories c ON p.project_cat = c.cat_id 
        WHERE pm.seller_id = '$seller_id';";
    
        return $this->db_fetch_all($sql);
    }
    

    public function getProjectById($project_id) {
        $sql = "SELECT projects.*, categories.cat_name 
                FROM projects
                JOIN categories ON projects.project_cat = categories.cat_id
                WHERE projects.project_id = '$project_id'";
        return $this->db_fetch_one($sql);
    }
    
    
    // Get project members indirectly through project roles
    public function getProjectMembersByProject($project_id) {
        $project_id = (int)$project_id;

        $sql = "SELECT pm.*, s.*, r.*, r.description 
                FROM project_membership AS pm
                JOIN project_role AS r ON pm.role_id = r.role_id
                JOIN seller AS s ON pm.seller_id = s.seller_id
                WHERE r.project_id = '$project_id'";

        return $this->db_fetch_all($sql);
    }

    public function removeMember($membership_id)
    {
        $membership_id = (int)$membership_id;

        $sql = "DELETE FROM project_membership WHERE pm_id = '$membership_id'";
        return $this->db_query($sql);
    }


    // Remove a project member
    public function removeProjectMember($membership_id) {
        $membership_id = (int)$membership_id;

        // Get the role ID to update the "taken" column
        $sql_role_id = "SELECT role_id FROM project_membership WHERE pm_id = '$membership_id'";
        $role_data = $this->db_fetch_one($sql_role_id);

        if ($role_data) {
            $role_id = $role_data['role_id'];

            // Delete the project membership
            $sql_delete = "DELETE FROM project_membership WHERE pm_id = '$membership_id'";

            // Update the "taken" column to make the role available again
            $updateRole = "UPDATE project_role SET taken = 0 WHERE role_id = '$role_id'";

            return $this->db_query($sql_delete) && $this->db_query($updateRole);
        }

        return false;
    }

    public function fetchProjectMembershipsBySeller($seller_id)
    {
        $seller_id = (int)$seller_id;

        $sql = "SELECT pm.pm_id, p.project_title, p.project_id, pr.role_name
                FROM project_membership pm
                JOIN project_role pr ON pm.role_id = pr.role_id
                JOIN projects p ON pr.project_id = p.project_id
                WHERE pm.seller_id = '$seller_id'";

        return $this->db_fetch_all($sql);
    }


    public function getRolesBySeller($seller_id) {
        $seller_id = (int)$seller_id;
        $sql = "
            SELECT pm.pm_id, pr.*, s.seller_name 
            FROM project_membership pm 
            JOIN seller s ON s.seller_id = pm.seller_id 
            JOIN project_role pr ON pm.role_id = pr.role_id 
            WHERE pm.seller_id = '$seller_id';
        ";
        return $this->db_fetch_all($sql);
    }
    

    public function getJoinedProjects($seller_id) {
        $seller_id = (int)$seller_id;
    
        $sql = "
            SELECT DISTINCT 
                p.project_id, 
                p.project_title, 
                p.project_desc, 
                p.project_price,
                pr.role_name,
                pm.*
            FROM project_membership pm
            JOIN project_role pr ON pm.role_id = pr.role_id
            JOIN projects p ON pr.project_id = p.project_id
            WHERE pm.seller_id = '$seller_id'
        ";
    
        return $this->db_fetch_all($sql);
    }
    
    /**
     * Fetch all project members associated with a specific project ID.
     */
    public function fetchProjectMembers($project_id)
    {
        $project_id = (int)$project_id;

        $sql = "
            SELECT 
                pm.pm_id,
                pm.*,
                s.seller_id,
                s.*,
                pr.role_name
            FROM project_membership pm
            JOIN seller s ON pm.seller_id = s.seller_id
            JOIN project_role pr ON pm.role_id = pr.role_id
            WHERE pr.project_id = '$project_id'
        ";

        return $this->db_fetch_all($sql);
    }
    
    public function getProjectCreator($project_id) {
        $project_id = (int)$project_id;
    
        $sql = "
            SELECT s.seller_id, s.seller_name, 'Creator' AS role_name 
            FROM projects p 
            JOIN seller s ON p.seller_id = s.seller_id 
            WHERE p.project_id = '$project_id'
        ";
    
        return $this->db_fetch_one($sql);
    }

    public function updateProjectDetails(
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
        // Escape inputs to prevent SQL injection
        $project_id =(int)$project_id;
        $project_title = mysqli_real_escape_string($this->db_conn(), $project_title);
        $project_desc = mysqli_real_escape_string($this->db_conn(), $project_desc);
        $project_price = mysqli_real_escape_string($this->db_conn(), $project_price);
        $project_keywords = mysqli_real_escape_string($this->db_conn(), $project_keywords);
        $project_category = mysqli_real_escape_string($this->db_conn(), $project_category);
        $link = mysqli_real_escape_string($this->db_conn(), $link);
        $project_image = mysqli_real_escape_string($this->db_conn(), $project_image);
        $file = mysqli_real_escape_string($this->db_conn(), $file);
        $sc1 = mysqli_real_escape_string($this->db_conn(), $sc1);
        $sc2 = mysqli_real_escape_string($this->db_conn(), $sc2);
        $sc3 = mysqli_real_escape_string($this->db_conn(), $sc3);
        $published = (int)$published;
    
        // SQL query with escaped inputs
        $sql = "
            UPDATE projects
            SET 
                project_title = '$project_title',
                project_desc = '$project_desc',
                project_price = $project_price,
                project_keywords = '$project_keywords',
                project_cat = $project_category,
                link = '$link',
                project_image = '$project_image',
                file = '$file',
                sc1 = '$sc1',
                sc2 = '$sc2',
                sc3 = '$sc3',
                published = $published
            WHERE project_id = $project_id
        ";
    
        // Execute the query
        return $this->db_query($sql);
    }
    

    public function getPublishedProjects() {
        $sql = "SELECT * FROM projects WHERE published = 1";
        return $this->db_fetch_all($sql);
    }
    
    public function deleteProjectID($project_id) {
        $sql = "DELETE FROM projects WHERE project_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("i", $project_id);
        return $stmt->execute();
    }
    public function fetchAllProjects() {
        $sql = "SELECT * FROM projects";
        return $this->db_fetch_all($sql);
    }
    
    public function getProjectsByOrder($order_id) {
        $sql = "
            SELECT p.project_id, p.project_title, p.file 
            FROM orderdetails od
            JOIN projects p ON od.product_id = p.project_id
            WHERE od.order_id = '$order_id'
        ";
        return $this->db_fetch_all($sql);
    }
    
    public function getFilteredProjects($keyword = '', $min_price = '', $max_price = '', $category_id = '') {
        // Establish a database connection
        $conn = $this->db_conn();
    
        // Start the base query
        $sql = "SELECT * FROM projects WHERE published = 1";
    
        // Dynamically add filters
        if (!empty($keyword)) {
            $keyword = mysqli_real_escape_string($conn, $keyword);
            $sql .= " AND project_keywords LIKE '%$keyword%'";
        }
    
        if (!empty($min_price)) {
            $min_price = (float)$min_price;
            $sql .= " AND project_price >= $min_price";
        }
    
        if (!empty($max_price)) {
            $max_price = (float)$max_price;
            $sql .= " AND project_price <= $max_price";
        }
    
        if (!empty($category_id)) {
            $category_id = (int)$category_id;
            $sql .= " AND project_cat = $category_id";
        }
    
        // Execute and return the results
        return $this->db_fetch_all($sql);
    }
    
    

}

