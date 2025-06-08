// Controller for contact form

var FormController = {
    setupContactForm: function(formSelector, successSelector, errorSelector) {
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
