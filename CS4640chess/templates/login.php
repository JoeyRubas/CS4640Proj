<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CS4640 Spring 2025">
    <meta name="description" content="CHess game login">  
    <title>Chess</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"  crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body>
  <?php include 'nav.php'; ?>
    <div class="container" style="margin-top: 15px;">
      <div class="row">
        <div class="col-xs-12">
          <h1>Welcome to CS4640 Chess! Please login or create your account to continue</h1>
        </div>
      </div>
      <?=$message?>
      <div class="row">
        <div class="col-xs-12">
          <form action="?command=login" method="post" id="loginForm">

            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="username" aria-describedby="usernamehelp">
              <div id="usernameHelp" class="form-text">Your username must contain the word chess!</div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Start</button>

          </form>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
      $('#loginForm').on('submit', function (e) {
          const username = $('#name').val().trim();
          const email = $('#email').val().trim();
          const password = $('#password').val().trim();
          let error = '';

          if (!username || !email || !password) {
              error = 'All fields are required.';
          } else if (!username.toLowerCase().includes("chess")) {
              error = 'Username must contain the word "chess".';
          } else if (!/^[a-zA-Z0-9_]+$/.test(username)) {
              error = 'Username must be alphanumeric.';
          } else if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
              error = 'Please enter a valid email address.';
          } else if (password.length < 5) {
              error = 'Password must be at least 5 characters.';
          }

          if (error) {
              e.preventDefault();
              if ($('#error-msg').length === 0) {
                  $('#loginForm').prepend('<div id="error-msg" style="color: red; margin-bottom: 10px;"></div>');
              }
              $('#error-msg').text(error).show();
              $('#name, #email, #password').css('border', '2px solid red');
          }
      });
  </script>
  </body>
</html>
