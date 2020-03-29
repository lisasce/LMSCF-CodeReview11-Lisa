<?php
ob_start();
session_start();
require_once 'database/dbAccess.php';
// if session is not admin and also not user, this will redirect to login page
if(!isset($_SESSION['admin']) && !isset($_SESSION['user']) && !isset($_SESSION['superadmin'])) {
    header("Location: index.php");
    exit;
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

        <div class="flip-box m-2">
            <div class="flip-box-inner">
                <div class="flip-box-front">
                    <img src="img/moz.jpg" alt="Paris" style="width:330px;height:220px">
                </div>
                <div class="flip-box-back p-2">
                    <br>
                    <h2>Taz + Angelika</h2>
                    <p>Our morning session &#128522; </p><p>and this since 20 years already! I'm so grateful that you made us meet &#x2764;</p>
                </div>
            </div>
        </div>
        <div class="flip-box m-2">
            <div class="flip-box-inner">
                <div class="flip-box-front">
                    <img src="img/lisaTaz.jpg" alt="Paris" style="width:330px;height:220px">
                </div>
                <div class="flip-box-back p-2">
                    <br>
                    <h2>Lili + Tazounours</h2>
                    <p>Me and my BFF</p><p>&#x2764; &#x2764; &#x2764; &#x2764; &#x2764; &#x2764; &#x2764; &#x2764; </p>
                </div>
            </div>
        </div>
        <div class="flip-box m-2">
            <div class="flip-box-inner">
                <div class="flip-box-front">
                    <img src="img/peter.jpg" alt="Paris" style="width:330px;height:220px">
                </div>
                <div class="flip-box-back p-2">
                    <br>
                    <h2>Peter + Moritz</h2>
                    <p>Trying to get some work done with the perfect assistant ever, thanks my friend!  </p><p>💪 &#128522;</p>
                </div>
            </div>
        </div>
        <div class="flip-box m-2">
            <div class="flip-box-inner">
                <div class="flip-box-front">
                    <img src="img/orange.jpg" alt="Paris" style="width:330px;height:220px">
                </div>
                <div class="flip-box-back p-2">
                    <br>
                    <h2>Ipad-Cat + Ari</h2>
                    <p> &#128522; </p><p>Always looking football together and falling asleep - guess who? 😂</p>
                </div>
            </div>
        </div>
        <div class="flip-box m-2">
            <div class="flip-box-inner">
                <div class="flip-box-front">
                    <img id="lenny" src="img/lisaLenny.jpg" alt="Paris" style="width:330px;height:220px">
                </div>
                <div class="flip-box-back p-2">
                    <br>
                    <h2>Family Smith + Lenny</h2>
                    <p>Thanks dear True Friendship Team for letting us adopting Lenny! She is so kind and as you can see, we also got a nice surprise! 😉</p>
                </div>
            </div>
        </div>
        <div class="flip-box m-2">
            <div class="flip-box-inner">
                <div class="flip-box-front">
                    <img src="img/guizmo.jpg" alt="Paris" style="width:330px;height:220px">
                </div>
                <div class="flip-box-back p-2">
                    <br>
                    <h2>Guizmo + Lisa</h2>
                    <p> &#x2764;<br>
                    You're the love of my life, my best friend, my baby, my everthing. There is no word on earth to describe our relationship...<br> &#x2764;</p>
                </div>
            </div>
        </div>

    </div>
</div>
<footer class="navbar navbar-expand-lg navbar-dark bg-dark  mt-1 mt-sm-5 mb-0">
    <a class="navbar-brand" href="#">True &#x2764;</a>
</footer>

</body>
</html>
<?php ob_end_flush(); ?>
