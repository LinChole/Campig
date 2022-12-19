<?php
$prompt = "";
$userName = "";
$userPassword = "";

//
if (isset($_POST["btnOK"])) {
  $userName = $_POST["account"];
  $userPassword = $_POST["password"];


  //帳號或密碼如果是空字串顯示"請輸入帳號密碼"
  // if ($user != "" && $userPassword != "") {
  // }
  // else {
  //     $prompt = "請輸入帳號密碼";
  //   }

  //建立連線，查詢取得紀錄數
  $link = mysqli_connect("localhost", "root", "root", "insider");
  // $sql = "SELECT * FROM `userInfo` WHERE `account` =$userName AND `password` = $userPassword ";
  $sql = "SELECT * FROM `userInfo` WHERE `account` =$userName";

  $result = mysqli_query($link, $sql);
  $row = mysqli_fetch_assoc($result);//取得陣列
  $total = mysqli_num_rows($result);//取得數字

 
    //如果記錄數大於0，表示有紀錄session=true，登入成功
    if ($row['account']==$userName && $row['password']==$userPassword) {
      setCookie("account", $userName);

      echo $row['account'];
      $_SESSION["login_session"] = true;
      header("location: login.php");
     
     
    }else {

      $prompt = "帳號密碼錯誤";
      // $_SESSION["login_session"] = false;
      
    }
  
}

// }


//如果登入顯示帳號名，不是就顯示guest
if (isset($_COOKIE["account"])) {
  $userName = $_COOKIE["account"];
} else {
  $userName = "Guest";
}


//登出cookie設定昨天日期
if (isset($_POST["btnOut"])) {
  setcookie("account", "Guest", time() - 60 * 60 * 24);
  header("location: login.php");
}


//註冊
if (isset($_POST["okButton"])) {
    $user = $_POST["account"];
    $psw = $_POST["password"];
    $userNamel = $_POST["Name"];
    $tel = $_POST["tel"];



    $userNameed = "SELECT * FROM `userInfo` WHERE account =$user";

    $link = mysqli_connect("localhost", "root", "root", "insider");
    $result = mysqli_query($link, $userNameed);
    $row = mysqli_fetch_assoc($result);


   
    if ($row == null) {
        $sqlCommand = "INSERT INTO `userInfo` (`uid`, `account`, `password`, `Name`, `tel`) VALUES (NULL, '$user', '$psw', '$userNamel', '$tel');";
        $link = mysqli_connect("localhost", "root", "root", "insider");

        mysqli_query($link, $sqlCommand);

        $prompt = "註冊成功";
    } else {
        $prompt = "此帳號已註冊";

        // echo "此帳號已註冊";
    }

    // 如果有異動到資料庫數量(更新資料庫)
    //     if (mysqli_affected_rows($link) > 0) {
    //         // 如果有一筆以上代表有更新
    //         // mysqli_insert_id可以抓到第一筆的id
    //         $new_id = mysqli_insert_id($link);
    //         echo "新增後的id為 {$new_id} ";
    //     } elseif (mysqli_affected_rows($link) == 0) {
    //         echo "無資料新增";
    //     } else {
    //         echo "{$sqlCommand} 語法執行失敗，錯誤訊息: " . mysqli_error($link);
    //     }
    //     mysqli_close($link);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="RBC">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員</title>

    <link rel="stylesheet" href="./login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans">
    <link rel="stylesheet" href="./_css/bootstrap.css">
    <script src="./_js/bootstrap.bundle.js"></script>
    <style>
        body {
            font-family: "Open Sans", sans-serif;
        }

        .modal_car {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 200px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal_content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 20%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <div class="container_inner">
        <!-- 頁首 -->
        <div class="header_inner">
            <div class="head" id="top">
                <div class="logo ">
                    <a href="campig.html"><img src="./img/logo_block_1.jpg" alt="logo" style="width:150px; height:50px;"></a>
                </div>

                <div class="header_right">
                    <?php if ($userName == "Guest") { ?>
                        <a href="login.php"><img src="./img/user-solid.svg" alt="person" style="width: 35px; height:35px;"></a>
                    <?php } else { ?>
                        <span><?= "Hi ! " . $userName ?></span>
                    <?php } ?>
                    <a href="shoppingPage.html"><img src="./img/cart-shopping-solid.svg" alt="shoppingcar" style="width: 35px; height:35px; margin: 0 20px;"></a>
                    <!-- <input type="text" name="search" placeholder="Search"> -->
                </div>
            </div>
        </div>
        <!--導覽列  -->
        <nav class="navbar navbar-dark navbar-expand-lg position-fixed w-100">
            <div class="container-fluid">
                <a href="#" class="navbar-brand"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar_content">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar_content">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="./campig.html" class="nav-link actvie">首頁</a>
                        </li>
                        <li class="nav-item">
                            <a href="product.html" class="nav-link actvie">商品</a>
                        </li>
                        <li class="nav-item">
                            <a href="news.html" class="nav-link actvie">最新消息</a>
                        </li>
                        <li class="nav-item">
                            <a href="recmommed.html" class="nav-link actvie">營區推薦</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="inner">
            <div class="controlBtn">
                <div class="itemBtn">
                    <div class="active">登入</div>
                    <div style="margin-left: 5px;">註冊</div>
                </div>
                <div class="content">
                    <div style="display: block;" class="box1">
                        <form action="" method="post">
                            <label for="use1">帳號：</label>
                            <input type="text" name="txtUserName" value="" placeholder="">
                            <label for="use1">密碼：</label>
                            <input type="password" name="txtPassWord" value="<?= $userPassword ?>" pattern="[A-Z]{1}[a-z]{1}[0-9]{6}">
                            <br>
                            <input type="checkbox" name="remeber"><label>記住我</label>
                            <br>
                            <?php if ($userName == "Guest") : ?>
                                <input type="submit" class="shoppingLink" name="btnOK" id="btnOK" value="登入">
                            <?php else : ?>
                                <input type="submit" class="shoppingLink" name="btnOut" id="btnOut" value="登出">
                            <?php endif; ?>
                            <p class='show'><?= $prompt ?></p>
                        </form>
                    </div>
                    <div class="box2">
                        <form action="login.php" method="post">
                            <label for="account">帳號：</label>
                            <input type="text" placeholder="" name="account" value="" required>
                            <label for="password">密碼：</label>
                            <input type="password" placeholder="" name="password" value="" required>
                            <label for="Name">姓名：</label>
                            <input type="text" placeholder="" name="Name" value="" required>
                            <label for="tel">電話：</label>
                            <input type="text" placeholder="" name="tel" value="" maxlength="10" pattern="^09[0-9]{8}" required>
                            <br>
                            <input type="checkbox" name="agree"><label>我同意網站服務條例及隱私政策</label>
                            <br>
                            <!-- <button id="myBtn2">註冊</button> -->
                            <input class='popuptest' type="submit" name="okButton" value="送出">
                            <!-- <p class='show'></p> -->
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- The Modal -->
        <!-- <div id="myModal" class="modal"> -->

        <!-- Modal content -->
        <!-- <div class="modal-content">
                <span class="close">&times;</span>
                <p>登入成功！</p>
            </div>

        </div> -->

        <!-- 頁尾 -->
        <div class="footer_inner">
            <div class="footer_middel">
                <div class="aboutme">
                    <p style="font-size: 18px; text-shadow: 2px 6px grey;">關於我們</p>
                    <div class="icons">
                        <a href="https://www.Facebook.com" target="_blank"><img src="./image/首頁/icons8-facebook.svg" alt="" width="40px"></a>
                        <a href="https://www.instagram.com" target="_blank"><img src="./image/首頁/icons8-instagram.svg" alt="" width="40px"></a>
                        <a href="https://www.line.com" target="_blank"><img src="./image/首頁/icons8-line.svg" alt="" width="40px"></a>
                        <a href="https://www.twitter.com" target="_blank"><img src="./image/首頁/icons8-twitter.svg" alt="" width="40px"></a>
                    </div>
                </div>

                <div class="store">
                    <img src="./image/首頁/map.jpg" alt="logo" style="width:200px; height:100px; margin: 0 30px 10px 0;">
                    <div>
                        電話：
                        <a href="telto:042345678" style="color: white;">042-345678</a><br><br>
                        地址：
                        <a href="https://goo.gl/maps/TFn6TpqWjRa9WG2L6" style="color: white;">台中市西屯區台灣大道三段301號5樓</a>
                    </div>
                </div>
                <div class="open">
                    <p>
                        營業時間：
                        週一～週五 10:00~19:00<br><br>
                        聯絡我們：
                        <a href="mailto:service@campig.com" style="color: white;">service@campig.com</a>
                    </p>
                </div>
            </div>
            <div class="footer_bottom">
                <!-- <hr> -->
                <div>
                    <p>C@MP!G&#169有限公司 隱私條款｜條款及細則｜退換貨政策</p>
                    <p></p>
                </div>

            </div>
        </div>

    </div>

    <script>
        window.onload = function() {
            var item = document.querySelectorAll(".itemBtn");
            var it = item[0].querySelectorAll("div")
            var content = document.querySelectorAll(".content");
            var con = content[0].querySelectorAll("div");
            var na1 = document.querySelectorAll('[class="use1"]')
            var na2 = document.querySelectorAll('[class="use2"]')
            var span1 = document.querySelectorAll('.box2 span')
            var span2 = document.querySelectorAll('.box1 span')
            var zc = document.querySelector('[value="註冊"]')
            var dl = document.querySelector('[value="登入"]')

            console.log(span2)
            var userReg = /^[a-zA-Z][a-zA-Z0-9]{3,9}$/
            var telReg = /^[0-9a-zA-Z].{4,14}$/
            var emailReg = /(^[a-zA-Z]w{5,17}@((126|163).com|yeah.net)$)|(^[1-9]d{4,10}@qq.com$)/

            for (let i = 0; i < it.length; i++) {
                it[i].onclick = function() {
                    for (let j = 0; j < it.length; j++) {
                        it[j].className = '';
                        con[j].style.display = "none";
                    }
                    this.className = "active";
                    it[i].index = i;
                    con[i].style.display = "block";
                }
            }
        }
        var button = document.querySelector('.popuptest');
        var showtxt = document.querySelector('.show');

        // function popup2(e) {
        //     window.confirm('資料確認嗎？');
        //     if (confirm('確定送出嗎？') == true) {
        //         showtxt.innerHTML = 'Yes！註冊成功。';
        //     } else {
        //         showtxt.innerHTML = '您已取消確認！';
        //     }

        // };
        button.addEventListener('click', popup2);
        // Get the modal
        // var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>