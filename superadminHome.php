<?php
ob_start();
session_start();
require_once 'database/dbAccess.php';
$conn = connect();
// if session is not admin and also not user, this will redirect to login page
if(!isset($_SESSION['admin']) && !isset($_SESSION['user']) && !isset($_SESSION['superadmin'])) {
    header("Location: index.php");
    exit;
}
if(isset($_SESSION['user'])){  //if you are a user but not an admin
    header("Location: home.php");
    exit;
}
if(isset($_SESSION['admin'])){  //if you are a user but not an admin
    header("Location: adminHome.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>True Friendship</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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
            <img class="col-md-3 col-4 mx-auto ml-3 p-0" id="logo"  src="img/logo.JPG" alt="">
            <h1 class="font-weight-bold text-center col-md-6 col-12 mt-1">Welcome to True Friendship!</h1>
            <img class="col-md-2 col-4 mx-auto"  src="img/kitty.png" alt="">
        </div>
        <div class="text-center mb-3"><h6>&#x2764; Your personal animal love story provider &#x2764; </h6></div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-sm-5 ">
        <a class="navbar-brand" href="index.php">True &#x2764;</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active ml-5">
                    <a class="nav-link" id="add" href="addAnimal.php">Add a new animal</a>
                </li>
                <li class="nav-item active ml-5">
                    <a class="nav-link" id="add" href="superadminHome.php">Manage users</a>
                </li>
                <li class="nav-item active ml-5">
                    <a class="nav-link" id="add" href="adminHome.php">Admin's home</a>
                </li>
                <li class="nav-item active ml-5">
                    <a class="nav-link" id="add" href="home.php">User's home</a>
                </li>
                <li class="nav-item active ml-5">
                    <span class="nav-link" >Hi <?php echo getUserFirstName($userID); ?> !</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php?logout">Sign Out</a>
                </li>
            </ul>
        </div>
        <form id="form" class="form-inline active-cyan active-cyan-2 " autocomplete= "off">
            <i class="fas fa-search" aria-hidden="true"></i>
            <input id="input" class="form-control form-control-sm ml-3 w-100 pl-4"  type="text" name= "search" placeholder="  species, city or ZIP code"
                   aria-label="Search">
        </form>
    </nav>

    <div id="animalContent" class="container d-flex justify-content-around row mt-sm-5 mx-auto">

        <?php
        if($_POST){
            $id =  $_POST["userSelect"];
            $firstName =  $_POST["firstName"];
            $birth =  $_POST["birth"];
            $lastName =  $_POST["lastName"];
            $status =  $_POST["status"];
            $userImg =  $_POST["userImg"];
            $activated =  $_POST["activation"];
            $address = $_POST["userAddress"];
            $zip = $_POST["userZip"];
            $city = $_POST["userCity"];
            $country = $_POST["userCountry"];
            $coordX = $_POST["userCoordX"];
            $coordY = $_POST["userCoordY"];

            $result= updateUser($id,$activated, $firstName,$lastName,$birth,$status,$userImg, $address,$zip,$city,$country, $coordX, $coordY);

            if($result == TRUE){
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                          <a class=' btn btn-light'   href='superadminHome.php'>back to homepage</a>
                          <span class='pl-3'><strong>Thank you for UPDATING!</strong></span>    
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                          </button>
                        </div>
                        <br> ";
            }else{
                echo "error";
            }
        }
        ?>


        <form class="col-10 mx-auto" method="post"  action="superadminHome.php"  autocomplete="off" >

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect02">User:</label>
                </div>
                <select id="userSelect" name="userSelect" value="" class="custom-select" id="inputGroupSelect02"><option name='type' value='' >Choose user:  </option>
                    <?php
                    $users = nameAdoptUser();
                    foreach ($users as $user){
                        echo "<option name='type' value='".$user['userID']."'>".$user['lastName']." </option>";
                    }
                    ?>
                </select>
            </div>



            <h2>Here you can update the selected user's info:</h2>
            <hr />

            First Name:
            <input class ="form-control" type="text" name="firstName" id="firstName" value=""placeholder ="Enter first name"  maxlength ="50"  /><br>

            Last Name:
            <input class ="form-control" type="text" name="lastName" id="lastName" placeholder ="Enter last name"  maxlength ="40" value="" /><br>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="status">Status:</label>
                </div>
                <select name="status" value="" class="custom-select" id="status">
                    <option name="status" value="user" >user</option>
                    <option name="status" value="admin" >admin</option>
                    <option name="status" value="superadmin" >superadmin</option>
                </select>
            </div>

            Account activated:
            <br>
            <input class ="" type="radio" name="activation" id="activated" value="yes" />
            <label for="activated">yes</label>
            <input class ="" type="radio" name="activation" id="disabled" value="no" />
            <label for="disabled">no</label>
            <br>

            Birthdate:
            <input class ="form-control" type="date" name="birth" id="birth" placeholder ="Birthdate" value="" maxlength ="50"  /><br>


            User's image link:
            <input class ="form-control" type="text" name="userImg" id="userImg" placeholder ="Copy here a link for the user's picture:" value="" maxlength ="500"  /><br>

            Address:
            <input class ="form-control hobby" type="text" name="userAddress" id="userAddress" placeholder ="Enter user's Address" value="" maxlength ="50"  /><br>

            Zip Code:
            <input class ="form-control hobby" type="text" name="userZip" id="userZip" placeholder ="Enter zip code"  maxlength ="50" value="" /><br>

            City:
            <input class ="form-control hobby" type="text" name="userCity" id="userCity" placeholder ="Enter user's city"  maxlength ="50" value=""  /><br>

            Country:
            <input class ="form-control hobby" type="text" name="userCountry" id="userCountry" placeholder ="Enter animal's country" value="" maxlength ="50"  /><br>

            Coordinate Latitude:
            <input class ="form-control hobby" type="text" name="userCoordX" id="userCoordX" placeholder ="Enter city's latitude"  maxlength ="50" value="" /><br>

            Coordinate Longitude:
            <input class ="form-control hobby" type="text" name="userCoordY" id="userCoordY" placeholder ="Enter city's longitude"  maxlength ="50" value="" /><br>
            <hr />

            <button   type = "submit"   class = "btn btn-block btn-warning"   name = "updatebtn" >Update users's info</button >
            <hr  />

        </form >

    </div>
<footer class="navbar navbar-expand-lg navbar-dark bg-dark  mt-1 mt-sm-5 mb-0">
    <a class="navbar-brand" href="#">True &#x2764;</a>
</footer>
    <script src="JS/jsFunctions.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>
