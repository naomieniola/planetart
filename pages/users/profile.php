<?php
session_start();
require_once "../../config.php";

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Get the current user's information
$currentUser = $_SESSION["user"];
$sql = "SELECT *, IFNULL(profile_picture, 'default-user.png') AS profile_picture FROM users WHERE username = '$currentUser'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$errorMessages = array();

// Get the current user's information
$currentUser = $_SESSION["user"];
$sql = "SELECT * FROM users WHERE username = '$currentUser'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$errorMessages = array();

// Form submissions
if (isset($_POST["updateEmail"])) {
    $email = $_POST["email"];
    if (empty($email)) {
        $errorMessages[] = "Email cannot be empty";
    } elseif ($email === $user['email']) {
        $errorMessages[] = "Email is unchanged";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Email is invalid";
    } else {
        // Check if the email already exists in the database
        $checkQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $errorMessages[] = "Email already exists. Please choose a different email.";
        } else {
            // Update the email if it doesn't exist
            $updateQuery = "UPDATE users SET email = ? WHERE username = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ss", $email, $currentUser);
            mysqli_stmt_execute($stmt);
            $_SESSION["success_message"] = "Email successfully updated.";
            header("Location: profile.php");
            exit();
        }
    }
}

    if (isset($_POST["updateFullname"])) {
        $fullname = $_POST["fullname"];
        if (empty($fullname)) {
            $errorMessages[] = "Full name cannot be empty";
        } elseif ($fullname === $user['full_name']) {
            $errorMessages[] = "Full name is unchanged";
        } else {
        $updateQuery = "UPDATE users SET full_name = ? WHERE username = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ss", $fullname, $currentUser);
        mysqli_stmt_execute($stmt);
        $_SESSION["success_message"] = "Full name successfully updated.";
        header("Location: profile.php");
        exit();
    }
}

if (isset($_POST["updateUsername"])) {
    $username = $_POST["username"];
    if (empty($username)) {
        $errorMessages[] = "Username cannot be empty";
    } elseif ($username === $user['username']) {
        $errorMessages[] = "Username is unchanged";
    } elseif (strlen($username) < 3) {
        $errorMessages[] = "Username should be at least 3 characters long";
    } elseif (strlen($username) > 10) {
        $errorMessages[] = "Username should not be longer than 10 characters";
    } else {
        // Check if the username already exists in the database
        $checkQuery = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $errorMessages[] = "Username already exists. Please choose a different username.";
        } else {
            // Update the username if it doesn't exist
            $updateQuery = "UPDATE users SET username = ? WHERE username = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ss", $username, $currentUser);
            mysqli_stmt_execute($stmt);
            $_SESSION["user"] = $username;
            $_SESSION["success_message"] = "Username successfully updated.";
            header("Location: profile.php");
            exit();
        }
    }
}

if (isset($_POST["updatePassword"])) {
    $password = $_POST["password"];
    if (empty($password)) {
        $errorMessages[] = "Password cannot be empty";
    } elseif (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errorMessages[] = "Password must be at least 8 characters long and contain both letters and numbers";
    } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE users SET password = ? WHERE username = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $currentUser);
            mysqli_stmt_execute($stmt);
            $_SESSION["success_message"] = "Password successfully updated.";
            header("Location: profile.php");
            exit();
        }
    }

    if (isset($_POST["updateProfilePicture"])) {
        $profilePicture = $_POST["profilePicture"];
        $updateQuery = "UPDATE users SET profile_picture = ? WHERE username = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmt, "ss", $profilePicture, $currentUser);
        mysqli_stmt_execute($stmt);
        $_SESSION["success_message"] = "Profile picture successfully updated.";
        header("Location: profile.php");
        exit();
    }

    if (isset($_POST["deleteAccount"])) {
        // Delete the user's account from the database
        $deleteQuery = "DELETE FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmt, "s", $currentUser);
        mysqli_stmt_execute($stmt);
    
        // Destroy the session and redirect to the signup page
        session_destroy();
        header("Location: /planetart/pages/non-users/signup.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet Art | Discussions</title>
    <link rel="stylesheet" href="/planetart/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="icon" href="/planetart/images/favicon_io/favicon-32x32.png" type="image/x-icon">
<body>
<header>
    <nav class="navbar">
        <img src="/planetart/images/planetartlogo.png" alt="planet art logo" width="45" height="30" class="logo-img">
        <span class="site-name">Planet Art</span>

        <div>
            <a class="btn btn-outline-secondary nav-links" href="indexuser.php">Home</a>
            <a class="btn btn-outline-secondary nav-links" href="artistsuser.php">Artists</a>
            <a class="btn btn-outline-secondary nav-links current-page" href="discussionsuser.php">Discussions</a>
        </div>

        <div class="ml-auto">
                <!-- Welcome message -->
                <?php if (isset($_SESSION['user_fullname'])) : ?>
                    <p class="welcome-message">Welcome, <?php echo $_SESSION['user_fullname']; ?>!</p>
                <?php endif; ?>

            <!-- Account button with dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary login rounded-right" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="likes.php">My Likes</a>
                    <div class="dropdown-divider"></div>
                    <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) : ?>
                        <a class="dropdown-item" href="admin-dashboard.php">Admin Dashboard</a>
                        <div class="dropdown-divider"></div>
                    <?php endif; ?>
                    <a class="dropdown-item" href="?logout=1">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <?php
    // Check if the logout action is triggered
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        session_start();
        session_destroy();
        header("Location: /planetart/pages/non-users/login.php");
        exit();
    }
    ?>
    </header>

    <div class="container-fluid" style="position: relative; min-height: 100vh;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('/planetart/images/mark-ps.png'); background-size: cover; background-position: center; background-repeat: no-repeat; opacity: 1; z-index: -1;"></div>
            <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh; padding-top: 50px; padding-bottom: 50px;">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h2 class="card-title mb-4">Update Profile</h2>

                                    <?php if (isset($_SESSION["success_message"])) : ?>
                                        <div class="alert alert-success"><?php echo $_SESSION["success_message"]; ?></div>
                                        <?php unset($_SESSION["success_message"]); ?>
                                    <?php endif; ?>

                                    <?php foreach ($errorMessages as $error) : ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php endforeach; ?>
                                    
                                    <form action="profile.php" method="post" onsubmit="return confirmAccountDeletion(event)">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                                                <button type="submit" name="updateEmail" class="btn btn-outline-primary login btn-sm">Update Email</button>
                                            </div>
                                            <div class="mb-3">
                                                <label for="fullname" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $user['full_name']; ?>" required>
                                                <button type="submit" name="updateFullname" class="btn btn-outline-primary login btn-sm">Update Full Name</button>
                                            </div>
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                                                <button type="submit" name="updateUsername" class="btn btn-outline-primary login btn-sm">Update Username</button>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">New Password</label>
                                                <input type="password" class="form-control" id="password" name="password">
                                                <div class="form-text">Leave blank to keep the current password.</div>
                                                <button type="submit" name="updatePassword" class="btn btn-outline-primary login btn-sm">Update Password</button>
                                            </div>
                                            <div class="mb-3">
                                                <label for="profilePicture" class="form-label">Choose a Profile Picture</label>
                                                <div class="mb-3">
                                                    <label class="me-3">
                                                        <input type="radio" name="profilePicture" value="profile-user-pink.png" <?php if ($user['profile_picture'] == 'profile-user-pink.png') echo 'checked'; ?>>
                                                        <img src="/planetart/images/profile-user-pink.png" alt="Profile Picture 1" width="35" height="35">
                                                    </label>
                                                    <label class="me-3">
                                                        <input type="radio" name="profilePicture" value="profile-user-green.png" <?php if ($user['profile_picture'] == 'profile-user-green.png') echo 'checked'; ?>>
                                                        <img src="/planetart/images/profile-user-green.png" alt="Profile Picture 2" width="35" height="35">
                                                    </label>
                                                    <label class="me-3">
                                                        <input type="radio" name="profilePicture" value="profile-user-blue.png" <?php if ($user['profile_picture'] == 'profile-user-blue.png') echo 'checked'; ?>>
                                                        <img src="/planetart/images/profile-user-blue.png" alt="Profile Picture 3" width="35" height="35">
                                                    </label>
                                                    <label class="me-3">
                                                        <input type="radio" name="profilePicture" value="profile-user-black.png" <?php if ($user['profile_picture'] == 'profile-user-black.png') echo 'checked'; ?>>
                                                        <img src="/planetart/images/profile-user-black.png" alt="Profile Picture "4 width="35" height="35">
                                                    </label>
                                                </div>
                                                <button type="submit" name="updateProfilePicture" class="btn btn-outline-primary login">Update Profile Picture</button>
                                            </div>
                                            <div class="mb-3">
                                                <h3>Delete Account</h3>
                                                <p>Deleting your account is permanent and cannot be undone.</p>
                                                <button type="submit" name="deleteAccount" class="btn btn-danger">Delete Account</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer p-3">
            © 2024
            <a>Planet Art</a>
        </div>
    </footer>

    <script>
        function confirmAccountDeletion(event) {
            if (event.submitter.name === "deleteAccount") {
                return confirm("Are you sure you want to delete your account? This action cannot be undone.");
            }
            return true;
        }
    </script>

    <!-- Bootstrap js and popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
</body>
</html>