// Controller for user profile/account page

var UserController = {
    setupProfilePage: function() {
        var currentUser = {};

        UserService.getPorfile()
            .then((response) => {
                const user = response.data;
                currentUser = user;
                $('#profile-fullName').text((user.FirstName || '') + ' ' + (user.LastName || ''));
                let roleText = "Customer";
                if (user.role && user.role.toLowerCase() === "admin") {
                    roleText = "ADMIN";
                }
                $('#profile-role').text(roleText);
                $('#profile-firstName').text(user.FirstName || 'N/A');
                $('#profile-lastName').text(user.LastName || 'N/A');
                $('#profile-email').text(user.email || user.Email || 'N/A');
                $('#profile-phone').text(user.Phone || 'N/A');
                $('#profile-driverLicence').text(user.DriverLicence || user.DriverLicense || 'N/A');
                $('#profile-country').text(user.country || 'N/A');
                $('#profile-City').text(user.city || 'N/A');
                $('#profile-address').text(user.address || 'N/A');
                $('#profile-zip').text(user.zip || 'N/A');
            })
            .catch((error) => {
                console.error('Error fetching user profile:', error);
            });

        $('#editModal').on('show.bs.modal', function () {
            function setField($input, $preview, value, label) {
                if (typeof value === "undefined" || value === null || value === "" || value === "N/A") {
                    $input.val('');
                    $preview.text('Current: N/A');
                    $input.attr('placeholder', 'Write your ' + label + ' Here');
                } else {
                    $input.val(value);
                    $preview.text('Current: ' + value);
                    $input.attr('placeholder', '');
                }
            }
            setField($('#edit-firstName'), $('#preview-firstName'), currentUser.FirstName, 'First Name');
            setField($('#edit-lastName'), $('#preview-lastName'), currentUser.LastName, 'Last Name');
            setField($('#edit-phone'), $('#preview-phone'), currentUser.Phone, 'Phone');
            setField($('#edit-driverLicence'), $('#preview-driverLicence'), currentUser.DriverLicence, 'Driver Licence');
            setField($('#edit-country'), $('#preview-country'), currentUser.country, 'Country');
            setField($('#edit-city'), $('#preview-city'), currentUser.city, 'City');
            setField($('#edit-address'), $('#preview-address'), currentUser.address, 'Address');
            setField($('#edit-zip'), $('#preview-zip'), currentUser.zip, 'Zip');
        });

        $('#edit-user-form').on('submit', function(e) {
            e.preventDefault();
            const updatedUser = {
                FirstName: $('#edit-firstName').val(),
                LastName: $('#edit-lastName').val(),
                Phone: $('#edit-phone').val(),
                DriverLicence: $('#edit-driverLicence').val(),
                country: $('#edit-country').val(),
                city: $('#edit-city').val(),
                address: $('#edit-address').val(),
                zip: $('#edit-zip').val()
            };
            UserService.updateProfile(updatedUser, function(success) {
                if (success) {
                    location.reload();
                }
            });
            $('#editModal').modal('hide');
        });

        $('#edit-btn').on('click', function (e) {
            e.preventDefault();
            // Bootstrap's data-bs-toggle handles showing the modal
        });
    }
};
