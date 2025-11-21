<?php
   //đăng ksy tài khoản người dùng
   include 'config.php';

   if(isset($_POST['submit'])){

      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $email = mysqli_real_escape_string($conn, $_POST['email']);
      $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

      if(mysqli_num_rows($select_users) > 0){//kiểm tra email đã tồn tại chưa
         $message[] = 'Le compte déja existe!';
      }else{//chưa thì kiểm tra mật khẩu xác nhận và tạo tài khoản
         if($pass != $cpass){
            $message[] = 'Mot de pass incorrect!';
         }else{
            mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$cpass')") or die('query failed');
            $message[] = 'Incription réussie!';
         }
      }

   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Incription</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      .error {
         color: red;
         text-align: justify;
         margin-left: 5px;
         font-size: 15px;
      }
   </style>
</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>';
   }
}
?>
   
<div class="form-container">

   <form id="form" method="post">
      <h3>Incription</h3>
      <input type="text" name="name" placeholder="Nom et prénom" class="box">
      <div class="error check_username"></div>
      <input type="text" name="email" placeholder="Email" class="box">
      <div class="error check_email"></div>
      <input type="password" name="password" placeholder="Mot de pass" class="box">
      <div class="error check_password"></div>
      <input type="password" name="cpassword" placeholder="Confirmez votre mot de pass " class="box">
      <div class="error check_cpassword"></div>
      <input style="background-color: #005490;" type="submit" name="submit" value="S'inscrire" class="btn">
      <p>Vous avez déja un compte? <a style="color: #005490;" href="login.php">Se connecter</a></p>
   </form>

</div>
<!-- Validate form -->
<script>
  document.getElementById("form").addEventListener("submit", function(event) {
   var array = document.getElementsByTagName('input');
   var emailRegex = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/;
   if (array[0].value == "") {
      document.querySelector('.check_username').innerHTML = "Le nom ne peut pas être vide !";
      event.preventDefault();
   } else {
      document.querySelector('.check_username').innerHTML = "";
   }
   if (array[1].value == "") {
      document.querySelector('.check_email').innerHTML = "L'email ne peut pas être vide!";
      event.preventDefault();
   } else if(!emailRegex.test(array[1].value)) {
      document.querySelector('.check_email').innerHTML = "Format d'email incorrect !";
      event.preventDefault();
   } else {
      document.querySelector('.check_email').innerHTML = "";
   }
   if (array[2].value == "") {
      document.querySelector('.check_password').innerHTML = "Le mot de pass ne peut pas être vide!";
      event.preventDefault();
   } else if(array[2].value.length < 6) {
      document.querySelector('.check_password').innerHTML = "Le mot de pass doit comporter au moins 6 caractères !";
      event.preventDefault();
   }  else {
      document.querySelector('.check_password').innerHTML = "";
   }
   if (array[3].value == "") {
      document.querySelector('.check_cpassword').innerHTML = "La confirmation de mot de pass ne peut pas être vide!";
      event.preventDefault();
   } else if(array[3].value.length < 6) {
      document.querySelector('.check_cpassword').innerHTML = "La confirmation de mot de pas doit comporter au moins 6 caractères !";
      event.preventDefault();
   }  else {
      document.querySelector('.check_cpassword').innerHTML = "";
   }
  });
</script>
</body>
</html>