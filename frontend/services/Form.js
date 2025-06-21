var FormService = {
    createForm: function(formData) {
        const token = localStorage.getItem("user_token");
        if (!token) {
            alert("You are not authorized to perform this action.");
            return $.Deferred().reject("Missing token").promise();
        }
        return $.ajax({
            url: Constants.PROJECT_BASE_URL + 'form/create',
            type: "POST",
            data: JSON.stringify(formData),
            contentType: "application/json",
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            }
        });
    },
    getAllForms: function() {
        const token = localStorage.getItem("user_token");
        return $.ajax({
            url: Constants.PROJECT_BASE_URL + "form/all",
            type: "GET",
            contentType: "application/json",
            dataType: "json",
            beforeSend: function(xhr) {
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
            }
        });
    },
    changeStatus: function(formId, status) {
        const token = localStorage.getItem("user_token");
        return $.ajax({
            url: Constants.PROJECT_BASE_URL + "form/status/" + formId,
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify({ Status: status }),
            beforeSend: function(xhr) {
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
            }
        });
    },
    handleContactForm: function(formSelector, successSelector, errorSelector) {
        $(formSelector).on('submit', function(e) {
            e.preventDefault();
            var formData = {
                FullName: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                Message: $('#message').val(),
                Status: "pending"
            };
            FormService.createForm(formData)
                .done(function(response) {
                    $(successSelector).removeClass('d-none');
                    $(errorSelector).addClass('d-none');
                    $(formSelector)[0].reset();
                })
                .fail(function(xhr) {
                    $(errorSelector).removeClass('d-none');
                    $(successSelector).addClass('d-none');
                });
        });
    }
};