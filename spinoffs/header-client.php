<nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark bg-dark navbar-fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand fs-3" style="font-family: 'Montserrat', sans-serif; color: #FCF55F" href="client-page.php">MINDWAVES</a>
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

<script>
document.addEventListener("DOMContentLoaded", function(){
  window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        document.getElementById('navbar_top').classList.add('fixed-top');
        // add padding top to show content behind navbar
        navbar_height = document.querySelector('.navbar').offsetHeight;
        document.body.style.paddingTop = navbar_height + 'px';
      } else {
        document.getElementById('navbar_top').classList.remove('fixed-top');
         // remove padding top from body
        document.body.style.paddingTop = '0';
      } 
  });
}); 
</script>