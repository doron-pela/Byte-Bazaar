<?php
// Import message class
require_once("../classes/message_class.php");

/**
 * Send a message
 */
function sendMessage_ctr($pm_id1, $pm_id2, $text)
{
    $message = new message_class();
    return $message->sendMessage($pm_id1, $pm_id2, $text);
}

/**
 * Fetch messages between two project members
 */
function fetchMessages_ctr($pm_id1, $pm_id2) {
    $message = new message_class();
    return $message->fetchMessages($pm_id1, $pm_id2);
}

/**
 * Delete a message
 */
function deleteMessage_ctr($message_id)
{
    $message = new message_class();
    return $message->deleteMessage($message_id);
}
?>
