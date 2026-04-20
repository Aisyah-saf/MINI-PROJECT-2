<?php include 'config.php'; include 'header.php'; 
if(!isset($_SESSION['user_id'])) header("Location: login.php"); ?>

<div class="container text-center mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            
            <h2 class="fw-bold mb-4">Welcome <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
            
            <hr class="w-25 mx-auto mb-5">


            
            <div class="row justify-content-center mb-5">
                <div class="col-md-7">
                    <input type="text" id="live_search" class="form-control form-control-lg shadow-sm border-0" 
                           placeholder="Search for assignments..." style="background-color: #fff;">
                </div>
            </div>
            
            <div id="display_area" class="row text-start">
                </div>

        </div>
    </div>
</div>

<script>
const searchInput = document.getElementById('live_search');
const displayArea = document.getElementById('display_area');

// Role-based logic for JavaScript (fetched from PHP session)
const userRole = "<?= $_SESSION['role'] ?>"; 

const loadData = (query = '') => {
    fetch(`search_ajax.php?q=${query}`)
    .then(response => response.json())
    .then(data => {
        if(data.length === 0) {
            displayArea.innerHTML = '<div class="col-12 text-center text-muted"><p>No assignments found.</p></div>';
            return;
        }

        displayArea.innerHTML = data.map(item => {
            // Determine the button based on role
            let actionButton = '';
            if(userRole === 'admin') {
                actionButton = `<a href="create_assignment.php" class="btn btn-sm btn-primary w-100 py-2 fw-semibold">Create Task</a>`;
            } else {
                actionButton = `<a href="submit_assignment.php?id=${item.id}" class="btn btn-sm btn-success w-100 py-2 fw-semibold">Submit Task</a>`;
            }

            return `
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-success mb-2">${item.title}</h5>
                        <p class="card-text text-muted" style="font-size: 0.9rem;">${item.description}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        ${actionButton}
                    </div>
                </div>
            </div>
            `;
        }).join('');
    });
};