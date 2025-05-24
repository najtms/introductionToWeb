var UserService = {
    init: function () {
      var token = localStorage.getItem("user_token");
      if (token && token !== undefined) {
        window.location.replace("#account");
      }
      $("#login-form").validate({
        submitHandler: function (form) {
          var entity = Object.fromEntries(new FormData(form).entries());
          UserService.login(entity);
        },
      });
    },
    login: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/login",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          console.log(result);
          localStorage.setItem("user_token", result.data.token);
          window.location.replace("index.html");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
        },
      });
    },
    register: function (entity) {
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "auth/register",
        type: "POST",
        data: JSON.stringify(entity),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
          console.log(result);
          window.location.replace("#login");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error');
        },
      });
    },
  
    logout: function () {
      localStorage.clear();
       UserService.generateMenuItems();
      window.location.replace("#login");
    },
    getPorfile: function () {
      const token = localStorage.getItem("user_token");
      if (!token) {
        toastr.error("You are not logged in. Please log in to view your profile.");
        window.location.replace("#login");
        return;
      }
      $.ajax({
        url: Constants.PROJECT_BASE_URL + "user/", 
        beforeSend: function(xhr) {
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        contentType: "application/json",
        dataType: "json", 
        success: function (response) {
          console.log("Profile data received:", response);

          const userProfile = response.data; 
          //puno imo i prezime
          $("#profile-fullName").text(
            (userProfile.FirstName || '') + ' ' + (userProfile.LastName || '')
          );
          let roleText = "Customer";
          if (userProfile.role && userProfile.role.toLowerCase() === "admin") {
            roleText = "ADMIN";
          }
          $("#profile-role").text(roleText);

        
          $("#profile-firstName").text(userProfile.FirstName || 'N/A');
          $("#profile-lastName").text(userProfile.LastName || 'N/A');
          $("#profile-email").text(userProfile.email || 'N/A');
          $("#profile-phone").text(userProfile.Phone || 'N/A');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
          console.error("Error fetching profile:", XMLHttpRequest.responseText);
          toastr.error(XMLHttpRequest?.responseText ?  XMLHttpRequest.responseText : 'Error fetching profile');
          if (XMLHttpRequest.status === 401 || XMLHttpRequest.status === 403) {
            toastr.warning("Your session has expired or is invalid. Please log in again.");
            UserService.logout(); 
          }
        },
      });
    },

  
generateMenuItems: function () {
  const token = localStorage.getItem("user_token");
  const navContainer = document.querySelector(".nav");
  const accountNavItem = document.getElementById("account-nav");

  if (!navContainer) return;
  navContainer.innerHTML = "";

  if (accountNavItem) {
    accountNavItem.remove();
  }

  if (token) {
    const user = Utils.parseJwt(token).user;

    if (user && user.role) {
      const logoutItem = document.createElement("li");
      logoutItem.className = "nav-item";
      logoutItem.id = "account-nav";
      logoutItem.innerHTML = `
        <a class="nav-link text-white" href="#" id="logout-link">Logout</a>
      `;
      const reservation = document.createElement("li");
      reservation.className = "nav-item";
      reservation.id = "reservation-nav";
      reservation.innerHTML = `
        <a class="nav-link text-white" href="#account" id="reservation-link">My Account</a>
      `;

      let dashboard = null;
      if (user.role && user.role.toLowerCase() === "admin") {
        dashboard = document.createElement("li");
        dashboard.className = "nav-item";
        dashboard.id = "dashboard-nav";
        dashboard.innerHTML = `
          <a class="nav-link text-white" href="#dashboard" id="dashboard-link">Dashboard</a>
        `;
      }

      logoutItem.querySelector("#logout-link").addEventListener("click", function (e) {
        e.preventDefault();
        UserService.logout();
      });

      navContainer.appendChild(logoutItem);
      navContainer.appendChild(reservation);
      if (dashboard) {
        navContainer.appendChild(dashboard);
      }

    } else {
      window.location.replace("#login");
    }
  } else {
    const loginItem = document.createElement("li");
    loginItem.className = "nav-item";
    loginItem.id = "account-nav";

    loginItem.innerHTML = `
      <a class="nav-link text-white" href="#login" id="login-link">My account</a>
    `;
    navContainer.appendChild(loginItem);
  }
}

  };
