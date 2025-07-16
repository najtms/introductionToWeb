var EmployeesService = {
    get_employees: function(){
      $.ajax({
        type: 'GET',
        url: Constants.get_api_base_url()+'/employees/performance',
        contentType: "application/json",
        dataType: "json",
              success: function(users) {
            var select = $("#employee-performance tbody");
            users.forEach(function(user) {
                select.append(`<tr>
                <td class="text-center">
                <div class="btn-group" role="group">
                <button
                type="button"
                class="btn btn-warning"
                onclick="EmployeesService.edit_employee(${user.employeeNumber})">
                Edit
               </button>
                <button
                type="button"
                class="btn btn-danger"
                onclick="EmployeesService.delete_employee(${user.employeeNumber})">
                Delete
              </button>
              </div>
              </td>
              <td>${user.FullName}</td>
              <td>${user.email}</td>
              <td>${user.salary}</td>
              </tr>`
                );
            }); 
        },
        error: function(xhr) {
            alert("Failed to load users.");
        }})
    },
    delete_employee: function(employee_id) {
        if (
          confirm(
            "Do you want to delete employee with the id " + employee_id + "?"
          ) == true
        ) {
          $.ajax({
            type: 'DELETE',
            url: Constants.get_api_base_url()+'/employee/delete/'+ employee_id,
            success: function(response){
              alert(response.message);
              EmployeesService.get_employees();
            },
            error: function(xhr, status, error) {
        console.error("Delete failed:", error);
        alert("Failed to delete employee.");
            }
          });
        }
    },
    edit_employee: function(employee_id){
        $.ajax({
            type: 'GET',
            url: Constants.get_api_base_url()+'/employee/' + employee_id,
            dataType: 'json',
            success: function(employee) {
                $('#employeeNumber').val(employee.employeeNumber);
                $('#firstName').val(employee.firstName);
                $('#lastName').val(employee.lastName);
                $('#email').val(employee.email);
                $('#edit-employee-modal').modal('show');
            },
            error: function(xhr) {
                alert('Failed to fetch employee data.');
            }
        });
    },
    save_employee: function(){
        var employee_id = $('#employeeNumber').val();
        var data = {
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            email: $('#email').val(),
            extension: '', 
            officeCode: '',
            jobTitle: ''
        };
        $.ajax({
            type: 'PUT',
            url: Constants.get_api_base_url+'/employee/edit/' + employee_id,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response){
                $('#edit-employee-modal').modal('hide');
                EmployeesService.get_employees();
                alert('Employee updated successfully!');
            },
            error: function(xhr) {
                alert('Failed to update employee.');
            }
        });
    }
}