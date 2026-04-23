<?php  
include 'db.php';  

// Ensure session_start() is inside db.php or header.php 
include 'header.php';  
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit();
} 

?> 
<style> 
    body { background: linear-gradient(135deg, #eef2f3, #dfe9f3); min-height: 100vh; } 
    .welcome-text { font-weight: 700; color: #333; } 
    .search-box { border-radius: 50px; padding: 15px 20px; transition: 0.3s; } 
    .card { border-radius: 15px; transition: 0.3s; overflow: hidden; border: none; } 
    .card:hover { transform: translateY(-8px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); } 
    .header-box { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); } 
</style> 

<div class="container mt-5"> 
    <div class="header-box text-center mb-5"> 
        <h2 class="welcome-text mb-2">Welcome <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2> 
        <p class="text-muted">Manage and explore assignments easily</p> 
    </div> 
    <div class="row justify-content-center mb-5"> 
        <div class="col-md-6"> 
            <input type="text" id="live_search" class="form-control search-box shadow-sm" placeholder="🔍 Search for assignments..."> 
        </div> 
    </div> 
    <div id="display_area" class="row text-start"></div> 
</div> 

<script> 
const searchInput = document.getElementById('live_search'); 
const displayArea = document.getElementById('display_area'); 
const userRole = "<?= $_SESSION['role'] ?>";  

const loadData = (query = '') => { 
    fetch(`search_ajax.php?q=${encodeURIComponent(query)}`) 
    .then(response => response.json()) 
    .then(data => { 
        if(data.length === 0) { 
            displayArea.innerHTML = '<div class="col-12 text-center text-muted"><p>No assignments found.</p></div>'; 
            return; 
        } 

        displayArea.innerHTML = data.map(item => { 
            let actionButton = (userRole === 'admin')  
                ? `<a href="create_assignment.php" class="btn btn-sm btn-primary w-100">Create Task</a>` 
                : `<a href="submit_assignment.php?id=${item.id}" class="btn btn-sm btn-success w-100">Submit Task</a>`; 
            return ` 
            
            <div class="col-md-4 mb-4"> 
                <div class="card h-100 shadow-sm"> 
                    <div class="card-body"> 
                        <h5 class="card-title fw-bold text-primary">${item.title}</h5> 
                        <p class="card-text text-muted">${item.description}</p> 
                    </div> 
                    <div class="card-footer px-3 pb-3">${actionButton}</div> 
                </div> 
            </div>`; 
        }).join(''); 
    }); 
}; 

  

searchInput.addEventListener('input', () => loadData(searchInput.value)); 
window.onload = () => loadData(); 

</script> 
<?php include 'footer.php'; ?> 