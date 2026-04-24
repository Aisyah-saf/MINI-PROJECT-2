<?php 
include 'db.php'; 
include 'header.php'; 

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}
?>

<style>
body {
    background: linear-gradient(135deg, #eef2f3, #dfe9f3);
    min-height: 100vh;
}

.welcome-text {
    font-weight: 700;
    color: #333;
}

.search-box {
    border-radius: 50px;
    padding: 15px 20px;
    font-size: 16px;
    transition: 0.3s;
}

.search-box:focus {
    box-shadow: 0 0 15px rgba(0,123,255,0.2);
    border: none;
}

.card {
    border-radius: 15px;
    transition: 0.3s;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.card-title {
    font-size: 18px;
}

.card-text {
    min-height: 60px;
}

.card-footer {
    background: transparent;
}

.btn {
    border-radius: 30px;
    transition: 0.3s;
}

.btn:hover {
    transform: scale(1.05);
}

.header-box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}
</style>

<div class="container mt-5">

    <!-- HEADER -->
    <div class="header-box text-center mb-5">
        <h2 class="welcome-text mb-2">
            Welcome <?= htmlspecialchars($_SESSION['user_name']) ?>!
        </h2>
        <p class="text-muted">Manage and explore assignments easily</p>
    </div>

    <!-- SEARCH -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <input type="text" id="live_search" 
                   class="form-control search-box shadow-sm border-0" 
                   placeholder="🔍 Search for assignments...">
        </div>
    </div>

    <!-- DISPLAY -->
    <div id="display_area" class="row text-start"></div>

</div>

<script>
const searchInput = document.getElementById('live_search');
const displayArea = document.getElementById('display_area');

// role dari PHP
const userRole = "<?= $_SESSION['role'] ?>"; 

// LOAD DATA
function loadData(query = '') {
    fetch(`search_ajax.php?q=${query}`)
    .then(response => response.json())
    .then(data => {

        if(data.length === 0) {
            displayArea.innerHTML = `
                <div class="col-12 text-center text-muted">
                    <p>No assignments found.</p>
                </div>`;
            return;
        }

        displayArea.innerHTML = data.map(item => {

            let buttons = '';

            if(userRole === 'admin') {
                buttons = `
                    <a href="create_assignment.php" 
                       class="btn btn-sm btn-primary w-100 mb-2">
                       Create Task
                    </a>

                    <button onclick="delete_assignment(${item.id})" 
                            class="btn btn-sm btn-danger w-100">
                        Delete
                    </button>
                `;
            } else {
                buttons = `
                    <a href="submit_assignment.php?id=${item.id}" 
                       class="btn btn-sm btn-success w-100">
                       Submit Task
                    </a>
                `;
            }

            return `
            <div class="col-md-4 mb-4 d-flex">
                <div class="card w-100 shadow-sm border-0 d-flex flex-column">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-primary mb-2">
                            ${item.title}
                        </h5>

                        <p class="card-text text-muted flex-grow-1">
                            ${item.description}
                        </p>
                    </div>

                    <div class="card-footer px-3 pb-3 mt-auto">
                        ${buttons}
                    </div>

                </div>
            </div>
            `;
        }).join('');
    })
    .catch(err => console.log(err));
}

// DELETE FUNCTION
function delete_assignment(id) {
    if(confirm("Delete this assignment?")) {
        fetch("delete_assignment.php?id=" + id)
        .then(res => res.text())
        .then(data => {
            alert("Deleted successfully!");
            loadData(); // refresh
        })
        .catch(err => console.log(err));
    }
}

// LIVE SEARCH
searchInput.addEventListener('input', () => {
    loadData(searchInput.value);
});

// LOAD FIRST TIME
window.onload = () => loadData();
</script>

<?php include 'footer.php'; ?>