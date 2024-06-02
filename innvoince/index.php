<?php
require "./config/database.php";

switch ($_REQUEST['action']) {

    case "Login":

        $email = $_POST['txtusername'];
        $password = $_POST['txtpassword'];

        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['name'] =$name;
            $_SESSION['msg'] = "Login successful";
            $_SESSION['color'] = 'green';
            header("Location: home.php");
        } else {
            $_SESSION['msg'] = "Invalid credentials";
            $_SESSION['color'] = 'red';
        }
        
    break;

    case "Sign Up":

        $username = $_POST['txtusername'];
        $email =    $_POST['txtemail'];
        $password = password_hash($_POST['txtpassword'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $is_created = $stmt->execute();
        $stmt->close();

        if ($is_created) {
            $_SESSION['msg'] = "User registered successfully";
            $_SESSION['color'] = 'green';
        } else {

            $_SESSION['msg'] = "Something went wrong !";
            $_SESSION['color'] = 'red';

        }
      
    break;

    case "Send":

      $email = $_POST['email'];
      $otp = "1111";

      $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($id);
      $stmt->fetch();
      $stmt->close();

      if ($id) {
          $new_password = password_hash("12345", PASSWORD_DEFAULT);
          $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
          $stmt->bind_param("si", $new_password, $id);
          $stmt->execute();
          $stmt->close();

          $_SESSION['msg'] = "Password reset successful";
          $_SESSION['color'] = 'green';
      } else {
          
        $_SESSION['msg'] = "Invalid email or OTP";
        $_SESSION['color'] = 'red';
      }
    break;

    default :
        unset($_POST);
    break;

}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./common/css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>
<section>
  <div class="container">
    <div class="user signinBx">
      <div class="imgBx"><img src="./images/login.png" alt="" /></div>
      <div class="formBx">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="frmlogin">
          <h2>Sign In</h2>
          <input type="text" name="txtusername" placeholder="Username" />
          <input type="password" name="txtpassword" placeholder="Password" />
          <input type="submit" name="action" value="Login" />
          <p class="signup">
            Don't have an account ?
            <a href="#" onclick="toggleForm();">Sign Up.</a>
          </p>
          <p class="signup">
            Forgot password ?
            <a href="#" onclick="forgot();" >Click Here</a>
              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="frmlogin">
                <div class="forgot forgotPassword">
                  <input type="email" name="email" placeholder="Email id" />
                  <!-- <input type="text" name="mobile" placeholder="Mobile Number" /> -->
                  <input type="submit" name="action" value="Send" />
                </div>
              </form>
          </p>
        </form>
      </div>
      
    </div>
    <div class="user signupBx">
      <div class="formBx">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="frmregister">
          <h2>Create an account</h2>
          <input type="text" name="txtusername" placeholder="Name" />
          <input type="email" name="txtemail" placeholder="Email" />
          <input type="password" name="txtpassword" placeholder="Password" />
          <input type="submit" name="action" value="Sign Up" />
          <p class="signup">
            Already have an account ?
            <a href="#" onclick="toggleForm();">Sign in.</a>
          </p>
        </form>
      </div>
      <div class="imgBx"><img src="./images/registration.png" alt="" /></div>
    </div>
  </div>

  
  
</section>
</body>
<script src="./common/js/script.js"></script>
</html>