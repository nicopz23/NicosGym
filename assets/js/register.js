$(document).ready(function () {

    $(".password").keyup((e) => { 
        if (($("#password").val() === $("#repassword").val()) && $("#password").val().length > 4){
            $("#btnregister").prop("disabled", false);
        }else{
            $("#btnregister").prop("disabled", true);
        }
    })

    $("#email").change((ex) => { 
        let email = $("#email").val();
        fetch('email.php', {
            method : 'POST',
            headers : {
                'Content-Type' : 'application/json',
            },
            body : JSON.stringify({ dato: email}), 
        })
        .then(response => {
            if(!response.ok){
                throw new Error('La solicitud Fetch no fue exitosa');
            }
            return response.json();
        })
        .then(data => {
            if(data.error === "email duplicado"){
                console.log("El correo electrónico ya está en uso.");
            }else{
                console.log("El correo electrónico está disponible.");
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});