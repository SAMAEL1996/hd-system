<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a href="admin-page.php" class="navbar-brand fs-3" style="font-family: 'Montserrat', sans-serif; color: #FCF55F">MINDWAVES</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="" id="navbarNav" style="float: right">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><?php echo $user->name; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>