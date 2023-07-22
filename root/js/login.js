window.onload = function(e) {
     let email=document.querySelector("#loginEmail");
       email.value=null
   }; 
   
   
   $(document).ready(function () {
     
        $("#loginBtn").click(function () {
          var emailInput = $("#loginEmail").val();
          var passwordInput = $("#loginPassword").val();
      
          var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(emailInput)) {
            $("#loginEmail-error").removeClass("warning");
            return;
           } else {
           //  console.log("mail Success"); just for testing purpose
            $("#loginEmail-error").addClass("warning");
          }
          var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
          if (!passwordRegex.test(passwordInput)) {
           $("#loginPassword-error").removeClass("warning");
           return;
         } else {
           // console.log("pass success"); just for testing purpose
           $("#loginPassword-error").addClass("warning");
         }
   
         var formData = {
           email: emailInput,
           password: passwordInput
         };
         // console.log("you are in ajax");
         $.ajax({
           url: "./php/login.php", 
           type: "POST",
           dataType: "json", 
           data: formData, 
           success: function (response) {
             // Handle the server's response here (if needed)
             console.log("Server response: ", response);
             if (!response || typeof response !== "object") {
               console.error("Invalid response format.");
               alert("Login failed. Please try again.");
               return;
             }
       
             if(response['status']==200){
               alert("SuccessFully Login");
               $.ajax({
                    url: "./profile.html",
                    type: "GET",
                    dataType: "html",
                    success: function (data) {
                      $("#content-container").html(data);
                    },
                    error: function (xhr, status, error) {
                      console.error("Error loading the page: " + error);
                    }
                  });
             }else{
               alert("Some error Ocuured")
               console.error(error);
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


      

$("#changeURLReg").click(function () {
     $.ajax({
          url: "./register.html",
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


function isLoggedIn() {
  var sessionToken = localStorage.getItem('sessionToken');
  return sessionToken !== null;
}
if (isLoggedIn()) {
  $.ajax({
    url: "./profile.html",
    type: "GET",
    dataType: "html",
    success: function (data) {
      $("#content-container").html(data);
    },
    error: function (xhr, status, error) {
      console.error("Error loading the page: " + error);
    }
  });
}