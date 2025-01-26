<?php
require_once("../classes/commission_class.php");

function calculateCommissionRate($project_price)
{
    // Define progressive commission rates
    if ($project_price <= 50) {
        return 0.05; // 5%
    } elseif ($project_price <= 200) {
        return 0.10; // 10%
    } elseif ($project_price <= 500) {
        return 0.15; // 15%
    } else {
        return 0.20; // 20%
    }
}

function processPaymentCommission($project_id, $project_price)
{
    $commission = new commission_class();

    // Calculate the commission rate and charge
    $commission_rate = calculateCommissionRate($project_price);
    $charge = $project_price * $commission_rate;
    $remainder = $project_price - $charge;
    $payment_id = $commission->getLastPaymentId();

    // Insert the commission record
    $commission->addCommission($payment_id, $project_id, $charge, $remainder);

    // Fetch project memberships for this project
    $memberships = $commission->getProjectMemberships($project_id);

    foreach ($memberships as $membership) {
        $pm_id = $membership['pm_id'];
        $seller_id = $membership['seller_id'];

        // Get the role takings percentage
        $role_data = $commission->getRoleTakingsPercentage($pm_id);
        $takings_percentage = $role_data['takings_percentage'];

        // Calculate the remuneration for this role
        $remuneration = $remainder * $takings_percentage;

        // Add seller credit
        $commission->addSellerCredit($pm_id, $remuneration, $payment_id);

        // Update the seller's account balance
        $commission->updateSellerAccountBalance($seller_id, $remuneration);
    }
}
?>
