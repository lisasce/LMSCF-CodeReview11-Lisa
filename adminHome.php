<?php
ob_start();
session_start();
require_once 'database/dbAccess.php';
$conn = connect();
// if session is not admin and also not user, this will redirect to login page
if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
if(isset($_SESSION['user'])){  //if you are a user but not an admin
    header("Location: home.php");
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

    <div id="animalContent" class="container mt-sm-5 ">
        <div id="message" class="row">
            <?php
            $typeQ= "SELECT * FROM animals  INNER JOIN `locations` ON `fk_locationID`= `locationID`  ";
            $animal=mysqli_query($conn, $typeQ);
            $animalRow = $animal->fetch_all(MYSQLI_ASSOC);

            foreach ($animalRow as $value) {
                echo "<div class='AnimalVisibility mx-auto text-center card p-2' style='width: 15rem;'>
                              <img class='card-img-top ' src='". $value['animalImg']."' alt='Card image cap'>
                              <div class='card-body'>
                                <h5 class='card-title'><strong>" . $value["name"] . "</strong></h5>
                                <p class='card-text'>" . $value["species"] . " <br> " . $value["city"] ."</p>
                                <p><a class='btn btn-secondary mt-1 mb-1' href='showDetail.php?id=".$value['animalID']."'>Details</a><a class='btn btn-danger' href='deleteAnimal.php?id=".$value['animalID' ]."'>Delete</a> 
                            <a class=' btn btn-warning ' href='updateAnimal.php?id=".$value['animalID']."'>Update</a></p>
                              </div>
                            </div>";
            }
            ?>
        </div>
    </div>
</div>
<footer class="navbar navbar-expand-lg navbar-dark bg-dark  mt-1 mt-sm-5 mb-0">
    <a class="navbar-brand" href="#">True &#x2764;</a>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    var request;
    // Bind to the submit event of our form (id for the form tag)
    $("#input").keyup(function(event){
        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        // Abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var $form = $(this);
        // Let's select and cache all the fields
        var $inputs = $form.find("input, select, button, textarea");
        // Serialize the data in the form
        var serializedData = $form.serialize();
        // Let's disable the inputs for the duration of the Ajax request.
        // Note: we disable elements AFTER the form data has been serialized.
        // Disabled form elements will not be serialized.
        $inputs.prop("disabled", true);
        // Fire off the request to /form.php
        request = $.ajax({
            url: "database/searchBar.php",
            type: "post",
            data: serializedData
        });
        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // Log a message to the console
            console.log("request status: success");
            document.getElementById("message").innerHTML = response;

        });
        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });
        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // Reenable the inputs
            $inputs.prop("disabled", false);
            if($("#input").val() != ''){
                $(".AnimalVisibility").hide();
            }
            else{
                $(".AnimalVisibility").show();
                $("#message").html("");
            }
        });
    });
</script>
</body>
</html>
<?php ob_end_flush(); ?>
