function uploadProfilePic() {
    // Get the selected file from the input element
    var fileInput = document.getElementById('profile-pic-input');
    var file = fileInput.files[0];

    // Create a FormData object to send the file data
    var formData = new FormData();
    formData.append('profile-pic', file);

    // Make an AJAX request to upload the profile picture
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload_profile_pic.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                // If upload is successful, display a success message
                alert(response.message);

                // Call the function to update the profile picture
                updateProfilePicture(response.newImagePath);
            } else {
                // If upload failed, display an error message
                alert('Error: ' + response.message);
            }
        }
    };
    // Send the FormData object with the file
    xhr.send(formData);
}

// Function to update the user's profile picture
function updateProfilePicture(newImagePath) {
    var profilePicElement = document.getElementById('profile-pic');
    profilePicElement.src = newImagePath;
}