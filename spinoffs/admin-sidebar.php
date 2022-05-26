<style>
    .sidebar {
        height: 100%;
        
    }
    ul li {
        display: block;
    }
    a:hover::before,
    a:focus::before {
        transform: scaleX(1);
    }
    a{
        transition: color 300ms ease-in-out;
        z-index: 1;
    }
    a:hover,
    a:focus {
        color: white;
        text-decoration: none;
    }
</style>

<div id="wrapper">
    <div class="sidebar" style="width: 250px; padding: 0; height: 100%; ">
        <ul class="ps-0">
            <li><a href="admin-page.php" style="text-decoration: none"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="employees.php" style="text-decoration: none"><i class="fa-solid fa-circle-user"></i> Employees</a></li>
            <li><a href="applicants.php" style="text-decoration: none"><i class="fa-solid fa-users"></i> Applicants</a></li>
            <li><a href="history.php" style="text-decoration: none"><i class="fa-solid fa-box-archive"></i> History</a></li>
            <li><a href="schedules.php" style="text-decoration: none"><i class="fa-regular fa-calendar"></i> Status</a></li>
            <li><a href="files.php" style="text-decoration: none"><i class="fa-solid fa-file-arrow-up"></i> Files Uploaded</a></li>
            <li><a href="job_open.php" style="text-decoration: none"><i class="fa-solid fa-door-open"></i> Career Hiring</a></li>
        </ul>
    </div>
</div>