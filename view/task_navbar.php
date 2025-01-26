<?php
// Fetch projects the seller created
$created_projects = fetchProjectsBySeller($seller_id);

// Fetch projects the seller is a member of
$member_projects = fetchJoinedProjects($seller_id); // Updated query to use getJoinedProjects
?>

<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<div class="col-md-3">
    <div class="card shadow-sm">
        <div class="card-header text-center bg-primary text-white">
            <h4>Navigation</h4>
        </div>
        <div class="card-body">
            <!-- General Links -->
            <div class="mb-4">
                <h5 class="text-primary">General</h5>
                <ul class="list-unstyled pl-3">
                    <li><a href="seller_profile.php" class="text-dark">My Profile</a></li>
                    <li><a href="seller_dashboard.php" class="text-dark">Dashboard</a></li>
                    <li><a href="../actions/logout.php" class="text-dark">Logout</a></li>
                </ul>
            </div>

            <!-- Created Projects -->
            <div class="mb-4">
                <h5 class="text-primary">Created Projects</h5>
                <ul class="list-unstyled">
                    <?php if ($created_projects): ?>
                        <?php foreach ($created_projects as $index => $project): ?>
                            <li>
                                <a class="text-dark" data-toggle="collapse" href="#createdProject<?php echo $index; ?>" role="button" aria-expanded="false" aria-controls="createdProject<?php echo $index; ?>">
                                    <i class="fas fa-folder-open"></i> <?php echo htmlspecialchars($project['project_title']); ?>
                                </a>
                                <div class="collapse pl-3 mt-2" id="createdProject<?php echo $index; ?>">
                                    <ul class="list-unstyled">
                                        <li><a href="task_management.php?project_id=<?php echo $project['project_id']; ?>" class="text-muted">Task Management</a></li>
                                        <li><a href="role_management.php?project_id=<?php echo $project['project_id']; ?>" class="text-muted">Role Management</a></li>
                                        <li><a href="publish_project.php?project_id=<?php echo $project['project_id']; ?>" class="text-muted">Publish Project</a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted pl-3">No created projects.</p>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Member Projects -->
            <div class="mb-4">
                <h5 class="text-primary">Member Projects</h5>
                <ul class="list-unstyled">
                    <?php if ($member_projects): ?>
                        <?php foreach ($member_projects as $index => $project): ?>
                            <li>
                                <a class="text-dark" data-toggle="collapse" href="#memberProject<?php echo $index; ?>" role="button" aria-expanded="false" aria-controls="memberProject<?php echo $index; ?>">
                                    <i class="fas fa-users"></i> <?php echo htmlspecialchars($project['project_title']); ?>
                                </a>
                                <div class="collapse pl-3 mt-2" id="memberProject<?php echo $index; ?>">
                                    <ul class="list-unstyled">
                                        <li><a href="task_management.php?project_id=<?php echo $project['project_id']; ?>" class="text-muted">Task Management</a></li>
                                        <li><a href="role_management.php?project_id=<?php echo $project['project_id']; ?>" class="text-muted">Role Management</a></li>
                                        <li><a href="#?project_id=<?php echo $project['project_id']; ?>" class="text-muted">Project Overview</a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted pl-3">No member projects.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
