<?php
include("../controllers/project_controller.php");

if (!isset($_GET['project_id'])) {
    die("Project ID not provided.");
}

$project_id = $_GET['project_id'];
$project = fetchProjectById($project_id);
$members = fetchProjectMembers_ctr($project_id);

if (!$project) {
    die("Project not found.");
}

// Prepare screenshots (only include non-empty ones)
$screenshots = [];
if (!empty($project['sc1'])) $screenshots[] = "../uploads/projects/" . htmlspecialchars($project['sc1']);
if (!empty($project['sc2'])) $screenshots[] = "../uploads/projects/" . htmlspecialchars($project['sc2']);
if (!empty($project['sc3'])) $screenshots[] = "../uploads/projects/" . htmlspecialchars($project['sc3']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($project['project_title']); ?> - Details</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Ensure modal is displayed properly */
        .modal-screenshots .modal-content {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        .modal-screenshots img {
            max-height: 500px;
            width: auto;
            margin: auto;
        }
        .modal-backdrop.show {
            z-index: 1050;
        }
        .modal {
            z-index: 1055; /* Ensure modal is above navbar */
        }
        .navbar {
            z-index: 1030; /* Ensure navbar is below the modal */
        }
    </style>
</head>
<body>
<?php include "navbar.php"; ?>

<div class="container mt-5">
    <h1><?php echo htmlspecialchars($project['project_title']); ?></h1>
    <p><?php echo htmlspecialchars($project['project_desc']); ?></p>
    <p><strong>Price:</strong> $<?php echo number_format($project['project_price'], 2); ?></p>
    <p><strong>Keywords:</strong> <?php echo htmlspecialchars($project['project_keywords']); ?></p>
    <h3>Members:</h3>
    <ul>
        <?php foreach ($members as $member): ?>
            <li><?php echo htmlspecialchars($member['seller_name']) . " (" . htmlspecialchars($member['seller_email']) . ")"; ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="<?php echo htmlspecialchars($project['link']); ?>" class="btn btn-primary">Preview Project</a>

    <!-- View Screenshots Button -->
    <?php if (!empty($screenshots)): ?>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#screenshotsModal">
            View Screenshots
        </button>
    <?php else: ?>
        <p class="mt-3 text-muted">No screenshots available for this project.</p>
    <?php endif; ?>
</div>

<!-- Modal for Screenshots -->
<?php if (!empty($screenshots)): ?>
    <div class="modal fade modal-screenshots" id="screenshotsModal" tabindex="-1" aria-labelledby="screenshotsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="screenshotsModalLabel">Screenshots</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="screenshotsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($screenshots as $index => $screenshot): ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo $screenshot; ?>" class="d-block w-100" alt="Screenshot <?php echo $index + 1; ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#screenshotsCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#screenshotsCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include "footer.php"; ?>
</body>
</html>
