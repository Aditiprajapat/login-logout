<?php
include ('config.php');

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER['REQUEST_METHOD'] == "GET"){
  //check username is Empty

   if(empty(trim($_GET["username"]))){
     $username_err = "Username cannot be blank";
   }
   else{
     $sql = "SELECT id FROM user WHERE username = ?";
     $stmt = mysqli_prepare($conn,$sql);
     if($stmt){
       mysqli_stmt_bind_param($stmt,"s", $param_username);

       //set the value of param username

       $param_username = trim($_GET['username']);

       //try to execute Statement
       if(mysqli_stmt_extecute($stmt)){
         mysqli_stmt_store_result($stmt);
         if(mysqli_stmt_num_rows($stmt) == 1)
         {
           $username_err = "this username is already taken";
         }
         else{
           $usename = trim($_GET['username']);
         }
       }
       else{
         echo "something went wrong";
       }
     }
   }
// mysqli_stmt_close($stmt);


//check password
if(empty(trim($_GET['password']))){
  $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_GET['password'])) < 5 ){
  $password_err = "Password cannot be less than 4 character";
}
else{
   $password = trim($_GET['password']);
}
//check for confirm password
if(trim($_GET['password']) != trim($_GET['Confirmpassword'])){
  $password_err = "Password shold match";
}
// if there were no errors,go ahead and insert into the Database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
  $sql = "INSERT INTO users (username,password) VALUES ('user','pass')";
  $stmt = mysqli_prepare($conn,$sql);
  if ($stmt)
  {
   mysqli_stmt_bind_param($stmt,"ss",$param_username,$param_password);
   //set these parameters
   $param_username = $username;
   $param_password = password_hash($password,PASSWORD_DEFAULT);

   //TRY TO EXECUTE THE query
 if (mysqli_stmt_extecute($stmt))
 {
   header("location: login.php");
 }
 else{
   echo "something went wrong";
 }
}
mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

 ?>






<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PHP Login system!</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">PHP login system</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Contact us</a>
          </li>


        </ul>
      </div>
    </div>
  </nav>
<div class = "container mt=4">
  <h2>Please register here</h2><hr>
  <form class="row g-3" method="GET">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Uername</label>
    <input type="text" name="username" class="form-control" id="text">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Password</label>
    <input type="password"name="password" class="form-control" id="password">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Confirm Password</label>
    <input type="password"name="Confirmpassword" class="form-control" id="Confirmpassword">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>
