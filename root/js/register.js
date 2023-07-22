
window.onload = function(e) {
  let email=document.querySelector("#email");
    email.value=null
}; 


$(document).ready(function () {
  
     $("#regBtn").click(function () {
       var emailInput = $("#email").val();
       var passwordInput = $("#password").val();
   
       var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
       if (!emailRegex.test(emailInput)) {
         $("#email-error").removeClass("warning");
         return;
        } else {
        //  console.log("mail Success"); just for testing purpose
         $("#email-error").addClass("warning");
       }
       var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
       if (!passwordRegex.test(passwordInput)) {
        $("#password-error").removeClass("warning");
        return;
      } else {
        // console.log("pass success"); just for testing purpose
        $("#password-error").addClass("warning");
      }

      var formData = {
        email: emailInput,
        password: passwordInput
      };
      // console.log("you are in ajax");
      $.ajax({
        url: "./php/register.php", 
        type: "POST",
        dataType: "json", 
        data: formData, 
        success: function (response) {
          // Handle the server's response here (if needed)
          console.log("Server response: ", response);
          if(response[1].status>=200 || response[1].response<300){
            alert("SuccessFully Registered");
            $(changeURL).click();

          }else{
            alert("Some error Ocuured")
          }
  
          // Process the response and update the page accordingly
          // For example, you can show a success message or redirect the user
          // to another page using JavaScript here
        },
        error: function (xhr, status, error) {
          // Handle errors if any
          console.error("Error occurred:", error);
          alert("some error occured.Try Again");
        }
      });
     });
   });
   

  $(changeURL).click(function () {
       $.ajax({
            url: "./login.html",
            type: "GET",
            dataType: "html",
            success: function (data) {
              $("#content-container").html(data);
            },
            error: function (xhr, status, error) {
              console.error("Error loading the page: " + error);
            }
          });
  });
