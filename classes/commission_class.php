<?php
require_once("../settings/db_class.php");


class commission_class extends db_connection
{

    /*public function processPaymentCommission($payment_id, $project_id, $project_price)
    {
        // Calculate the progressive commission rate
        $commission_rate = $this->calculateProgressiveRate($project_price);
        $charge = $project_price * $commission_rate;
        $remainder = $project_price - $charge;

        // Insert the commission record
        $sql = "INSERT INTO commision (payment_id, project_id, charge, remainder) 
                VALUES ('$payment_id', '$project_id', '$charge', '$remainder')";
        $this->db_query($sql);

        // Get the commission ID of the newly inserted record
        $commission_id = mysqli_insert_id($this->db_conn());

        // Distribute seller credits
        $this->distributeSellerCredits($project_id, $remainder, $commission_id);
    }*/

    public function getLastPaymentId() {
        //$customer_id = (int)$customer_id;
        $sql = "SELECT pay_id FROM payment ORDER BY payment_date DESC LIMIT 1";

        $result = $this->db_fetch_one($sql);
        if ($result) {
            return $result['pay_id']; // Return the last order_id
        } else {
            error_log("No payments found.");
            return false;
        }
    }

    private function calculateProgressiveRate($project_price)
    {
        if ($project_price <= 50) {
            return 0.10; // 10%
        } elseif ($project_price <= 100) {
            return 0.15; // 15%
        } else {
            return 0.20; // 20%
        }
    }

    private function distributeSellerCredits($project_id, $remainder, $commission_id)
    {
        // Fetch project roles and their takings
        $sql = "SELECT pm.pm_id, pr.takings, s.seller_id
                FROM project_membership pm
                JOIN project_role pr ON pm.role_id = pr.role_id
                JOIN seller s ON pm.seller_id = s.seller_id
                WHERE pr.project_id = '$project_id'";
        $roles = $this->db_fetch_all($sql);

        foreach ($roles as $role) {
            $pm_id = $role['pm_id'];
            $takings_percentage = $role['takings'] / 100; // Convert to decimal
            $seller_id = $role['seller_id'];

            // Calculate remuneration
            $remuneration = $remainder * $takings_percentage;

            // Insert seller credit
            $credit_sql = "INSERT INTO seller_credit (pm_id, remuneration, commision_id) 
                           VALUES ('$pm_id', '$remuneration', '$commission_id')";
            $this->db_query($credit_sql);

            // Update seller's account balance
            $update_balance_sql = "UPDATE seller SET account_balance = account_balance + '$remuneration' 
                                   WHERE seller_id = '$seller_id'";
            $this->db_query($update_balance_sql);
        }
    } 



    // Add a commission record
    public function addCommission($payment_id, $project_id, $charge, $remainder)
    {
        $sql = "INSERT INTO commision (payment_id, project_id, charge, remainder) VALUES (?, ?, ?, ?)";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("iidd", $payment_id, $project_id, $charge, $remainder);
        return $stmt->execute();
    }

    // Add seller credit
    public function addSellerCredit($pm_id, $remuneration, $commision_id)
    {
        $sql = "INSERT INTO seller_credit (pm_id, remuneration, commision_id) VALUES (?, ?, ?)";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("idi", $pm_id, $remuneration, $commision_id);
        return $stmt->execute();
    }

    // Update seller's account balance
    public function updateSellerAccountBalance($seller_id, $remuneration)
    {
        $sql = "UPDATE seller SET account_balance = account_balance + ? WHERE seller_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("di", $remuneration, $seller_id);
        return $stmt->execute();
    }

    // Get project role takings percentage
    public function getRoleTakingsPercentage($pm_id)
    {
        $sql = "SELECT pr.takings / 100 AS takings_percentage
                FROM project_membership pm
                JOIN project_role pr ON pm.role_id = pr.role_id
                WHERE pm.pm_id = ?";
        $stmt = $this->db_conn()->prepare($sql);
        $stmt->bind_param("i", $pm_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Get project members indirectly through project roles
    public function getProjectMemberships($project_id) {
        $project_id = (int)$project_id;

        $sql = "SELECT pm.*, s.*, r.*, r.description 
                FROM project_membership AS pm
                JOIN project_role AS r ON pm.role_id = r.role_id
                JOIN seller AS s ON pm.seller_id = s.seller_id
                WHERE r.project_id = '$project_id'";

        return $this->db_fetch_all($sql);
    }
}
?>
