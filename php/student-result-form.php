<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result - GradUp</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            padding-top: 60px;
        }

        .navbar-custom {
            background-color: #3c244e;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white !important;
        }

        .head {
            margin-bottom: 20px;
        }

        .jumbotron {
            background-color: white;
            color: #333;
            padding: 2rem;
            margin-top: 20px;
            border: 1px solid #ccc;
        }

        .student-info h6 {
            color: #333;
        }

        .table {
            margin-top: 20px;
        }

        .table thead {
            background-color: #333;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .print-button {
            margin-top: 20px;
            background-color: #3c244e;
            color: white;
            border: none;
        }

        .print-button:hover {
            background-color: #8762a3;
        }

        .marks-summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        @media print {

            .navbar,
            .print-button {
                display: none;
            }

            .jumbotron {
                padding: 1rem;
                border: none;
            }
        }
    </style>
    <script>
        function printResult() {
            window.print();
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <a class="navbar-brand" href="#">GradUp</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="head text-center">Here is Your Result</h1>
        <?php
        session_start();
        if (isset($_POST['submit'])) {
            $emailid = $_POST['emailid'];
            $regno = $_POST['regno'];

            $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
            if ($con == false) {
                echo "Error in connection";
            } else {
                $select = "SELECT * FROM `student_info` WHERE `emailid`='$emailid' AND `regno`='$regno'";
                $query = mysqli_query($con, $select);
                $row = mysqli_num_rows($query);
                if ($row == 1) {
                    $data = mysqli_fetch_assoc($query);

                    $_SESSION['name'] = $data['name'];

                    echo "<div class='container jumbotron'>";

                    echo "<div class='row'>";
                    echo "<div class='col-lg-12 student-info'>";
                    echo "<h6><b>Name</b>: " . $data["name"] . "</h6>";
                    echo "<h6><b>Section</b>: " . $data["section"] . "</h6>";
                    echo "<h6><b>Email address</b>: " . $data["emailid"] . "</h6>";
                    echo "<h6><b>Roll No</b>: " . $data["rollno"] . "</h6>";
                    echo "<h6><b>Reg No</b>: " . $data["regno"] . "</h6>";
                    echo "</div>";
                    echo "</div>";

                    echo "<br />";

                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered'>";
                    echo "<thead class='thead-dark'>";
                    echo "<tr>";
                    echo "<th scope='col'>#</th>";
                    echo "<th scope='col'>Subject</th>";
                    echo "<th scope='col'>Mark Obtained</th>";
                    echo "<th scope='col'>Total Mark</th>";
                    echo "</tr>";
                    echo "</thead>";

                    echo "<tbody>";

                    echo "<tr>";
                    echo "<td>1</td>";
                    echo "<td>Mathematics - II</td>";
                    echo "<td>" . $data['math_2'] . "</td>";
                    echo "<td>50</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>2</td>";
                    echo "<td>Data Structure & Algorithm</td>";
                    echo "<td>" . $data["dsa"] . "</td>";
                    echo "<td>50</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>3</td>";
                    echo "<td>Basic Electronics</td>";
                    echo "<td>" . $data["be"] . "</td>";
                    echo "<td>50</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>4</td>";
                    echo "<td>Chemistry</td>";
                    echo "<td>" . $data["chemistry"] . "</td>";
                    echo "<td>50</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td>5</td>";
                    echo "<td>Communicative English & Technical Communication</td>";
                    echo "<td>" . $data["cetc"] . "</td>";
                    echo "<td>50</td>";
                    echo "</tr>";

                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td><b>Subtotal</b></td>";
                    echo "<td>" . $data["total"] . "</td>";
                    echo "<td><b>250</b></td>";
                    echo "</tr>";

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                    echo "<div id='marks-summary' class='marks-summary'> Percentage: " . $data["total"] / 2.5 . "%</div><br>";
                    if ($data["status"] == 'Pass') {
                        echo "<h3><b>Status</b>: <span style='color: #21bf73;'>Pass</span></h3>";
                    } else {
                        echo "<h3><b>Status</b>: <span style='color: #ff0000;'>Fail</span></h3>";
                    }

                    echo "<button class='btn print-button' onclick='printResult()'>Print Result</button>";

                    echo "</div>";
                } else {
                    echo "<script>alert('Wrong Emailid or Regno!! Please Try Again'); window.open('../pages/resultForm.html', '_self');</script>";
                }
            }
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>