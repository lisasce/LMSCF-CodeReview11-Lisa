$(document).ready(function(){
    $('#email').keyup(function(){
        var email = $(this).val();
        if(email != '')
        {
            $.ajax({
                url:"actions/emailCheckAjax.php",
                method:"POST",
                data:{email:email},
                success:function(response){
                    $('#email_result').html(response);
                }
            });
        }
    });

    $('#passVerif').keyup(function(){
        var passVerif = $(this).val();
        var password = $('#pass').val();
        if(passVerif !== '' && password !== "")
        {
            $.ajax({
                url:"actions/passwordCheck.php",
                method:"POST",
                data:{pass:password,passVerif:passVerif},
                success:function(response){
                    $('#pw_result').html(response);
                }
            });
        }
    });

 function  addHobbyField(event){
    let inputField = $("#hobby")[0];
    let newField = inputField.cloneNode();
    newField.id = undefined;
    newField.value = "";
    let lastInput = event.currentTarget.previousElementSibling;
    lastInput.parentElement.insertBefore(newField, lastInput);
 }
$(".adding").click(addHobbyField);

    $('#userSelect').change(function(){
        let value = $(this).val();
        if(value != '')
        {
            $.get("actions/getUserInfos.php?userID="+value,
                function(response){
                    let data = JSON.parse(response).data;
                    $("#firstName").val(data.firstName);
                    $("#lastName").val(data.lastName);
                    $("#birth").val(data.birth);
                    $("#userImg").val(data.userImg);
                    $("#userAddress").val(data.address);
                    $("#userCity").val(data.city);
                    $("#userZip").val(data.zip);
                    $("#userCountry").val(data.country);
                    $("#userCoordX").val(data.coordX);
                    $("#userCoordY").val(data.coordY);
                    $("#status").val(data.userStatus);
                    if (data.activated == "no"){
                        $("#disabled").prop("checked", true);
                    }else{
                        $("#activated").prop("checked", true);
                    }
                });
        }
    });
});
