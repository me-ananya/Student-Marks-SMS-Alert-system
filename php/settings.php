<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../pages/adminLogin.html");
    exit();
}

// Fetch admin details
$admin_id = $_SESSION['admin_id'];
$con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
if ($con == false) {
    die("Error in database connection: " . mysqli_connect_error());
}

$query = "SELECT * FROM admin WHERE admin_id='$admin_id'";
$result = mysqli_query($con, $query);
$admin = mysqli_fetch_assoc($result);

if (!$admin) {
    die("Admin not found");
}

mysqli_close($con);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            padding-top: 60px;
        }

        .navbar-custom {
            background-color: #333;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
        }

        form {
            margin: 2% 15%;
        }

        @media (max-width: 767px) {
            form {
                margin: 5%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../pages/admin-exam-details-upload.html">Add Marks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage-students.php">Manage Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center">Admin Settings</h1>
        <form method="POST" action="update-settings.php">
            <div class="form-group">
                <label for="admin_id">Admin ID</label>
                <input type="text" class="form-control" id="admin_id" name="admin_id" value="<?php echo $admin['admin_id']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $admin['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo $admin['password']; ?>" required>
            </div>
            <button type="submit" class="btn btn-dark" name="submit">Update</button>
        </form>
    </div>
</body>

</html>