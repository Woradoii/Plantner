<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="match.css">
    <title>Vegetable</title>
</head>

<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>Plantner</p>
        <a href="edit.php" id="profile">Profile</a>
        <a href="logout.php" id="log-out">Log-out</a>
        <a href="home.php" id='home'>Home</a>
    </div>
    <?php
    include("config.php");
    $id = $_SESSION['id'];
    $user_sql = "SELECT Id, Username, Likemenu, Unlikeingred FROM users WHERE Id = '$id'";
    $user_result = $con->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $menu_sql = "SELECT * FROM menu";
    $menu_result = $con->query($menu_sql);
    $menu_row = $menu_result->fetch_assoc();
    $userCaloriesSql = "SELECT Calories FROM users WHERE Id = '$id'";
    $userCaloriesResult = $con->query($userCaloriesSql);
    $userCaloriesRow = $userCaloriesResult->fetch_assoc();
    $userCalories = $userCaloriesRow['Calories'];
    $userCarboMINSql = "SELECT Carbohydrate_MIN FROM users WHERE Id = '$id'";
    $userCarboMINResult = $con->query($userCarboMINSql);
    $userCarboMINRow = $userCarboMINResult->fetch_assoc();
    $userCarboMIN = $userCarboMINRow['Carbohydrate_MIN'];
    $userCarboMAXSql = "SELECT Carbohydrate_MAX FROM users WHERE Id = '$id'";
    $userCarboMAXResult = $con->query($userCarboMAXSql);
    $userCarboMAXRow = $userCarboMAXResult->fetch_assoc();
    $userCarboMAX = $userCarboMAXRow['Carbohydrate_MAX'];
    $userProteinMINSql = "SELECT Protein_MIN FROM users WHERE Id = '$id'";
    $userProteinMINResult = $con->query($userProteinMINSql);
    $userProteinMINRow = $userProteinMINResult->fetch_assoc();
    $userProteinMIN = $userProteinMINRow['Protein_MIN'];
    $userProteinMAXSql = "SELECT Protein_MAX FROM users WHERE Id = '$id'";
    $userProteinMAXResult = $con->query($userProteinMAXSql);
    $userProteinMAXRow = $userProteinMAXResult->fetch_assoc();
    $userProteinMAX = $userProteinMAXRow['Protein_MAX'];
    $userFatMINSql = "SELECT Fat_MIN FROM users WHERE Id = '$id'";
    $userFatMINResult = $con->query($userFatMINSql);
    $userFatMINRow = $userFatMINResult->fetch_assoc();
    $userFatMIN = $userFatMINRow['Fat_MIN'];
    $userFatMAXSql = "SELECT Fat_MAX FROM users WHERE Id = '$id'";
    $userFatMAXResult = $con->query($userFatMAXSql);
    $userFatMAXRow = $userFatMAXResult->fetch_assoc();
    $userFatMAX = $userFatMAXRow['Fat_MAX'];
    $likemenu = $user_row['Likemenu'];
    $likemenu_sql = "SELECT * FROM menu WHERE Menu_Name = '$likemenu'";
    $likemenu_result = $con->query($likemenu_sql);
    $likemenu_row = $likemenu_result->fetch_assoc();
    $likemenuProbability = 70;
    if ($likemenu_row && mt_rand(1, 100) <= $likemenuProbability) {
        $menu[] = $likemenu_row;
    }
    $unlikeingred = $user_row['Unlikeingred'];
    $unlikeingred_sql = "SELECT * FROM ingredient WHERE Ingred_Name LIKE '%$unlikeingred%'";
    $unlikeingred_result = $con->query($unlikeingred_sql);
    if ($unlikeingred_result) {
        $menuIdsToRemove = array();
        while ($unlikeingred_row = $unlikeingred_result->fetch_assoc()) {
            $selectingred = $unlikeingred_row['Ingred_Name'];
            $selectingred_sql = "SELECT * FROM menu_ingredient WHERE Ingred_Name LIKE '%$selectingred%'";
            $selectingred_result = $con->query($selectingred_sql);
            if ($selectingred_result) {
                while ($selectingred_row = $selectingred_result->fetch_assoc()) {
                    $menuIdsToRemove[] = $selectingred_row['Id'];
                }
            }
        }
        if ($menuIdsToRemove) {
            $randmenu_sql = 'SELECT * FROM menu WHERE Id NOT IN (" . implode(",", $menuIdsToRemove) . ") ORDER BY RAND() LIMIT 3';
        } else {
            $randmenu_sql = "SELECT * FROM menu ORDER BY RAND() LIMIT 3";
        }
        $randmenu_result = $con->query($randmenu_sql);
        while ($randmenu_row = $randmenu_result->fetch_assoc()) {
            $menu[] = $randmenu_row;
        }
        shuffle($menu);
        $totalCarbohydrate = 0;
        $totalCalories = 0;
        $totalCarbo = 0;
        $totalProtein = 0;
        $totalFat = 0;
        foreach ($menu as $myArray) {
            $totalCalories += $myArray["Calories"];
            $totalCarbohydrate += $myArray["Carbohydrate"];
            $totalProtein += $myArray["Protein"];
            $totalFat += $myArray["Fat"];
        }
        $threshold = 600;
        if (abs($totalCalories - $userCalories) <= $threshold) {
            // if (!
            //     ($userCarboMIN <= $totalCarbo || $totalCarbo <= $userCarboMAX) ||
            //     ($userProteinMIN <= $totalProtein || $totalProtein <= $userProteinMax) ||
            //     ($userFatMIN <= $totalFat || $totalFat <= $userFatMAX)
            // ) {
            //     header("Location: match.php");
            // }
        } else {header("Location: match.php");}
    } else {
        $menu = array();
        $randmenu_sql = "SELECT * FROM menu m LEFT JOIN menu_scores ms ON m.Id = ms.menu_id AND ms.user_id = '$userId' WHERE m.Id NOT IN (' . implode(',', $menuIdsToRemove) . ') AND RAND() <= IFNULL((ms.score / 10), 1) ORDER BY RAND() LIMIT 3";
        $randmenu_result = $con->query($randmenu_sql);
        while ($randmenu_row = $randmenu_result->fetch_assoc()) {
            $menu[] = $randmenu_row;
        }
        shuffle($menu);
        $totalCarbohydrate = 0;
        $totalCalories = 0;
        $totalCarbo = 0;
        $totalProtein = 0;
        $totalFat = 0;
        foreach ($menu as $myArray) {
            $totalCalories += $myArray["Calories"];
            $totalCarbohydrate += $myArray["Carbohydrate"];
            $totalProtein += $myArray["Protein"];
            $totalFat += $myArray["Fat"];
        }
        $threshold = 600;
        if (abs($totalCalories - $userCalories) <= $threshold) {
            // ผลรวมของ Calories ทั้ง 3 เมนูใกล้เคียงกับ Calories ของผู้ใช้มากที่สุด
            // if (!
            //     ($userCarboMIN <= $totalCarbo || $totalCarbo <= $userCarboMAX) ||
            //     ($userProteinMIN <= $totalProtein || $totalProtein <= $userProteinMax) ||
            //     ($userFatMIN <= $totalFat || $totalFat <= $userFatMAX)
            // ) {
            //     header("Location: match.php");
            // }
        } else {header("Location: match.php");}
    }
    if (isset($_POST['match']) && ($_POST['match']) !== false) {
        $menuId = $_POST['match'];
        $userId = $_SESSION['id'];
        $score = 6;
        $checkExistingScoreSQL = "SELECT * FROM menu_scores WHERE User_id = '$userId' AND Menu_id = '$menuId'";
        $existingScoreResult = $con->query($checkExistingScoreSQL);
        if ($existingScoreResult->num_rows > 0) {
            $updateScoreSQL = "UPDATE menu_scores SET Score = IF(Score = 1, '$score', GREATEST(Score - 1, 0)) WHERE User_id = '$userId' AND Menu_id = '$menuId'";
            $con->query($updateScoreSQL);
        } elseif ($existingScoreResult->num_rows == 0) {
            $insertScoreSQL = "INSERT INTO menu_scores (User_id, Menu_id, Score) VALUES ('$userId', '$menuId', '$score')";
            $con->query($insertScoreSQL);
        }
    }
    if (count($menu) > 0) {
        $breakfast = array_shift($menu);
        echo "<h1>มื้อเช้า</h1>";
        $breakfast_menu = " <div class='menubox' id='breakfast-menu-container'>
            <h2>เมนู: {$breakfast['Menu_Name']}</h2>
            <div class='menuinfo'>วัตถุดิบ: {$breakfast['Ingredients']}<br>
            แคลอรี่: {$breakfast['Calories']} กิโลแคลอรี่<br>
            คาร์โบไฮเดรต: {$breakfast['Carbohydrate']}กรัม<br>โปรตีน: {$breakfast['Protein']}กรัม<br>ไขมัน: {$breakfast['Fat']}กรัม<br>วิตามิน: {$breakfast['Vitamin']}กรัม<br>โซเดียม: {$breakfast['Sodium']}กรัม
            </div></div>
            <form method='post' id='breakfast-form'>
            <button type='button' name='match' value='{$breakfast['Id']}' class='breakfast-button' id='yes-button'>กิน</button>
            <button type='button' name='noMatch' value='breakfast' class='no-button' id='no-breakfast'>ไม่กิน</button>
            </form><br>";
        echo $breakfast_menu;
        $lunch = array_shift($menu);
        echo "<h1>มื้อกลางวัน</h1>";
        $lunch_menu = "<div class='menubox' id='lunch-menu-container'>
            <h2>เมนู: {$lunch['Menu_Name']}</h2>
            <div class='menuinfo'>วัตถุดิบ: {$lunch['Ingredients']}<br>
            แคลอรี่: {$lunch['Calories']}กิโลแคลอรี่<br>
            คาร์โบไฮเดรต: {$lunch['Carbohydrate']}กรัม<br>โปรตีน: {$lunch['Protein']}กรัม<br>ไขมัน: {$lunch['Fat']}กรัม<br>วิตามิน: {$lunch['Vitamin']}กรัม<br>โซเดียม: {$lunch['Sodium']}กรัม
            </div></div>
            <form method='post' id='lunch-form'>
            <button type='button' name='match' value='{$lunch['Id']}' class='lunch-button' id='yes-button'>กิน</button>
            <button type='button' name='noMatch' value='noMatch' class='no-button' id='no-lunch'>ไม่กิน</button>
            </form><br>";
        echo $lunch_menu;
        $dinner = array_shift($menu);
        echo "<h1>มื้อเย็น</h1>";
        $dinner_menu = "<div class='menubox' id='dinner-menu-container'>
            <h2>เมนู: {$dinner['Menu_Name']}</h2>
            <div class='menuinfo'>วัตถุดิบ: {$dinner['Ingredients']}<br>
            แคลอรี่: {$dinner['Calories']}กิโลแคลอรี่<br>
            คาร์โบไฮเดรต: {$dinner['Carbohydrate']}กรัม<br>โปรตีน: {$dinner['Protein']}กรัม<br>ไขมัน: {$dinner['Fat']}กรัม<br>วิตามิน: {$dinner['Vitamin']}กรัม<br> โซเดียม: {$dinner['Sodium']}กรัม
            </div></div>
            <form  method='post' id='dinner-form'>
            <button type='button' name='match' value='{$dinner['Id']}' class='dinner-button' id='yes-button'>กิน</button>
            <button type='button' name='noMatch' value='dinner' class='no-button' id='no-dinner'>ไม่กิน</button>
            </form>";
        echo $dinner_menu;
    } else {
        echo "ไม่เจอเมนูที่เหมาะกับคุณ ไปกินขี้ซะ ไอ้โง่";
    }
    if (isset($_POST['noMatch']) && $_POST['noMatch'] === 'breakfast') {
        $newRandmenu_sql = "SELECT * FROM menu ORDER BY RAND() LIMIT 1";
        $newRandmenu_result = $con->query($newRandmenu_sql);
        $newRandmenuRow = $newRandmenu_result->fetch_assoc();
        $menu = json_encode($newRandmenuRow);
        exit();
    }
    ?>
    <script src="match.js"></script>
</body>

</html>