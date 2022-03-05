<?php
session_start();
include("../config/connect.php");
require_once("../config/user.php");
$id = $_SESSION["id"];
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="student.css">
    <script src="https://kit.fontawesome.com/50e4937a61.js" crossorigin="anonymous"></script>
</head>
</head>
<body>
    <div class="sidebar" >
        <ul class="menu">
			<li>
               <a href="index.php" > <i class="fas fa-user"></i> <?php echo "<span>".$_SESSION["username"]."</span>"; ?> </a> 
            </li>
            <li>
                <a href="user.php" class="darkblue">Users</a>
            </li>
            <li>
                <a href="assignment_show.php">Assignments</a>
            </li>
            <li>
                <a href="challenge.php" >Challenges</a>
            </li>
			<li>
                <a href="changeinfo.php" >Change info</a>
            </li>
			<li>
                <a href="changepwd.php" >Change password</a>
			</li>
			<li>
                <a href="../logout.php">Log out</a>
            </li>
        </ul>
	</div>
 
	<div class="content" id="user">
		<table border="1">
			<tr>
				  <th>ID</th>
				  <th>Picture</th>
				  <th>Username</th>
				  <th>Name</th>
				  <th>phone number</th>
				  <th>Email</th>
				  <th>Function</th>
				  </tr>
			<?php
				$sql = "SELECT id, avatar, username, name, pnumber, email FROM tbluser WHERE NOT id='$id'";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
				  
				  // output data of each row
				  while($row = $result->fetch_assoc()) { ?>
				    <tr>
			    		<td><?php echo $row["id"] ?></td>
			    		<td><?php echo $row["avatar"]?></td>
			    		<td><?php echo $row["username"]?></td> 
			    		<td><?php echo $row["name"] ?></td> 
			    		<td><?php echo $row["pnumber"] ?></td> 
			    		<td><?php echo $row["email"] ?></td>
			    		<td><button> <a href='message.php?idguest=<?php echo $row['id']?> '>Send message</a></button></td>
			    	</tr>
				  <?php }
				  
				} else {
				  echo "0 results";
				}
				$conn->close();
			?>

		</table>
	</div>
	

</body>
</html> 