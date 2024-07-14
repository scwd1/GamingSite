document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        login(username, password);
    });

    // Function to handle login
    function login(username, password) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../login.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = 'dashboard.php';
                } else {
                    document.getElementById('error-message').textContent = response.message;
                }
            }
        };
        var data = 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password);
        xhr.send(data);
    }
});