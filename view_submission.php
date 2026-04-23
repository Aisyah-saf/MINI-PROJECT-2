<?php 
include 'db.php'; 
include 'header.php';

//Make sure the user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Query needs to retrieve 'id' from table submissions for Edit & Delete process
if($role == 'admin') {
    $stmt = $conn->prepare("SELECT submissions.id, users.name as student, assignments.title, submissions.file 
                            FROM submissions 
                            JOIN users ON submissions.user_id = users.id 
                            JOIN assignments ON submissions.assignment_id = assignments.id");
} else {
    $stmt = $conn->prepare("SELECT submissions.id, assignments.title, submissions.file 
                            FROM submissions 
                            JOIN assignments ON submissions.assignment_id = assignments.id 
                            WHERE submissions.user_id = ?");
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$res = $stmt->get_result();
?>

<style>
    body { background: linear-gradient(135deg, #eef2f3, #dfe9f3); min-height: 100vh; }
    .history-card { border-radius: 20px; background: #ffffff; box-shadow: 0 10px 30px rgba(0,0,0,0.15); padding: 25px; }
    .title { font-weight: 700; color: #333; }
    .table thead { background: linear-gradient(45deg, #343a40, #212529); color: white; }
    .table tbody tr { transition: 0.3s; }
    .table tbody tr:hover { background-color: #f8f9fa; transform: scale(1.005); }
    
    /* Button Styles */
    .btn-action { border-radius: 20px; padding: 5px 12px; font-size: 13px; border: none; transition: 0.3s; color: white; text-decoration: none; display: inline-block; }
    .btn-download { background: linear-gradient(45deg, #28a745, #20c997); }
    .btn-edit { background: linear-gradient(45deg, #ffc107, #ff9800); color: #212529; }
    .btn-delete { background: linear-gradient(45deg, #dc3545, #c82333); }
    .btn-action:hover { transform: scale(1.1); color: white; opacity: 0.9; }
</style>

<div class="container mt-5">
    <div class="history-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="title mb-0">Submission History</h3>
                <small class="text-muted">
                    <?= ($role == 'admin') ? "Review student submissions" : "Manage your submitted assignments"; ?>
                </small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mt-3 text-center">
                <thead>
                    <tr>
                        <?php if($role == 'admin') echo "<th>Student</th>"; ?>
                        <th class="text-start">Assignment Title</th>
                        <th>File</th>
                        <?php if($role == 'student'): ?>
                            <th>Manage</th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php if($res->num_rows > 0): ?>
                        <?php while($row = $res->fetch_assoc()): ?>
                        <tr>
                            <?php if($role == 'admin') echo "<td class='fw-bold'>".htmlspecialchars($row['student'])."</td>"; ?>
                            
                            <td class="text-start"><?= htmlspecialchars($row['title']) ?></td>

                            <td>
                                <a href="uploads/<?= htmlspecialchars($row['file']) ?>" class="btn-action btn-download" download>
                                    ⬇ Download
                                </a>
                            </td>

                            <?php if($role == 'student'): ?>
                            <td>
                                <a href="edit_submission.php?id=<?= $row['id'] ?>" class="btn-action btn-edit me-1">
                                    ✏ Edit
                                </a>
                                <a href="delete_submission.php?id=<?= $row['id'] ?>" 
                                   class="btn-action btn-delete" 
                                   onclick="return confirm('Are you sure you want to delete this task?')">
                                    🗑 Delete
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No submissions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-end">
            <a href="dashboard.php" class="btn btn-secondary btn-sm" style="border-radius: 20px;">
                ← Back to Dashboard
            </a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>