<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regno = $_POST['regno'];
    $name = $_POST['name'];
    $emailid = $_POST['emailid'];
    $section = $_POST['section'];
    $rollno = $_POST['rollno'];
    $math_2 = $_POST['math_2'];
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
    }

    // Update student details
    $update_student = "UPDATE student_info SET name='$name', emailid='$emailid', section='$section', rollno='$rollno', 
                       math_2='$math_2', dsa='$dsa', be='$be', chemistry='$chemistry', cetc='$cetc', status='$status'
                       WHERE regno='$regno'";
    $result_student = mysqli_query($con, $update_student);

    // Update parent details
    $update_parent = "UPDATE parent_info SET parent_name='$parent_name', parent_contact='$parent_contact'
                      WHERE student_regno='$regno'";
    $result_parent = mysqli_query($con, $update_parent);

    if ($result_student && $result_parent) {
        echo "<script>alert('Details updated successfully!'); window.open('manage-students.php', '_self');</script>";
    } else {
        echo "Error in updating data: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
