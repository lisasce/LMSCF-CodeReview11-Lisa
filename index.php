<?php
ob_start();
session_start();
require_once 'database/dbAccess.php';
require_once 'database/function.php';
$conn = connect();
if ( isset($_SESSION['user' ])!="") {
    header("Location: home.php");
    exit;
}
if(isset($_SESSION['admin']) != ''){
    header('Location: adminHome.php');
    exit;
}
if(isset($_SESSION['superadmin']) != ''){
    header('Location: superadminHome.php');
    exit;
}
$error = false;

if( isset($_POST['btn-login']) ) {
    $email = clearString($_POST["email"]);
    $pass = clearString($_POST["pass"]);

    if(empty($email)){
        $error = true;
        $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)){
        $error = true;
        $passError = "Please enter your password." ;
    }

    if (!$error) {

        $pass = hash( 'sha256', $pass); // password hashing
        $res=mysqli_query($conn, "SELECT * FROM users WHERE email='$email'" );
        $row=mysqli_fetch_array($res, MYSQLI_ASSOC);
        $count = mysqli_num_rows($res); // if name/pass is correct it returns must be 1 row

        if( $count == 1 && $row['userPass' ]==$pass ) {
            if($row['userStatus'] == 'user'){
                $_SESSION['user'] = $row['userID'];
                header( "Location: home.php");
            }elseif ($row['userStatus'] == 'admin') {
                $_SESSION['admin'] = $row['userID'];
                header("Location: adminHome.php");
            }else {
                $_SESSION['superadmin'] = $row['userID'];
                header("Location: superadminHome.php");
            }

        } else {
            $errMSG = "Incorrect Credentials, Try again..." ;
        }

    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>True Friendship</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Icon library -->
    <script src="https://kit.fontawesome.com/d94fa60402.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="adoption.css">
</head>
<body>
<div id="content">
    <div id="header" class="container-fluid ">
        <div class="d-flex justify-between row mt-3" >
        <img class="col-md-3 col-4 mx-auto ml-3 p-0" id="logo"  src="img/logo.jpg" alt="">
        <h1 class="font-weight-bold text-center col-md-6 col-12 mt-1">Welcome to True Friendship!</h1>
        <img class="col-md-2 col-4 mx-auto"  src="img/kitty.png" alt="">
        </div>
    <div class="text-center mb-3"><h6>&#x2764; Your personal animal love story provider &#x2764; </h6></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-sm-5 ">
        <a class="navbar-brand" href="#">True &#x2764;</a>
    </nav>

    <div id="animalContent" class="container  mt-sm-5">
        <div class="row d-flex justify-between mt-3 mb-3 ">
            <div class="col-md-6 col-10 mx-auto">
                <h2>Adopt an animal in search of a forever home</h2 >
                <hr />
                <p>By working with volunteers, foster families, local veterinarians, and animal shelters, we provide love, attention, time for healing, and medical support, all while carefully screening for new forever homes. New Love remains committed to our adopters and our placed animals long after the adoption process is completed.</p>
                <br>
            </div>
            <div class="col-md-3  col-6 text-right mx-auto" >
                <form method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete= "off">
                    <h5 class="ml-2" >Sign In.</h5 >
                    <hr />
                        <?php
                        if ( isset($errMSG) ) {
                            echo  $errMSG;
                        ?>
                        <?php } ?>
                    <input  type="email" id="loginEmail" name="email"  class="form-control m-1" placeholder= "Your Email" value="<?php echo $email; ?>"  maxlength="40" />
                    <span class="text-danger"><?php  echo $emailError; ?></span >
                    <input  type="password" id="loginPw" name="pass"  class="form-control m-1" placeholder ="Your Password" maxlength="25"  />
                    <span  class="text-danger"><?php  echo $passError; ?></span>
                    <hr />
                    <button class = "btn btn-block btn-secondary" type="submit" name= "btn-login">Sign In</button>
                    <hr />

                    <a  href="register.php">Sign Up Here...</a>

                </form>
            </div>
        </div>
    </div>
    <footer class="navbar navbar-expand-lg navbar-dark bg-dark  mt-1 mt-sm-5 mb-0">
        <a class="navbar-brand" href="#">True &#x2764;</a>
    </footer>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="JS/jsFunctions.js"></script>

</body>
</html>
<?php  ob_end_flush(); ?>
