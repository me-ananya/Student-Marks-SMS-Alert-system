<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $emailid = $_POST['emailid'];
    $section = $_POST['section'];
    $rollno = $_POST['rollno'];
    $regno = $_POST['regno'];
    $math_2 = $_POST['math-2'];
    $dsa = $_POST['dsa'];
    $be = $_POST['be'];
    $chemistry = $_POST['chemistry'];
    $cetc = $_POST['cetc'];
    $status = $_POST['status'];
    $parent_name = $_POST['parent_name'];
    $parent_contact = $_POST['parent_contact'];

    $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
    if ($con == false) {
        die("Error in database connection: " . mysqli_connect_error());
    } else {
        $select = "SELECT * FROM `student_info` WHERE `regno`='$regno'";
        $result = mysqli_query($con, $select);
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            echo "<script>alert('Student with this RegNo already exists'); window.open('../pages/admin-exam-details-upload.html', '_self');</script>";
        } else {
            $insert_student = "INSERT INTO `student_info`(`name`, `emailid`, `section`, `rollno`, `regno`, `math_2`, `dsa`, `be`, `chemistry`, `cetc`, `status`) VALUES ('$name', '$emailid', '$section', '$rollno', '$regno', '$math_2', '$dsa', '$be', '$chemistry', '$cetc', '$status')";
            $insert_parent = "INSERT INTO `parent_info`(`parent_name`, `parent_contact`, `student_regno`) VALUES ('$parent_name', '$parent_contact', '$regno')";

            $row_student = mysqli_query($con, $insert_student);
            if ($row_student === false) {
                die("Error in inserting student data: " . mysqli_error($con));
            }

            $row_parent = mysqli_query($con, $insert_parent);
            if ($row_parent === false) {
                die("Error in inserting parent data: " . mysqli_error($con));
            }

            if ($row_student === true && $row_parent === true) {
                echo "<script>alert('Details Added Successfully!'); window.open('../pages/admin-exam-details-upload.html', '_self');</script>";
            } else {
                echo "Unknown error in inserting data";
            }
        }
    }
}
