<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?=ROOT?>">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <!-- check if authenticated -->
    <?php ?>
    <div class="my-2 my-lg-0">
      <div class="auth_section">
        <div class="login">
          <a href="javascript:void(0)"><?=(isset($_SESSION['UserEmail'])) ? $_SESSION['UserEmail'] : '' ?></a>
        </div>
        <div class="register">
          <a href="javascript:void(0)" id="logout_user" class="btn btn-danger btn-sm" tabindex="-1">Logout</a>
        </div>
      </div>
    </div>

  </div>
</nav>