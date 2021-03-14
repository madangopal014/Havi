<?php
require_once "logincon.php";
require_once "session.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
 $firstname = trim($_POST['fname']);
 $lastname = trim($_POST['lname']);
 $phonenumber = trim($_POST['phno']);
 $email = trim($_POST['email']);
 $password = trim($_POST['password']);
 $confirm_password = trim($_POST["confirm_password"]);
 $password_hash = password_hash($password, PASSWORD_BCRYPT);
 $date=trim($_POST['date']);
 if($query = $db->prepare("SELECT * FROM users WHERE email = ?")) {
 $error = '';

 $query->bind_param('s', $email);
 $query->execute();

 $query->store_result();
 if ($query->num_rows > 0) {
 $error .= '<p class="error">The email address is already registered!</p>';
 } else {

 if (strlen($password ) < 6) {
 $error .= '<p class="error">Password must have atleast 6 characters.</p>';
 }

 if (empty($confirm_password)) {
 $error .= '<p class="error">Please enter confirm password.</p>';
 } else {
 if (empty($error) && ($password != $confirm_password)) {
 $error .= '<p class="error">Password did not match.</p>';
 }
 }
 if (empty($error) ) {
 $insertQuery = $db->prepare("INSERT INTO users (fname,lname,phno, email, password,date) VALUES (?, ?, ?);");
 $insertQuery->bind_param("sss", $fullname, $email, $password_hash);
 $result = $insertQuery->execute();
 if ($result) {
 $error .= '<p class="success">Your registration was successful!</p>';
 } else {
 $error .= '<p class="error">Something went wrong!</p>';
 }
 }
 }
 }
 $query->close();
 $insertQuery->close();

 mysqli_close($db);
}
?>
<!DOCTYPE html>
<html lang="en">
 <head>
 <meta charset="UTF-8">
 <title>Sign Up</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
 </head>
 <body>
 <div class="container">
 <div class="row">
 <div class="col-md-12">
<h2>Register</h2>
<p>Please fill this form to create an account.</p>
 <form action="" method="post">
 <div class="form-group">
 <label>First Name</label>
 <input type="text" name="fname" class="form-control" required>
 </div>
 <div class="form-group">
 <label>Last Name</label>
 <input type="text" name="lname" class="form-control" required>
 </div>
 <div class="form-group">
 <label>Phone Number</label>
 <input type="number" name="phno" class="form-control" required>
 </div>
<div class="form-group">
 <label>Email Address</label>
 <input type="email" name="email" class="form-control" required />
 </div>
<div class="form-group">
 <label>Password</label>
 <input type="password" name="password" class="form-control" required>
 </div>
<div class="form-group">
 <label>Confirm Password</label>
 <input type="password" name="confirm_password" class="form-control" required>
 </div>
 <div>
 <label>Date</label>
 <input type="date" name="begin" placeholder="dd-mm-yyyy" value=""min="1997-01-01" max="2030-12-31">
</div>
<div class="form-group">
 <input type="submit" name="submit" class="btn btn-primary" value="Submit">
 </div>
<p>Already have an account? <a href="login.php">Login here</a>.</p>
 </form>
 </div>
 </div>
 </div>
 </body>
</html
