<?php
//connect to database class
require_once("../settings/db_class.php");

class task_class extends db_connection
{
    /**
     * Add a new task to the database.
     */
    public function addTask($pm_id, $delegate, $task_name, $task_description, $predecessor_task, $successor_task, $deadline, $task_attachment)
    {
        $pm_id = (int)$pm_id;
        $delegate = $delegate ? (int)$delegate : "NULL";
        $task_name = mysqli_real_escape_string($this->db_conn(), $task_name);
        $task_description = mysqli_real_escape_string($this->db_conn(), $task_description);
        $predecessor_task = $predecessor_task ? (int)$predecessor_task : "NULL";
        $successor_task = $successor_task ? (int)$successor_task : "NULL";
        $deadline = mysqli_real_escape_string($this->db_conn(), $deadline);
        $task_attachment = $task_attachment ? mysqli_real_escape_string($this->db_conn(), $task_attachment) : "NULL";

        $sql = "INSERT INTO task (pm_id, delegate, task_name, task_description, predecessor_task, successor_task, deadline, task_attachment, status)
                VALUES ('$pm_id', $delegate, '$task_name', '$task_description', $predecessor_task, $successor_task, '$deadline', '$task_attachment', 0)";

        return $this->db_query($sql);
    }

    /**
     * Fetch all tasks for a specific project member (role_id).
     */
    public function fetchTasksByRole($role_id)
    {
        $role_id = (int)$role_id;

        $sql = "
            SELECT 
                t.*,
                pm.role_id,
                pr.role_name,
                pr.project_id,
                s.seller_name AS delegate_name
            FROM task t
            JOIN project_membership pm ON t.pm_id = pm.pm_id
            JOIN project_role pr ON pm.role_id = pr.role_id
            LEFT JOIN seller s ON t.delegate = s.seller_id
            WHERE pm.role_id = '$role_id'
        ";

        return $this->db_fetch_all($sql);
    }

    /**
     * Fetch all tasks by project.
     */
    public function fetchTasksByProject($project_id)
    {
        $project_id = (int)$project_id;

        $sql = "
            SELECT t.*, pr.role_name, pm.seller_id, s.seller_name AS delegate_name
            FROM task t
            JOIN project_membership pm ON t.pm_id = pm.pm_id
            JOIN project_role pr ON pm.role_id = pr.role_id
            LEFT JOIN seller s ON t.delegate = s.seller_id
            WHERE pr.project_id = '$project_id'
        ";

        return $this->db_fetch_all($sql);
    }

    /**
     * Fetch filtered tasks based on criteria (deadline, status, or succession).
     */
    public function fetchFilteredTasks($project_id, $filter_type, $filter_value = null)
    {
        $project_id = (int)$project_id;
        $sql = "SELECT t.*, pr.role_name, pm.seller_id
                FROM task t
                JOIN project_membership pm ON t.pm_id = pm.pm_id
                JOIN project_role pr ON pm.role_id = pr.role_id
                WHERE pr.project_id = '$project_id'";

        if ($filter_type === "status") {
            $status = (int)$filter_value;
            $sql .= " AND t.status = '$status'";
        } elseif ($filter_type === "deadline") {
            $sql .= " AND DATE_FORMAT(t.deadline, '%Y-%m') = '$filter_value'";
        } elseif ($filter_type === "succession") {
            if ($filter_value === "predecessor") {
                $sql .= " AND t.predecessor_task IS NOT NULL";
            } elseif ($filter_value === "successor") {
                $sql .= " AND t.successor_task IS NOT NULL";
            }
        }

        return $this->db_fetch_all($sql);
    }

    /**
     * Update the status of a task.
     */
    public function updateTaskStatus($task_id, $status)
    {
        $task_id = (int)$task_id;
        $status = (int)$status;

        $sql = "UPDATE task SET status = '$status' WHERE task_id = '$task_id'";
        return $this->db_query($sql);
    }

    /**
     * Fetch a single task by ID.
     */
    public function fetchTaskById($task_id)
    {
        $task_id = (int)$task_id;

        $sql = "
            SELECT 
                t.*, pr.role_name, pr.project_id, s.seller_name AS delegate_name
            FROM task t
            LEFT JOIN project_membership pm ON t.pm_id = pm.pm_id
            LEFT JOIN project_role pr ON pm.role_id = pr.role_id
            LEFT JOIN seller s ON t.delegate = s.seller_id
            WHERE t.task_id = '$task_id'
        ";

        return $this->db_fetch_one($sql);
    }

    /**
     * Update task details.
     */
    public function updateTaskDetails($task_id, $task_name, $task_description, $delegate_to, $is_complete, $deadline, $task_attachment = null)
    {
        $task_id = (int)$task_id;
        $task_name = mysqli_real_escape_string($this->db_conn(), $task_name);
        $task_description = mysqli_real_escape_string($this->db_conn(), $task_description);
        $delegate_to = $delegate_to ? (int)$delegate_to : "NULL";
        $is_complete = (int)$is_complete;
        $deadline_clause = $deadline ? ", deadline = '" . mysqli_real_escape_string($this->db_conn(), $deadline) . "'" : "";
        $attachment_clause = $task_attachment ? ", task_attachment = '" . mysqli_real_escape_string($this->db_conn(), $task_attachment) . "'" : "";

        $sql = "
            UPDATE task 
            SET 
                task_name = '$task_name',
                task_description = '$task_description',
                delegate = $delegate_to,
                status = '$is_complete',
                deadline = '$deadline_clause',
                task_attachment = '$attachment_clause',
            WHERE task_id = '$task_id'
        ";

        return $this->db_query($sql);
    }

    /**
     * Delete a task.
     */
    public function deleteTask($task_id)
    {
        $task_id = (int)$task_id;
        $sql = "DELETE FROM task WHERE task_id = '$task_id'";
        return $this->db_query($sql);
    }

    /**
    * Fetch all attachments for a task.
    */
    public function fetchTaskAttachments($task_id)
    {
        $task_id = (int)$task_id;

        $sql = "SELECT task_attachment FROM task WHERE task_id = '$task_id'";
        return $this->db_fetch_all($sql);
    }

    public function updateCompletedAttachment($task_id, $file_name)
    {
        $task_id = (int)$task_id;
        $file_name = mysqli_real_escape_string($this->db_conn(), $file_name);

        $sql = "UPDATE task SET completed_attachment = '$file_name' WHERE task_id = '$task_id'";
        return $this->db_query($sql);
    }

    public function fetchAllTasksByProject($project_id)
    {
        $project_id = (int)$project_id;

        $sql = "
            SELECT 
                t.*, 
                pr.role_name, 
                pm.seller_id AS task_owner, 
                s.seller_name AS delegate_name 
            FROM task t
            JOIN project_membership pm ON t.pm_id = pm.pm_id
            JOIN project_role pr ON pm.role_id = pr.role_id
            LEFT JOIN seller s ON t.delegate = s.seller_id
            WHERE pr.project_id = '$project_id'
        ";

        return $this->db_fetch_all($sql);
    }


}

?>
