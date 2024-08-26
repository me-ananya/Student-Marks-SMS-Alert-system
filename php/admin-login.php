<?php
session_start();
if (isset($_POST['login'])) {
    $emailid = $_POST['emailid'];
    $password = $_POST['password'];

    $con = mysqli_connect('localhost', 'root', '', 'student_result_management_system');
    if ($con == false) {
        echo "Error in connection";
    } else {
        $select = "SELECT * FROM `admin` WHERE `email`='$emailid'  AND `password`='$password'";
        $query = mysqli_query($con, $select);
        $row = mysqli_num_rows($query);
        if ($row == 1) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['username'] = $data['name'];
            $_SESSION['admin_id'] = $data['admin_id'];
            header("Location:../php/admin-dashboard.php");
        } else {
?>
            <script>
                alert('Wrong Emailid or Password!!Please Try Again');
                window.open('../pages/adminLogin.html', '_self');
            </script>
<?php
        }
    }
}

?>