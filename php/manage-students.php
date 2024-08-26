<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - GradUp</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f5a623;
            --background-color: #f4f7fc;
            --text-color: #333;
            --white: #ffffff;
            --danger: #e74c3c;
            --success: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .navbar {
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .container {
            max-width: 1200px;
            margin: 6rem auto 2rem;
            padding: 2rem;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-notify {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-notify:hover {
            background-color: #e69b14;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }

        thead th {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 500;
        }

        tbody tr {
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        tbody tr:hover {
            transform: translateY(-3px);
        }

        .btn-edit, .btn-delete {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-edit {
            background-color: var(--primary-color);
            color: var(--white);
            margin-right: 0.5rem;
        }

        .btn-delete {
            background-color: var(--danger);
            color: var(--white);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            th, td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <a class="navbar-brand" href="#">GradUp</a>
            <div>
                <a class="nav-link" href="../pages/admin-exam-details-upload.html">Add Marks</a>
                <a class="nav-link" href="settings.php">Settings</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Manage Students</h1>
        <form method="POST" action="">
            <button type="submit" name="notify" class="btn btn-notify mb-3">Notify Parents</button>
        </form>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Regno</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Rollno</th>
                        <th>Parent Name</th>
                        <th>Parent Contact</th>
                        <th>Percentage</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
                    if ($con == false) {
                        die("Error in database connection: " . mysqli_connect_error());
                    }
    
                    if (isset($_POST['notify'])) {
                        require '../vendor/autoload.php';
                        $basic = new \Vonage\Client\Credentials\Basic("Your Credentialas", "Your Credentialas");
                        $client = new \Vonage\Client($basic);
    
                        $query = "SELECT student_info.*, parent_info.parent_name, parent_info.parent_contact, (math_2 + dsa + be + chemistry + cetc) / 2.5 AS percentage
                                  FROM student_info
                                  JOIN parent_info ON student_info.regno = parent_info.student_regno";
                        $result = mysqli_query($con, $query);
    
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $percentage = round($row['percentage'], 2);
                                $messageText = "Student: " . $row['name'] . "\nTotal Marks: " . ($row['math_2'] + $row['dsa'] + $row['be'] + $row['chemistry'] + $row['cetc']) . "\nPercentage: " . $percentage . "%\nStatus: " . $row['status'];
    
                                $response = $client->sms()->send(
                                    new \Vonage\SMS\Message\SMS($row['parent_contact'], 'GRADUP', $messageText)
                                );
    
                                $message = $response->current();
    
                                if ($message->getStatus() != 0) {
                                    echo "The message failed with status: " . $message->getStatus() . "\n";
                                }
                            }
                            echo "<script>alert('Notifications sent successfully!');</script>";
                        }
                    }
    
                    $query = "SELECT student_info.*, parent_info.parent_name, parent_info.parent_contact, (math_2 + dsa + be + chemistry + cetc) / 2.5 AS percentage
                              FROM student_info
                              JOIN parent_info ON student_info.regno = parent_info.student_regno";
                    $result = mysqli_query($con, $query);
    
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $percentage = round($row['percentage'], 2);
                            echo "<tr>";
                            echo "<td>" . $row['regno'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['section'] . "</td>";
                            echo "<td>" . $row['rollno'] . "</td>";
                            echo "<td>" . $row['parent_name'] . "</td>";
                            echo "<td>" . $row['parent_contact'] . "</td>";
                            echo "<td>" . $percentage . "%</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>
                                        <a href='edit-student.php?regno=" . $row['regno'] . "' class='btn btn-primary btn-sm'>Edit</a>
                                        <a href='delete-student.php?regno=" . $row['regno'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>
                                      </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No records found</td></tr>";
                    }
    
                    mysqli_close($con);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
