<?php

require_once 'dbAccess.php';
$conn = connect();
$name =  isset($_POST['search']) ? $_POST["search"] : '';
if(!preg_match("/^[a-zA-Z ]*/",$name)) {
    echo "No result";
}else {
    $result = $conn->query("
SELECT * FROM `animals` 
INNER JOIN `locations` ON `fk_locationID`= `locationID`
WHERE `species` LIKE '$name%'
OR
`city` LIKE '$name%'
OR
`zip` LIKE '$name%'
");

$output = $result->fetch_all(MYSQLI_ASSOC);
foreach($output as $searchresult){

    echo "               <div class='text-center mx-auto card p-2' style='width: 15rem;'>
                              <img class='card-img-top ' src='". $searchresult['animalImg']."' alt='Card image cap'>
                              <div class='card-body'>
                                <h5 class='card-title'><strong>" . $searchresult["name"] . "</strong></h5>
                                <p class='card-text'>" . $searchresult["species"] . " <br> " . $searchresult["city"] ."</p>
                                <a class='btn btn-secondary mt-1 mb-1' href='showDetail.php?id=".$searchresult['animalID']."'>Details</a>                                                                                         
                              </div>
                            </div>";

}
}

?>
