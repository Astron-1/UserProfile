$(document).ready(function () {
     // Function to send data to the server
     function sendDataToServer(url, formData, successCallback, errorCallback) {
       $.ajax({
         url: url,
         type: "POST",
         dataType: "json",
         data: formData,
         success: function (response) {
           successCallback(response);
           
         },
         error: function (xhr, status, error) {
           errorCallback(error);
         }
       });
     }
   
     // Function to handle form submission and update profile
     $("#regBtn").click(function () {
       var emailInput = $("#email").val();
       var nameInput = $("#Name").val();
       var dobInput = $("#DOB").val();
       var contactInput = $("#Contact").val();
       var stateInput = $("#inputState").val();
       var cityInput = $("#inputCity").val();
       var zipInput = $("#inputZip").val();
       var addressInput = $("#inputAddress").val();
   
       // Perform client-side validation here if needed
   
       var formData = {
         email: emailInput,
         name: nameInput,
         dob: dobInput,
         contact: contactInput,
         state: stateInput,
         city: cityInput,
         zip: zipInput,
         address: addressInput
       };
   
       sendDataToServer("./php/profile.php", formData, function (response) {
         console.log("Server response:", response);
         if (response.status === 200) {
           alert("Profile updated successfully!");
         } else {
           alert("Failed to update profile. " + response.message);
         }
       }, function (error) {
         console.error("Error occurred:", error);
         alert("Failed to update profile. Please try again.");
       });
     });
   
     // Function to handle logout button click
     $("#logoutBtn").click(function () {
       // Clear any user session data (if you have implemented session handling)
       // For example, you can remove the sessionToken from local storage
       localStorage.removeItem("sessionToken");
   
       // Redirect to the login page
       window.location.href = "./login.html";
     });
   });
   