<?php
require_once 'function.php';
require_once 'DBconnect.php';

function passwordCheck(){
    $pass = $_POST["pass"];
    $passVerif= $_POST["passVerif"];

    if($pass == $passVerif){
        echo '<label class="text-success"><span class="glyphicon glyphicon-remove"></span> Passwords match</label>';
    }else {
        echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> Passwords not match</label>';
    }
}

function check_email_availability(){
    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> Invalid Email</span></label>';
    } elseif(is_email_available($_POST["email"])) {
        echo '<label class="text-success"><span class="glyphicon glyphicon-ok"></span> Email Available</label>';
    }else {
        echo '<label class="text-danger"><span class="glyphicon glyphicon-remove"></span> Email Already register</label>';
    }
}

function is_email_available($email){
    $conn = connect();
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if($query->num_rows == 0) {
        return true;
    } else {
        return false;
    }
}


$userID = '';
if (isset($_SESSION['user'])){
    $userID = $_SESSION['user'];
}
elseif (isset($_SESSION['admin'])){
    $userID = $_SESSION['admin'];
}
else{
    $userID = $_SESSION['superadmin'];
}
function getUserFirstName($userID){
    $conn = connect();
    $res=mysqli_query($conn, "SELECT * FROM users WHERE userID=".$userID);
    $userRow=mysqli_fetch_array($res, MYSQLI_ASSOC);
    $conn->close();
    return $userRow['firstName'];

}


function addAnimal($name,$species,$birth,$adoptableSince,$animalImg,$type,$website,$hobby, $address,$zip,$city,$country, $coordX, $coordY){
    $conn = connect();
    $name = clearString($name);
    $species = clearString($species);
    $birth = clearString($birth);
    $adoptableSince = clearString($adoptableSince);
    $animalImg = clearString($animalImg);
    $type = clearString($type);
    $website = clearString($website);
    $address = clearString($address);
    $zip = clearString($zip);
    $city = clearString($city);
    $country = clearString($country);
    $coordX = clearString($coordX);
    $coordY = clearString($coordY);

    $sqlSearch = "SELECT * FROM locations WHERE address = '$address' AND zip = '$zip' AND city = '$city' AND country = '$country'";
    $res = mysqli_query($conn, $sqlSearch);
    if($res->num_rows == 0){

        $sql1 = "
    INSERT INTO `locations`(`address`, `zip`, `city`, `country`, `coordX`, `coordY`) VALUES ('$address', '$zip', '$city' , '$country', '$coordX', '$coordY' )";
    $res1 = mysqli_query($conn, $sql1);
    $last_idLocation =  mysqli_insert_id($conn);
    }else {
        $result = $res->fetch_assoc();
        $last_idLocation = $result["locationID"];

    }

    $sqlSearchAnimal = "SELECT * FROM animals WHERE name = '$name' AND species= '$species' AND birthdate='$birth' ";
    $resAnimal = mysqli_query($conn, $sqlSearchAnimal);
    if($resAnimal->num_rows == 0){
        $sql = "INSERT INTO `animals`(`name`, `species`,`birthdate`,`adoptableSince`,`animalImg`,`type`,`website`, `fk_locationID`) VALUES ('$name','$species','$birth','$adoptableSince','$animalImg','$type','$website','$last_idLocation')";
        mysqli_query($conn, $sql);
        $last_idAnimal =  mysqli_insert_id($conn);
    }else {
        $result2 = $resAnimal->fetch_assoc();
        $last_idAnimal = $result["animalID"];
    }


    foreach ( $hobby as $hobbyElement){
        $hobbyElement = clearString($hobbyElement);
        $sql2 = "INSERT INTO `hobbies`(`hobbyName`, `fk_animalID`) VALUES ('$hobbyElement','$last_idAnimal')";
        $finalRes = mysqli_query($conn, $sql2);
    }
    if($finalRes){
        $conn->close();
        return true;
    }else {
        $conn->close();
        return "error";
    }

}


function deleteAnimal($id){
    $conn = connect();
    $sql = "DELETE FROM `animals` WHERE animalID = $id";

    $res= mysqli_query($conn, $sql);
    $conn->close();
    return $res;
}

function updateAnimal( $id, $name,$species,$birthdate,$adoptableSince,$animalImg,$type,$website, $hobby, $address,$zip,$city,$country, $coordX, $coordY, $adoptedBy){
    $conn = connect();
    $name = clearString($name);
    $birthdate = clearString($birthdate);
    $species = clearString($species);
    $adoptableSince = clearString($adoptableSince);
    $animalImg = clearString($animalImg);
    $type = clearString($type);
    $website = clearString($website);
    $address = clearString($address);
    $zip = clearString($zip);
    $city = clearString($city);
    $country = clearString($country);
    $coordX = clearString($coordX);
    $coordY = clearString($coordY);
    $adoptedBy = clearString($adoptedBy);
    if ($adoptedBy == ''){
        $adoptedBy = null;
    }

     $sql1 = "
    UPDATE `locations` SET `address` = '$address', `zip` = '$zip', `city` = '$city', `country` = '$country', `coordX`='$coordX', `coordY`='$coordY' WHERE locationID = (select fk_locationID from animals WHERE animalID = $id)  ";
    $resLoc = mysqli_query($conn, $sql1);

    $sql2 = "UPDATE `animals` SET `name`= '$name',`species` = '$species', `birthdate` = '$birthdate',  `adoptableSince` = '$adoptableSince', `animalImg` = '$animalImg', `type` = '$type', `website` = '$website', `adoptedByUserID` = '$adoptedBy' WHERE animalID = $id  ";
    $resAnimal = mysqli_query($conn, $sql2);
    addHobbies($conn, $id, $hobby);

    if($resLoc == true && $resAnimal == true){
        $conn->close();
        return true;
    } else {
        $conn->close();
        return "error";
    }

}




function animalDetail($animalID){
    $conn = connect();
    $sql = "SELECT  * FROM `animals`
INNER JOIN locations ON animals.fk_locationID = locationID 
LEFT JOIN users ON animals.adoptedByUserID = userID 
INNER JOIN hobbies ON hobbies.fk_animalID = animalID
where animalID= $animalID";
//to keep animals even if noone adopted
    $animal=mysqli_query($conn, $sql);
    $result = $animal->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

function addHobbies($conn, $id, $hobby){
    foreach ( $hobby as $hobbyElement){
        $hobbyElement = clearString($hobbyElement);
        if ($hobbyElement !== ''){
            $sql = "INSERT INTO `hobbies`(`hobbyName`, `fk_animalID`) VALUES ('$hobbyElement','$id')";
            $hobbyRes = mysqli_query($conn, $sql);
        }
    }
    return $hobbyRes;
}

function nameAdoptUser(){
    $conn = connect();
    $sql = "SELECT  userID, lastName FROM `users`";
    $users=mysqli_query($conn, $sql);
    $resultUsers = $users->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $resultUsers;
}

function getUserDetails(){
        $conn = connect();
        $userID = $_GET['userID'];
        $sql = "SELECT userID, firstName, lastName, address, birth, userImg, userStatus, activated, zip,city,country, coordX, coordY FROM `users`
        left JOIN locations ON users.fk_locationID = locationID 
        where userID= $userID";
        $result = mysqli_query($conn, $sql);
        $userInfo = mysqli_fetch_assoc($result);
        // $response array
        $response['data']=$userInfo;
        //Generating JSON from the $response array
        $json_response=json_encode($response);
        // Outputting JSON to the client
        mysqli_close($conn);
        return $json_response;
}

function updateUser( $id,$activated, $firstName,$lastName,$birth,$status,$userImg, $address,$zip,$city,$country, $coordX, $coordY){
    $conn = connect();
    $firstName = clearString($firstName);
    $birth = clearString($birth);
    $lastName = clearString($lastName);
    $status = clearString($status);
    $userImg = clearString($userImg);
    $activated = clearString($activated);
    $address = clearString($address);
    $zip = clearString($zip);
    $city = clearString($city);
    $country = clearString($country);
    $coordX = clearString($coordX);
    $coordY = clearString($coordY);


    $sql1 = "
    UPDATE `locations` SET `address` = '$address', `zip` = '$zip', `city` = '$city', `country` = '$country', `coordX`='$coordX', `coordY`='$coordY' WHERE locationID = (select fk_locationID from users WHERE userID = $id)  ";
    $resLoc = mysqli_query($conn, $sql1);

    $sql2 = "UPDATE `users` SET `firstname`= '$firstName',`lastName` = '$lastName', `birth` = '$birth',  `userStatus` = '$status', `userImg` = '$userImg', `activated` = '$activated'  WHERE userID = $id  ";
    $resUser = mysqli_query($conn, $sql2);

    if($resLoc == true && $resUser == true){
        $conn->close();
        return true;
    } else {
        $conn->close();
        return "error";
    }
}
?>
