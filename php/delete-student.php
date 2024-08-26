<?php
if (isset($_GET['regno'])) {
    $regno = $_GET['regno'];

    $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
    if ($con == false) {
        die("Error in database connection: " . mysqli_connect_error());
    }

    // Delete parent information first to avoid foreign key constraint issues
    $delete_parent = "DELETE FROM parent_info WHERE student_regno='$regno'";
    $result_parent = mysqli_query($con, $delete_parent);
    if ($result_parent === false) {
        die("Error in deleting parent data: " . mysqli_error($con));
    }

    // Then delete student information
    $delete_student = "DELETE FROM student_info WHERE regno='$regno'";
    $result_student = mysqli_query($con, $delete_student);
    if ($result_student === false) {
        die("Error in deleting student data: " . mysqli_error($con));
    }

    if ($result_parent && $result_student) {
        echo "<script>alert('Student and Parent details deleted successfully!'); window.open('manage-students.php', '_self');</script>";
    } else {
        echo "Unknown error in deleting data";
    }

    mysqli_close($con);
}
?>
