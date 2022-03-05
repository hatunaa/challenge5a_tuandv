<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
    
$msg = "";
$id = $_SESSION["id"];
$sql = "SELECT * FROM tbluser WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQLI_NUM);
$name = $row["4"];
$username = $row["1"];
$phonenumber = $row["5"];
$email = $row["6"];
$avatar = $row["7"];

// click change info
if(isset($_POST["update"])){
	$email = $_POST["email"];
	$phonenumber = $_POST["phonenumber"];
    $filename = $_FILES["uploadFile"]["name"];
    $tempname = $_FILES["uploadFile"]["tmp_name"];    
    $folder = "../image/avatars/".$filename;

	
	// check if information is in the right format
    if(empty($phonenumber) or empty($email)){
        $err = "*Fill all the fields";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err = "*Invalid email format";
    } elseif(!preg_match("/^[0]{1}[0-9]{9}$/", $phonenumber)){
        $err = "*Phone number must have ten numbers and starts with 0.";
    } else {
		$sql = "UPDATE tbluser SET email = '$email', pnumber = '$phonenumber', avatar = '$filename' WHERE id = '$id'";
        //check file upload
        if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }else{
            $msg = "Failed to upload image";
            echo "<script type='text/javascript'>alert('$msg');</script>";
      }
		if($conn->query($sql) == true){
				echo '<script language="javascript">alert("Cập nhật thành công"); window.location="user.php";</script>';
		}else {
            $err = "Change info failed. Try again";
            echo "<script type='text/javascript'>alert('$err');</script>";
            exit();
        }
	}	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="sidebar" >
        <ul class="menu">
			<li>
               <a href="index.php" > <i class="fas fa-user"></i> <?php echo "<span>".$_SESSION["username"]."</span>"; ?> </a> 
            </li>
            <li>
                <a href="user.php">Users</a>
            </li>
            <li>
                <a href="assignment_show.php">Assignments</a>
            </li>
            <li>
                <a href="challenge.php" >Challenges</a>
            </li>
			<li>
                <a href="changeinfo.php" class="darkblue" >Change info</a>
            </li>
			<li>
                <a href="changepwd.php"  >Change password</a>
			</li>
			<li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
	</div>

    <div class="content">
        <form action="changeinfo.php" method="post" enctype="multipart/form-data">
            <!-- <span class="err"> <?php echo $err; ?> </span><br><br> -->
			<p>Infomation student: <?php echo $name ?> </p>	
            <label for="username">Username:</label><br>
            <input type="text" readonly name="username" value="<?php echo $username?>"><br>
            <label for="name">Full name:</label><br>
            <input type="text" readonly name="name" value="<?php echo $name?>"><br>
			<label for="email">Email:</label><br>
			<input type="text" name="email" value="<?php echo $email?>"><br>
			<label for="phonenumber">Phone number:</label><br>
			<input type="text" name="phonenumber" value="<?php echo $phonenumber?>"><br>
            <label for="avatar">Upload image</label>
            <input type="file" name="uploadFile"><br><br>
            <input type="submit" value="Save" name="update">
		</form>
    </div>


</body>
</html>  



