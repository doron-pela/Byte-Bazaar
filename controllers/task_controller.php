<?php
// Import task class
require_once("../classes/task_class.php");

/**
 * Add a new task
 */
function addTask_ctr($pm_id, $delegate, $task_name, $task_description, $predecessor_task, $successor_task, $deadline, $task_attachment)
{
    $task = new task_class();
    return $task->addTask($pm_id, $delegate, $task_name, $task_description, $predecessor_task, $successor_task, $deadline, $task_attachment);
}

/**
 * Fetch all tasks for a specific role.
 */
function fetchTasksByRole_ctr($role_id)
{
    $task = new task_class();
    return $task->fetchTasksByRole($role_id);
}

/**
 * Fetch all tasks for a specific project.
 */
function fetchTasksByProject_ctr($project_id)
{
    $task = new task_class();
    return $task->fetchTasksByProject($project_id);
}

/**
 * Fetch filtered tasks based on deadline, status, or succession.
 */
function fetchFilteredTasks_ctr($project_id, $filter_type, $filter_value = null)
{
    $task = new task_class();
    return $task->fetchFilteredTasks($project_id, $filter_type, $filter_value);
}

/**
 * Update the status of a task (Complete/Incomplete).
 */
function updateTaskStatus_ctr($task_id, $status)
{
    $task = new task_class();
    return $task->updateTaskStatus($task_id, $status);
}

/**
 * Update task details.
 */
function updateTaskDetails_ctr($task_id, $task_name, $task_description, $delegate_to, $is_complete, $deadline, $task_attachment = null)
{
    $task = new task_class();
    return $task->updateTaskDetails($task_id, $task_name, $task_description, $delegate_to, $is_complete, $deadline, $task_attachment);
}

/**
 * Fetch a single task by ID.
 */
function fetchTaskById_ctr($task_id)
{
    $task = new task_class();
    return $task->fetchTaskById($task_id);
}

/**
 * Delete a task.
 */
function deleteTask_ctr($task_id)
{
    $task = new task_class();
    return $task->deleteTask($task_id);
}

/**
 * Fetch task attachments.
 */
function fetchTaskAttachments_ctr($task_id)
{
    $task = new task_class();
    return $task->fetchTaskAttachments($task_id);
}

function updateCompletedAttachment_ctr($task_id, $file_name)
{
    $task = new task_class();
    return $task->updateCompletedAttachment($task_id, $file_name);
}

function fetchAllTasksByProject_ctr($project_id)
{
    $task = new task_class();
    return $task->fetchAllTasksByProject($project_id);
}


?>
