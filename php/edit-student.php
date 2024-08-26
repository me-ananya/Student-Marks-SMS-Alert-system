<?php
// Fetch the current student and parent details based on regno
if (isset($_GET['regno'])) {
   $regno = $_GET['regno'];

   $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
   if ($con == false) {
      die("Error in database connection: " . mysqli_connect_error());
   }

   $query = "SELECT student_info.*, parent_info.parent_name, parent_info.parent_contact 
              FROM student_info 
              JOIN parent_info ON student_info.regno = parent_info.student_regno 
              WHERE student_info.regno='$regno'";
   $result = mysqli_query($con, $query);
   $student = mysqli_fetch_assoc($result);

   if (!$student) {
      die("Student not found");
   }

   mysqli_close($con);
} else {
   die("Invalid request");
}
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Student</title>
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
               <a class="nav-link" href="manage-students.php">Manage Students</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="settings.php">Settings</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="logout.php">Logout</a>
            </li>
         </ul>
      </div>
   </nav>

   <div class="container">
      <h1 class="text-center">Edit Student Details</h1>
      <form class="jumbotron" method="POST" action="update-student.php">
         <input type="hidden" name="regno" value="<?php echo $student['regno']; ?>">
         <div class="form-group">
            <label for="name">Student Name *</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['name']; ?>" required>
         </div>
         <div class="form-group">
            <label for="emailid">Email address *</label>
            <input type="email" class="form-control" id="emailid" name="emailid" value="<?php echo $student['emailid']; ?>" required>
         </div>
         <div class="form-row">
            <div class="col-lg-4 col-md-6">
               <br>
               <label for="section">Section *</label>
               <input type="text" class="form-control" id="section" name="section" value="<?php echo $student['section']; ?>" required>
            </div>
            <div class="col-lg-4 col-md-6">
               <br>
               <label for="rollno">Rollno *</label>
               <input type="text" class="form-control" id="rollno" name="rollno" value="<?php echo $student['rollno']; ?>" required>
            </div>
            <div class="col-lg-4">
               <br>
               <label for="status">Status *</label>
               <input type="text" class="form-control" id="status" name="status" value="<?php echo $student['status']; ?>" required>
            </div>
         </div>
         <div class="form-row">
            <div class="col-lg-6 col-md-6">
               <br>
               <label for="parent_name">Parent Name *</label>
               <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?php echo $student['parent_name']; ?>" required>
            </div>
            <div class="col-lg-6 col-md-6">
               <br>
               <label for="parent_contact">Parent Contact *</label>
               <input type="text" class="form-control" id="parent_contact" name="parent_contact" value="<?php echo $student['parent_contact']; ?>" required>
            </div>
         </div>
         <br><br>
         <div class="form-group">
            <table class="table">
               <thead class="thead-dark">
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Subject</th>
                     <th scope="col">Mark Obtained</th>
                     <th scope="col">Total Mark</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <th scope="row">1</th>
                     <td>Mathematics - II</td>
                     <td><input type="number" class="form-control" id="math_2" name="math_2" value="<?php echo $student['math_2']; ?>" required></td>
                     <td>/ 50</td>
                  </tr>
                  <tr>
                     <th scope="row">2</th>
                     <td>Data Structure & Algorithm</td>
                     <td><input type="number" class="form-control" id="dsa" name="dsa" value="<?php echo $student['dsa']; ?>" required></td>
                     <td>/ 50</td>
                  </tr>
                  <tr>
                     <th scope="row">3</th>
                     <td>Basic Electronics</td>
                     <td><input type="number" class="form-control" id="be" name="be" value="<?php echo $student['be']; ?>" required></td>
                     <td>/ 50</td>
                  </tr>
                  <tr>
                     <th scope="row">4</th>
                     <td>Chemistry</td>
                     <td><input type="number" class="form-control" id="chemistry" name="chemistry" value="<?php echo $student['chemistry']; ?>" required></td>
                     <td>/ 50</td>
                  </tr>
                  <tr>
                     <th scope="row">5</th>
                     <td>Communicative English & Technical Communication</td>
                     <td><input type="number" class="form-control" id="cetc" name="cetc" value="<?php echo $student['cetc']; ?>" required></td>
                     <td>/ 50</td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="form-row">
            <div class="col-lg-6 col-md-6">
               <br>
               <label for="status">Status *</label>
               <input type="text" class="form-control" id="status" name="status" value="<?php echo $student['status']; ?>" placeholder="Pass / Fail" required>
            </div>
         </div>
         <br><br>
         <button type="submit" class="btn btn-dark" name="submit">Update</button>
      </form>
   </div>
</body>

</html>