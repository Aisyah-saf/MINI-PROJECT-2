<?php 
include 'db.php'; 
include 'header.php';

// Pastikan user sudah login
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Nota: Jika ralat masih berlaku, sila semak nama kolum dalam pangkalan data anda (contoh: 'file' atau 'file_path')
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

<style>
    body {
        background: linear-gradient(135deg, #eef2f3, #dfe9f3);
        min-height: 100vh;
    }

    .history-card {
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 25px;
    }

    .title {
        font-weight: 700;
        color: #333;
    }

    .table thead {
        background: linear-gradient(45deg, #343a40, #212529);
        color: white;
    }

    .table tbody tr {
        transition: 0.3s;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
    }

    .btn-success {
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 14px;
        background: linear-gradient(45deg, #28a745, #20c997);
        border: none;
        transition: 0.3s;
    }

    .btn-success:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    .btn-secondary {
        border-radius: 20px;
        padding: 5px 15px;
    }

    .header-icon {
        font-size: 35px;
    }
</style>

<div class="container mt-5">

    <div class="history-card">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="title mb-0">Submission History</h3>
                <small class="text-muted">View and download submitted assignments</small>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mt-3">
                <thead>
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
                            <?php if($role == 'admin') echo "<td>".htmlspecialchars($row['student'])."</td>"; ?>
                            
                            <td>
                                 <?= htmlspecialchars($row['title']) ?>
                            </td>

                            <td class="text-center">
                                <a href="uploads/<?= htmlspecialchars($row['file']) ?>" 
                                   class="btn btn-sm btn-success" download>
                                    ⬇ Download
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                 No submissions found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- BACK BUTTON -->
        <div class="mt-3 text-end">
            <a href="dashboard.php" class="btn btn-secondary btn-sm">
                ← Back to Dashboard
            </a>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>