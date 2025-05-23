<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand" href="?command=welcome">CS 4640 Chess</a>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <?php if (isset($_SESSION["user_id"])) { ?>
                <li class="nav-item">
                <a class="nav-link" href="?command=logout">Log Out</a>
              </li>
                <li class="nav-item">
                <a class="nav-link" href="?command=leaderboard">Leaderboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?command=savedGames">My Games</a>
              </li>
              <?php } else { ?>
                <li class="nav-item">
                  <a class="nav-link" href="?command=logout">Log In</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="?command=registerPage">Register</a>
              </li>
              <?php } ?>
              </li>  
            
            </ul>
          </div>
        </div>
      </nav>