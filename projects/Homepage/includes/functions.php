<?php
session_start();
require("linkdir.php");

function IsLoggedIn($user_id) {
    if (isset($_SESSION['user_id'])) {
        return 1;
    }
}
function LoginCheck() {
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function GetUserAvatar($conn, $user_id) {
    // Prepare and execute SQL query to retrieve the avatar for the given user ID
    $sql = "SELECT avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists and has an avatar
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $avatar = $user['avatar'];
    } else {
        // Default avatar path if user doesn't exist or doesn't have an avatar
        $avatar = 'default_avatar.png'; // Change this to the path of your default avatar image
    }
    
    // Close database connection
    $stmt->close();
    
    return $avatar;
}

function GetUsername($conn, $user_id) {
    // Prepare and execute SQL query to retrieve the username for the given user ID
    $sql = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists and has a username
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];
    } else {
        // Default username if user doesn't exist
        $username = 'Unknown'; // Change this to the default username you want to use
    }
    
    // Close database connection
    $stmt->close();
    
    return $username;
}

function GetUserID($conn, $username) {
    // Prepare and execute SQL query to retrieve the user ID for the given username
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // "s" for string parameter
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userid = $user['id'];
    } else {
        // Default user ID if user doesn't exist
        $userid = null; // Change this to the default user ID you want to use
    }
    
    // Close database connection
    $stmt->close();
    
    return $userid;
}

function BuildNav($conn, $user_id) {
    $links = array();
    $sql = "SELECT URL, text, logged, admin FROM navbar_links";

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Check if the link should be displayed based on user login status and admin level
            if (($row['logged'] == 1 && LoginCheck($user_id)) || 
                ($row['admin'] == 1 && GetAdminLevel($user_id, $conn) > 0) || 
                ($row['logged'] == 0 && $row['admin'] == 0)) {
                $links[] = $row;
            }
        }
        $result->free(); // Free result set before closing the connection
    } else {
        echo "Error: " . $conn->error;
    }
    // Construct HTML output
    $html = '';
    foreach ($links as $link) {
        $url = htmlspecialchars($link['URL']);
        $text = htmlspecialchars($link['text']);
        $html .= "<a href=\"$url\">$text</a>\n";
    }
    return $html;
}

function BuildNav2($conn) {
    $links = array();
    $sql = "SELECT URL, text, logged, admin FROM navbar_links";

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $links[] = $row;
        }
        $result->free();
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();

    // Construct HTML output
    $html = '';
    foreach ($links as $link) {
        $url = htmlspecialchars($link['URL']);
        $text = htmlspecialchars($link['text']);
        $html .= "<a href=\"$url\">$text</a>\n";
    }
    return $html;
}

function setRememberMeCookie($userId) {
    $token = bin2hex(random_bytes(16)); // Generate a random token
    $expiry = time() + (30 * 24 * 60 * 60); // 30 days expiry
    setcookie('remember_me', $userId . ':' . $token, $expiry, '/');
}

// Function to clear the remember me cookie
function clearRememberMeCookie() {
    setcookie('remember_me', '', time() - 3600, '/'); // Expire immediately
}

function authenticateUser($username, $password) {
    global $conn;
    // SQL injection prevention
    $username = mysqli_real_escape_string($conn, $username);

    // Prepare SQL query to fetch user from database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, verify password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user; // Return user information
        }
    }
    return false;
}
/* ******************************************
/* ------------------------------------------
/*       Testing new functions below added
/*       4/17/2024
/*       Below functions are experimental!
/* ------------------------------------------
/* ******************************************/
// Function to display user rank based on level and helper status
function UserRank($level, $helper, $username) {
    if ($level == 1) { 
        $ruser = "<span style='color:yellow;font-weight:bolder'>" . $username . "</span>"; 
    } elseif ($helper >= 2) { 
        $ruser = "<span style='color:#00f4f4;font-weight:bolder'>" . $username . "</span>"; 
    } elseif ($level == 2 || $level == 3) { 
        $ruser = "<span style='color:lime;font-weight:bolder'>" . $username . "</span>"; 
    } elseif ($level == 4) { 
        $ruser = "<span style='color:sandybrown;font-weight:bolder'>" . $username . "</span>"; 
    } elseif ($level == 1337) { 
        $ruser = "<span style='color:red;font-weight:bolder'>" . $username . "</span>"; 
    } elseif ($level == 1338 || $level == 99999) { 
        $ruser = "<span style='color:#298eff;font-weight:bolder'>" . $username . "</span>"; 
    } elseif ($level == 0 && $helper < 2) { 
        $ruser = "<span style='color:white;font-weight:bolder'>" . $username . "</span>"; 
    } else {
        // Default case if none of the conditions are met
        $ruser = $username;
    }
    return $ruser;
}

// Function to display admin rank based on admin level
function aRank($inf) {
    $rank = "";
    switch ($inf['AdminLevel']) {
        case 1:
            $rank = '<font color="Yellow">Server Moderator</font>';
            break;
        case 2:
            $rank = '<font color="Lime">Junior Admin</font>';
            break;
        case 3:
            $rank = '<font color="Lime">General Admin</font>';
            break;
        case 4:
            $rank = '<font color="SandyBrown">Senior Admin</font>';
            break;
        case 1337:
            $rank = '<font color="Red">Head Admin</font>';
            break;
        case 1338:
            $rank = '<font color="#298eff">Lead Head Admin</font>';
            break;
        case 99999:
            $rank = '<font color="#298eff">Executive Admin</font>';
            break;
        default:
            $rank = "Unknown";
    }
    return $rank;
}

// Function to display VIP rank based on VIP level
function VIPrank($viprank) {
    switch ($viprank) {
        case 0:
            return "None";
        case 1:
            return "Bronze";
        case 2:
            return "Silver";
        case 3:
            return "Gold";
        case 4:
            return "Platinum";
        case 5:
            return "VIP Moderator";
        default:
            return "Unknown";
    }
}

// Function to display last online status of a user
function LastOnline($userid, $mysqli) {
    $query = $mysqli->prepare("SELECT `LastLogin` FROM `accounts` WHERE `id` = ?");
    $query->bind_param("i", $userid);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();
    $query->close();

    if (!$result) {
        return "Unknown";
    }

    $lastLogin = strtotime($result['LastLogin']);
    $currentTime = time();
    $difference = $currentTime - $lastLogin;
    $days = floor($difference / (60 * 60 * 24));

    if ($days == 0) {
        return "<span style='color:green'>" . date("M j, o - g:iA", $lastLogin) . "</span>";
    } elseif ($days >= 1 && $days < 7) {
        return "<span style='color:blue'>" . date("M j, o - g:iA", $lastLogin) . "</span>";
    } elseif ($days >= 7 && $days < 14) {
        return "<span style='color:gold'>" . date("M j, o - g:iA", $lastLogin) . "</span>";
    } elseif ($days >= 14 && $days < 30) {
        return "<span style='color:orange'>" . date("M j, o - g:iA", $lastLogin) . "</span>";
    } elseif ($days >= 30) {
        return "<span style='color:red'>" . date("M j, o - g:iA", $lastLogin) . "</span>";
    } else {
        return "Unknown";
    }
}

// Function to check if a username exists in the database
function CheckName($username, $mysqli) {
    $query = $mysqli->prepare("SELECT `id` FROM `accounts` WHERE `Username` = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $name = $result->num_rows;
    $query->close();
    return $name;
}

// Function to get the username based on user ID
function GetName($id, $mysqli) {
    $query = $mysqli->prepare("SELECT `Username` FROM `accounts` WHERE `id` = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $username = $result->fetch_assoc();
    $query->close();
    return $username['Username'] ?? "Unknown";
}

// Function to get the user ID based on username
function GetID($name, $mysqli) {
    $query = $mysqli->prepare("SELECT `id` FROM `accounts` WHERE `Username` = ?");
    $query->bind_param("s", $name);
    $query->execute();
    $result = $query->get_result();
    $id = $result->fetch_assoc();
    $query->close();
    return $id['id'] ?? null;
}

// Function to get the last IP address used by the user
function GetLastIP($id, $mysqli) {
    $query = $mysqli->prepare("SELECT `IP` FROM `accounts` WHERE `id` = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $ip = $result->fetch_assoc();
    $query->close();
    return $ip['IP'] ?? null;
}

// Function to check if a user is currently online
function IsPlayerOnline($userid, $mysqli) {
    $query = $mysqli->prepare("SELECT `Online` FROM `accounts` WHERE `id` = ?");
    $query->bind_param("i", $userid);
    $query->execute();
    $result = $query->get_result();
    $online = $result->fetch_assoc();
    $query->close();
    return $online['Online'] ??
    null;
}

function GetAdminLevel($userid, $conn) {
    $query = $conn->prepare("SELECT `admin` FROM `users` WHERE `id` = ?");
    $query->bind_param("i", $userid);
    $query->execute();
    $query->bind_result($adminLevel);
    $query->fetch();
    $query->close();
    return $adminLevel;
}

// Function to get the admin level of a user
function GetAdminLevel2($userid, $conn) {
    $query = $conn->prepare("SELECT `admin` FROM `users` WHERE `id` = ?");
    $query->bind_param("i", $userid);
    $query->execute();
    $result = $query->get_result();
    $adminLevel = $result->fetch_assoc();
    $query->close();
    return $adminLevel['admin'] ?? null;
}

// Function to get the helper level of a user
function GetHelperLevel($userid, $mysqli) {
    $query = $mysqli->prepare("SELECT `Helper` FROM `accounts` WHERE `id` = ?");
    $query->bind_param("i", $userid);
    $query->execute();
    $result = $query->get_result();
    $helperLevel = $result->fetch_assoc();
    $query->close();
    return $helperLevel['Helper'] ?? null;
}

// Function to check if a user is disabled
function IsDisabled($userid, $mysqli) {
    $query = $mysqli->prepare("SELECT `Disabled` FROM `accounts` WHERE `id` = ?");
    $query->bind_param("i", $userid);
    $query->execute();
    $result = $query->get_result();
    $disabled = $result->fetch_assoc();
    $query->close();
    return $disabled['Disabled'] ?? null;
}

// Directory where logs are stored
$logdir = "/home/samp/main/scriptfiles/cplogs/";

// Function to log actions
function LogFile($directory, $filename, $content) {
    $content = "[" . date('Y-m-d H:i:s') . "] " . $content . "\r\n";
    $file = $directory . $filename;

    if (is_writable($file)) {
        $handle = fopen($file, 'a');
        if (!$handle) {
            echo "Cannot open file ($filename)";
            exit;
        }
        if (!fwrite($handle, $content)) {
            echo "Cannot write to file ($filename)";
            exit;
        }
        fclose($handle);
    } else {
        echo "The file $filename is not writable";
    }
}

// Function to log actions in the control panel
function doLog($user, $section, $area, $details, $mysqli) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d H:i:s');
    $logquery = "";
    switch ($section) {
        case "General":
            $logquery = "INSERT INTO `cp_log_general` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, ?, ?, ?, ?, ?)";
            break;
        case "Staff":
            $logquery = "INSERT INTO `cp_log_staff` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, ?, ?, ?, ?, ?)";
            break;
        case "Customer Relations":
            $logquery = "INSERT INTO `cp_log_cr` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, ?, ?, ?, ?, ?)";
            break;
        case "Faction":
            $logquery = "INSERT INTO `cp_log_faction` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, ?, ?, ?, ?, ?)";
            break;
        case "Family":
            $logquery = "INSERT INTO `cp_log_family` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, ?, ?, ?, ?, ?)";
            break;
    }
    $stmt = $mysqli->prepare($logquery);
    if (!$stmt) {
        die('Error preparing statement: ' . $mysqli->error);
    }
    $stmt->bind_param("sissi", $date, $user, $area, $details, $ip);
    $stmt->execute();
    $stmt->close();
}

/* function generateRandomString(length) {
  var result = '';
  var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
} */
?>