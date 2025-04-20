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