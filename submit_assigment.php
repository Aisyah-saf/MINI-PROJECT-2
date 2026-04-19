<?php include 'header.php'; ?>

<div class="card-box">

    <h3 class="text-center mb-4">Submit Assignment</h3>

    <form method="POST" enctype="multipart/form-data">

        <!-- Dropdown Assignment -->
        <select name="assignment_id" class="form-control mb-3">
            <?php
            $res = $conn->query("SELECT * FROM assignments");
            while($row = $res->fetch_assoc()){
                echo "<option value='".$row['id']."'>".$row['title']."</option>";
            }
            ?>
        </select>

        <!-- File Upload -->
        <input type="file" name="file" class="form-control mb-3">

        <button class="btn btn-primary">Submit</button>

    </form>

</div>

<?php include 'footer.php'; ?>