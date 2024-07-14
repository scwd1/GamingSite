
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <div class="container">
        <div class="sidebar" id="sidebar">
            <!-- Left links will be dynamically loaded here -->
            <!-- Default left links can be static -->
            <ul>
                <li><a href="#" class="left-link" onclick="loadPage('admin.php')">Overview</a></li>
                <li><a href="#" class="left-link" onclick="loadPage('apages.php')">Edit Pages</a></a></li>
            </ul>
        </div>
        <div class="content" id="content-area">
            <!-- Main content area will be dynamically loaded here -->
        </div>
    </div>

    <script>
        // Function to load pages using Ajax
        function loadPage(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content-area").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", page, true);
            xhttp.send();

            // Update left links based on selected page
            updateLinks(page);
        }

        // Function to update left links based on selected page
        function updateLinks(page) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("sidebar").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get_links.php?page=" + page, true);
            xhttp.send();
        }
    </script>
</body>
</html>