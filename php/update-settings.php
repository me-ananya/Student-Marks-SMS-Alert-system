<?php
// Start session and check if admin is logged in
session_start();
if (!isset($_SESSION['username'])) {
   header("Location: ../pages/adminLogin.html");
   exit();
}

// Check if form is submitted
if (isset($_POST['submit'])) {
   $admin_id = $_SESSION['admin_id'];
   $name = $_POST['name'];
   $email = $_POST['email'];
   $password = $_POST['password'];

   $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
   if ($con == false) {
      die("Error in database connection: " . mysqli_connect_error());
   }

   $query = "UPDATE admin SET name='$name', email='$email', password='$password' WHERE admin_id='$admin_id'";
   $result = mysqli_query($con, $query);

   if ($result) {
      echo "<script>alert('Profile Updated Successfully!'); window.location.href = 'settings.php';</script>";
   } else {
      echo "<script>alert('Error in updating profile'); window.location.href = 'settings.php';</script>";
   }

   mysqli_close($con);
}
