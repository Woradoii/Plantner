<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>Plantner</p>
        <a href="index.html">HOME</a>
    </div>
      <div class="container">
        <div class="box form-box">
        <?php 
         
         include("config.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $weight = $_POST['weight'];
            $gender = $_POST['gender'];
            $likemenu = $_POST['likemenu'];
            $unlikeingred = $_POST['unlikeingred'];
            $calories = $_POST["calories"];
            $carbohydrate_MIN = $_POST['carbohydrate_MIN'];
            $carbohydrate_MAX = $_POST['carbohydrate_MAX'];
            $protien_MIN = $_POST['protien_MIN'];
            $protien_MAX = $_POST['protien_MAX'];
            $fat_MIN = $_POST['fat_MIN'];
            $fat_MAX = $_POST['fat_MAX'];

         //verifying the unique email

         $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

         if(mysqli_num_rows($verify_query) !=0 ){
            echo "<div class='message_error'>
                      <p>This email is used, Try another One Please!</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
         }
         else{
            mysqli_query($con,"INSERT INTO users(Username,Email,Password,Weight,Gender,Likemenu,Unlikeingred,Calories,Carbohydrate_MIN,Carbohydrate_MAX,Protein_MIN,Protein_MAX,Fat_MIN,Fat_MAX) VALUES('$username','$email','$password','$weight','$gender','$likemenu','$unlikeingred','$calories','$carbohydrate_MIN','$carbohydrate_MAX','$protien_MIN','$protien_MAX','$fat_MIN','$fat_MAX')") or die("Error Occured");

            echo "<div class='message'>
                      <p>Registration successfully!</p>
                  </div> <br>";
            echo "<a href='login.php'><button class='btn'>Login Now</button>";
         }
         }else{
        ?>
            <header>Sign Up</header>
            <form method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="weight input">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" name="weight" id="weight" autocomplete="off" required>
                </div>
                <div class="gender">
                    <div class="head">
                        <label for="gender">Gender</label>
                    </div>
                    <select class="field input "name="gender" id="genderSelect">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="field input">
                    <label for="likemenu">เมนูที่ชอบ</label>
                    <input type="text" pattern="[ก-๙]+" name="likemenu" id="likemenu" autocomplete="off" required>
                </div>
                
                <div class="field input">
                    <label for="unlikeingredd">วัตถุดิบที่แพ้/ไม่ชอบ</label>
                    <input type="text" pattern="[ก-๙]+" name="unlikeingred" id="unlikeingred" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="login.php">Sign In</a>
                </div>
                
            </form>
        </div>
        <?php } ?>
      </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.querySelector("form");
        form.addEventListener("submit", function(event) {
            var weight = document.getElementById("weight");
            var gender = document.querySelector('#genderSelect');
            if (!gender) {
                event.preventDefault();
                return;
            }

            // calories calculated
            var calories = 0;
            if (gender.value === "male") {
                calories = weight.value * 31;
            } else if (gender.value === "female") {
                calories = weight.value * 27;
            } else {
                event.preventDefault();
                return;
            }

            // carbohydrate_MIN calculated
            var carbohydrate_MIN = 0.45 * calories;

            // carbohydrate_MAX calculated
            var carbohydrate_MAX = 0.65 * calories;

            // protien_MIN calculated
            var protien_MIN = 0.2 * calories;

            // protien_MAX calculated
            var protien_MAX = 0.35 * calories;

            // fat_MIN calculated
            var fat_MIN = 0.1 * calories;

            // fat_MAX calculated
            var fat_MAX = 0.15 * calories;

            // calories input
            var caloriesInput = document.createElement("input");
            caloriesInput.type = "hidden";
            caloriesInput.name = "calories";
            caloriesInput.value = calories;
            form.appendChild(caloriesInput);

            // carbohydrate_MIN input
            var carbohydrate_MINInput = document.createElement("input");
            carbohydrate_MINInput.type = "hidden";
            carbohydrate_MINInput.name = "carbohydrate_MIN";
            carbohydrate_MINInput.value = carbohydrate_MIN;
            form.appendChild(carbohydrate_MINInput);

            // carbohydrate_MAX input
            var carbohydrate_MAXInput = document.createElement("input");
            carbohydrate_MAXInput.type = "hidden";
            carbohydrate_MAXInput.name = "carbohydrate_MAX";
            carbohydrate_MAXInput.value = carbohydrate_MAX;
            form.appendChild(carbohydrate_MAXInput);

            // protien_MIN input
            var protien_MINInput = document.createElement("input");
            protien_MINInput.type = "hidden";
            protien_MINInput.name = "protien_MIN";
            protien_MINInput.value = protien_MIN;
            form.appendChild(protien_MINInput);

            // protien_MAX input
            var protien_MAXInput = document.createElement("input");
            protien_MAXInput.type = "hidden";
            protien_MAXInput.name = "protien_MAX";
            protien_MAXInput.value = protien_MAX;
            form.appendChild(protien_MAXInput);

            // fat_MIN input
            var fat_MINInput = document.createElement("input");
            fat_MINInput.type = "hidden";
            fat_MINInput.name = "fat_MIN";
            fat_MINInput.value = fat_MIN;
            form.appendChild(fat_MINInput);

            // fat_MAX input
            var fat_MAXInput = document.createElement("input");
            fat_MAXInput.type = "hidden";
            fat_MAXInput.name = "fat_MAX";
            fat_MAXInput.value = fat_MAX;
            form.appendChild(fat_MAXInput);

            // Safe the all value in SQL
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "register.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                }
            };
            xhr.send("calories=" + calories);
            xhr.send("carbohydrate_MIN=" + carbohydrate_MIN);
            xhr.send("carbohydrate_MAX=" + carbohydrate_MAX);
            xhr.send("protien_MIN=" + protien_MIN);
            xhr.send("protien_MAX=" + protien_MAX);
            xhr.send("fat_MIN=" + fat_MIN);
            xhr.send("fat_MAX=" + fat_MAX);
        });
    });
</script>

</body>

</html>