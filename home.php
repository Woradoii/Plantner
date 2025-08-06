<?php 
   session_start();
   include("config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<?php 
            
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_username = $result['Username'];
                $res_email = $result['Email'];
                $res_weight = $result['Weight'];
                $res_gender = $result['Gender'];
                $res_likemenu = $result['Likemenu'];
                $res_unlikeingred = $result['Unlikeingred'];
                $res_calories = $result['Calories'];
                $res_id = $result['Id'];
            }
            
            
            ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>Plantner</p>
         <div class="right-links">
            <a href="edit.php"> <button class="btn">Change profile</button> </a>
            <a href="logout.php"> <button class="btn">Log Out</button> </a>
        </div>
        <a href="home.php">HOME</a>
    </div>
    
    <main>
        <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php echo $res_username ?></b>, Welcome</p>
                <p>Your email is <b><?php echo $res_email ?></b>.</p>
                <p>Your weight is <b><?php echo $res_weight ?></b> Kg.</p>
                <p>Your gender is <b><?php echo $res_gender ?></b>.</p>
                <p>Favorite menu is <b><?php echo $res_likemenu ?></b>.</p>
                <p>Allergie/Unliked ingredient is <b><?php echo $res_unlikeingred ?></b>.</p>
                <p>Your calories is <b><?php echo $res_calories ?></b> Kgcal.</p>
            </div>
        </div>
        <a href="match.php"> <button class="btn">Match</button> </a>
    </main>
</body>
</html>