<?php
require("head.php");
require("nav.php");
?>
<link rel="stylesheet" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to load file list via AJAX
        function loadFileList(directory) {
            $.ajax({
                url: "get_files.php",
                method: "GET",
                data: { directory: directory },
                success: function(response) {
                    $("#file-list").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading file list:", error);
                    $("#file-list").html("<li>Error loading file list. Please try again.</li>");
                }
            });
        }

        // Initial load of file list with default directory
        loadFileList("");

        // Change event handler for directory dropdown
        $("#directory-dropdown").on("change", function() {
            var directory = $(this).val();
            loadFileList(directory);
        });

        // Function to load file content into edit box via AJAX
        function loadFileContent(file) {
            $.ajax({
                url: "edit_file.php",
                method: "GET",
                data: { file: file },
                success: function(response) {
                    $("#edit-box").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading file content:", error);
                    $("#edit-box").html("Error loading file content. Please try again.");
                }
            });
        }

        // Click event handler for file links
        $("#file-list").on("click", "li a", function(e) {
            e.preventDefault();
            var file = $(this).text();
            loadFileContent(file);
        });

        // Form submission handler for saving file content
        $("#edit-box").on("submit", "form", function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "save_file.php",
                method: "POST",
                data: formData,
                success: function(response) {
                    console.log(response);
                    // Optionally, you can show a success message or perform any other action
                },
                error: function(xhr, status, error) {
                    console.error("Error saving file content:", error);
                    // Optionally, you can display an error message to the user
                }
            });
        });
    });
</script>
</head>
<body>
<main>
    <div class="container">
        <div class="column column1">
            <section>
                <h2>Select Directory</h2>
                <select id="directory-dropdown">
                    <option value="">Select directory</option>
                    <?php
                    // Specify the absolute path to the main root directory
                    $main_root_directory = "../../"; // Change this to the absolute path of your main root directory
                    
                    // List available directories from the main root directory
                    $directories = array_filter(glob($main_root_directory . "/*"), 'is_dir');
                    if (empty($directories)) {
                        echo "<option value=''>No directories found</option>";
                    } else {
                        foreach ($directories as $dir) {
                            // Get the directory name without the root path
                            $dir_name = basename($dir);
                            echo "<option value='$dir_name'>$dir_name</option>";
                        }
                    }
                    ?>
                </select>
            </section>
            <section>
                <ul class="menu-section" id="file-list"></ul>
            </section>
        </div>
        <div class="column column2">
            <section id="edit-box"></section>
        </div>
    </div>
</main>
<?php    
require("foot.html");
?>