<?php
// Connect to database class
require_once("../settings/db_class.php");

class message_class extends db_connection
{
    /**
     * Send a message between project members
     */
    public function sendMessage($pm_id1, $pm_id2, $text)
    {
        $pm_id1 = (int)$pm_id1;
        $pm_id2 = (int)$pm_id2;
        $text = mysqli_real_escape_string($this->db_conn(), $text);
        $sent_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO message (pm_id1, pm_id2, text, sent_at)
                VALUES ('$pm_id1', '$pm_id2', '$text', '$sent_at')";

        return $this->db_query($sql);
    }

    /**
     * Fetch all messages between two project members
     */
    public function fetchMessages($pm_id1, $pm_id2) {
        $pm_id1 = (int)$pm_id1;
        $pm_id2 = (int)$pm_id2;
    
        $sql = "
            SELECT * 
            FROM message 
            WHERE (pm_id1 = '$pm_id1' AND pm_id2 = '$pm_id2')
               OR (pm_id1 = '$pm_id2' AND pm_id2 = '$pm_id1')
            ORDER BY sent_at ASC
        ";
    
        return $this->db_fetch_all($sql);
    }
    

    /**
     * Delete a specific message
     */
    public function deleteMessage($message_id)
    {
        $message_id = (int)$message_id;

        $sql = "DELETE FROM message WHERE message_id = '$message_id'";

        return $this->db_query($sql);
    }
}
?>
