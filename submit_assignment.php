<div class="card-box col-md-6 mx-auto">

    <h3 class="text-center mb-4">Submit Assignment</h3>

    <?= $message; ?>

    <form action="submit_assignment.php?id=<?= htmlspecialchars($assignment_id) ?>" 
          method="POST" 
          enctype="multipart/form-data">

        <!-- SELECT ASSIGNMENT -->
        <div class="mb-3">
            <select name="assignment_id" class="form-control">
                <?php
                $res = $conn->query("SELECT * FROM assignments");
                while($row = $res->fetch_assoc()){
                    $selected = ($row['id'] == $assignment_id) ? "selected" : "";
                    echo "<option value='{$row['id']}' $selected>{$row['title']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- FILE INPUT -->
        <div class="mb-3">
            <input type="file" name="doc" class="form-control" required>
        </div>

        <!-- BUTTON -->
        <button name="upload" class="btn btn-primary">Submit</button>

    </form>

</div>