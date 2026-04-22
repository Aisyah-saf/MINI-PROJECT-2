<?php
include 'db.php'; 
include 'header.php';

// Check login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch submissions
if($role == 'admin') {
    $stmt = $conn->prepare("SELECT users.name as student, assignments.title, submissions.file 
                            FROM submissions 
                            JOIN users ON submissions.user_id = users.id 
                            JOIN assignments ON submissions.assignment_id = assignments.id");
} else {
    $stmt = $conn->prepare("SELECT assignments.title, submissions.file 
                            FROM submissions 
                            JOIN assignments ON submissions.assignment_id = assignments.id 
                            WHERE submissions.user_id = ?");
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0 p-4">
        <h3 class="fw-bold mb-4">Submission History</h3>

        <div class="table-responsive">
            <table class="table table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <?php if($role == 'admin') echo "<th>Student</th>"; ?>
                        <th>Assignment Title</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if($res->num_rows > 0): ?>
                        <?php while($row = $res->fetch_assoc()): ?>
                        <tr>
                            <?php if($role == 'admin'): ?>
                                <td class="align-middle"><?= htmlspecialchars($row['student']) ?></td>
                            <?php endif; ?>

                            <td class="align-middle"><?= htmlspecialchars($row['title']) ?></td>

                            <td class="text-center">
                                <a href="uploads/<?= htmlspecialchars($row['file']) ?>" 
                                   class="btn btn-sm btn-success px-3" download>
                                   Download File
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">No submissions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
        </div>

    </div>
</div>

<?php 
include 'footer.php'; 
?>