<?php 
require "./config/database.php";

if ($_SESSION['user_id']=="") {
    header("Location: index.php");
}

include_once ('./common/header.php');

switch ($_REQUEST['action']) {

    case "view":

        $sql = "SELECT * FROM users where id= ".$_REQUEST['pk_id']." ";
        $result = $conn->query($sql);

        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data = $row;
            }
        }
      
    break;

    case "Update":

       
        $id = $_POST['id'];
        $new_name = $_POST['txtusername'];
        $email = $_POST['txtemail'];

        $stmt = $conn->prepare("UPDATE users SET name=? , email=? WHERE id=?");
        $stmt->bind_param("ssi", $new_name, $email, $id);
        $is_updated = $stmt->execute();
        $stmt->close();

        if ($is_updated) {
            $_SESSION['msg'] = "User updated successfully";
            $_SESSION['color'] = 'green';
        } else {

            $_SESSION['msg'] = "Something went wrong !";
            $_SESSION['color'] = 'red';

        }

        header("Location: home.php");

    break;

}

?>

<head>
    <link rel="stylesheet" href="./common/css/style.css">
    <style>
        section .container .signupBx .formBx {
            left: 25%;
        }
        section {
            background-color: transparent;
            min-height: auto;
        }
        section .container .signupBx {
            pointer-events: all;
        }
    </style>
</head>

    <section>
        <div class="container">
            <div class="user signupBx">
                <div class="formBx">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="frmupdate">
                        <h2>Update Data</h2>
                        <input type="text" name="txtusername" value="<?php echo $data['name']; ?>" placeholder="Name" />
                        <input type="email" name="txtemail" value="<?php echo $data['email']; ?>" placeholder="Email" />
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
                        <!-- <input type="password" name="txtpassword" placeholder="Password" /> -->
                        <input type="submit" name="action" value="Update" />
                        
                    </form>
                </div>
                <div class="imgBx"><img src="./images/registration.png" alt="" /></div>
            </div>
        </div>
    </section>
