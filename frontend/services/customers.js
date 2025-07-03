var CustomersService = {
    addUser: function(user) {
        $.ajax({
            type: 'POST',
            url: 'http://localhost:8888/TFinal/backend/add',
            data: JSON.stringify(user),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          console.log(result);
          toastr.success('User added successfully');},
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
        },
      });
    },
    getUsesrs: function(){
      $.ajax({
        type: 'GET',
        url: 'http://localhost:8888/TFinal/backend/customers',
        contentType: "application/json",
        dataType: "json",
              success: function(users) {
            var select = $("#customers-list");
            select.empty();
            users.forEach(function(user) {
                select.append(`<option value="${user.id}">${user.first_name} ${user.last_name}</option>`);
            });
        },
        error: function(xhr) {
            alert("Failed to load users.");
        }})
    },
    getUserMealById: function(UserId){
      $.ajax({
        type: 'GET',
        url: `http://localhost:8888/TFinal/backend/customer/meals/${UserId}`,
        contentType: "application/json",
        dataType: "json",
        success: function(meals) {
            var select = $("#customer-meals tbody");
            select.empty();
            meals.forEach(function(meal) {
                select.append(`        <tr>
          <td>${meal.name}</td>
          <td>${meal.brand}</td>
          <td>${meal.created_at}</td>
        </tr>`);
            });
        },
        error: function(xhr) {
            alert("Failed to load meals for the user.");
        }
      })
    }
}
