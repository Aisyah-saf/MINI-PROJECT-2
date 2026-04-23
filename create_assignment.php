<?php 
include 'db.php'; include 'header.php';
if($_SESSION['role'] != 'admin') header("Location: dashboard.php");

if(isset($_POST['create'])) {
    $stmt = $conn->prepare("INSERT INTO assignments (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['title'], $_POST['desc']);
    $stmt->execute();
    echo "<div class='alert alert-success text-center fw-bold mt-3'>Assignment Created!</div>";
}
?>

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
        min-height: 100vh;
    }

    .form-card {
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 30px;
    }

    .title {
        font-weight: 700;
        color: #333;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px;
    }

    textarea.form-control {
        resize: none;
    }

    .btn-custom {
        border-radius: 30px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: #fff;
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-custom:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    .icon {
        font-size: 35px;
        color: #764ba2;
    }
</style>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="col-md-8">

        <div class="form-card">

            <div class="text-center mb-4">
                <h3 class="title">Post New Assignment</h3>
                <p class="text-muted">Create and publish tasks for students</p>
            </div>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Task Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter task title..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Task Instructions</label>
                    <textarea name="desc" class="form-control" rows="4" placeholder="Enter instructions..."></textarea>
                </div>

                <button name="create" class="btn btn-custom w-100">
                     Publish Assignment
                </button>

            </form>

        </div>

    </div>
</div>

<?php include 'footer.php'; ?>