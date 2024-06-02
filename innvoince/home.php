<?php
require "./config/database.php";


if ($_SESSION['user_id']=="") {
    header("Location: index.php");
}

include_once ('./common/header.php');


switch ($_REQUEST['action']) {
    
    case "Delete":
       
        $id = $_POST['pk_del_id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $is_deleted = $stmt->execute();
        $stmt->close();

        if ($is_deleted) {
            $_SESSION['msg'] = "Record deleted successfully";
            $_SESSION['color'] = 'green';
        } else {
            $_SESSION['msg'] = "Something Went wrong!";
            $_SESSION['color'] = 'red';
        }

        header("Location: home.php");
        exit();
    break;
}
?>
<div class="container">
 <?php
 if (($_SESSION['msg'] !="") || (!empty($_SESSION['msg']))) { ?>

    <p align="center" style="font-weight: bold; color: <?php if($_SESSION['color'] != ""){echo $_SESSION['color'];} ?>; margin-top: 15px; font-size: 14px;">
		    <?php if($_SESSION['msg']!=""){echo $_SESSION['msg'];unset($_SESSION['msg']);} ?>
	</p>
 <?php }
 unset($_SESSION['color']);
 ?>
<table class="table table-striped">
            <thead>
                <tr>
                    <th>Sr. No.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Created On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                
                $sql = "SELECT id, name, email, created_at FROM users";
                $result = $conn->query($sql);
                $i=1;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { ?>

                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><?php echo $row["created_at"]; ?></td>
                        <td><a href="javascript:void(0);" onclick="openModal(<?php echo $row['id']; ?>)" id="<?php echo $row['id']; ?> "><i class="fa fa-edit"></i></a> | 
                        <a href="javascript:void(0);" class="btndelete" id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                      
                <?php $i++; }
                } else {
                    echo "<tr> <td colspan='5' style='text-align:center;'> No Records found! </td> </tr>";
                }
                ?>
                
                
            </tbody>
        </table>
</div>

<form action="./modify.php" method="post" id="frmview">
        <input type="hidden" name="pk_id" id="pk_id" value="" />
	   <input type="hidden" name="action" value="view" />
</form>

<?php
//session_destroy();

include_once ('./common/footer.php');
?>

<script>
    function openModal (id) {
        $('#pk_id').val(id);
        $('#frmview').submit();
    }
</script>