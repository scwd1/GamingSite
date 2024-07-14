document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('login-form').addEventListener('submit', function(event) {
        event.preventDefault();
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var fingerprint = '';

        // Check if fingerprint authentication is supported
        if (window.PasswordCredential && typeof window.PasswordCredential === 'function') {
            // Request fingerprint authentication
            navigator.credentials.get({
                password: true
            }).then(function(credential) {
                fingerprint = credential ? credential.id : '';
                login(username, password, fingerprint);
            }).catch(function(error) {
                console.error('Error getting credential:', error);
                login(username, password, fingerprint);
            });
        } else {
            login(username, password, fingerprint);
        }
    });

    // Event listener for the "Scan Fingerprint" button
    document.getElementById('fingerprint').addEventListener('click', function() {
        // Request fingerprint authentication
        navigator.credentials.get({
            password: true
        }).then(function(credential) {
            var fingerprint = credential ? credential.id : '';
            // Do something with the fingerprint (optional)
            console.log('Fingerprint:', fingerprint);
        }).catch(function(error) {
            console.error('Error getting credential:', error);
        });
    });

    // Function to handle login
    function login(username, password, fingerprint = '') {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php', true);
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
        var data = 'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password) + '&fingerprint=' + encodeURIComponent(fingerprint);
        xhr.send(data);
    }
});