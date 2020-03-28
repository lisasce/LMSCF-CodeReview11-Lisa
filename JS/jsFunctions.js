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


});
