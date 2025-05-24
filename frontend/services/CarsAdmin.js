const CarsAdmin = {
    //get all cars
    fetchCars: function() {
        return $.ajax({
            url: Constants.PROJECT_BASE_URL + 'car/',
            type: "GET",
            dataType: "json",
            beforeSend: function(xhr) {
                const token = localStorage.getItem("user_token");
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
            }
        });
    },
    // dodaj auto
    addCar: function(carData) {
        const token = localStorage.getItem("user_token");
        if (token=== null || token === "") {
            alert("You are not authorized to perform this action.");
            return $.Deferred().reject("Missing token").promise();
        }
        $("#add-car-form").off("submit.addcar");

        return $.ajax({
            url: Constants.PROJECT_BASE_URL + 'car/',
            type: "POST",
            data: JSON.stringify(carData),
            contentType: "application/json",
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            }
        });
    },

    updateCar: function(carId, carData) {
        return $.ajax({
            url: Constants.PROJECT_BASE_URL + 'car/' + carId,
            type: "PUT",
            data: JSON.stringify(carData),
            contentType: "application/json",
            beforeSend: function(xhr) {
                const token = localStorage.getItem("user_token");
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
            }
        });
    },

    deleteCar: function(carId) {
        const token = localStorage.getItem("user_token");
        if (!token) {
            alert("You are not authorized to perform this action.");
            return $.Deferred().reject("Missing token").promise();
        }
        return $.ajax({
            url: Constants.PROJECT_BASE_URL + 'car/' + carId,
            type: "DELETE",
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            }
        });
    }
};

$(document).ready(function() {
    // Salji kuci
    const token = localStorage.getItem("user_token");
    if (token) {
        try {
            const user = Utils.parseJwt(token).user;
            if (!user || !user.role || user.role.toLowerCase() !== "admin") {
                window.location.replace("#mainpage");
                return;
            }
        } catch (e) {
            window.location.replace("#mainpage");
            return;
        }
    } else {
        window.location.replace("#mainpage");
        return;
    }

    function renderCars() {
        CarsAdmin.fetchCars().done(function(cars) {
            const tbody = $("#cars-table tbody");
            tbody.empty();
            cars.forEach(car => {
                tbody.append(`
                    <tr>
                        <td>${car.car_id}</td>
                        <td>${car.Brand}</td>
                        <td>${car.Model}</td>
                        <td>${car.Year}</td>
                        <td>${car.License_plate}</td>
                        <td>${car.availablity_status == 1 ? "Available" : "Not Available"}</td>
                        <td>${car.cartype}</td>
                        <td>${car.Price}</td>
                        <td>${car.Location}</td>
                        <td>
                            <button class="btn btn-sm btn-danger delete-car-btn" data-car-id="${car.car_id}">Delete</button>
                        </td>
                    </tr>
                `);
            });
        });
    }

    renderCars();

    $("#add-car-form").off("submit").on("submit", function(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(this).entries());
        CarsAdmin.addCar(data)
            .done(function() {
                renderCars();
                $("#add-car-form")[0].reset();
                alert("Car added successfully!");
            })
            .fail(function(xhr) {
                if (xhr === "Missing token") {
                    //
                } else {
                    alert("Failed to add car: " + (xhr && xhr.responseText ? xhr.responseText : xhr));
                }
            });
    });

    // Edit Car Modal
    $(document).on("click", ".edit-car-btn", function() {
        const car = JSON.parse($(this).attr("data-car"));
        $("#edit-car-id").val(car.car_id);
        $("#edit-Brand").val(car.Brand);
        $("#edit-Model").val(car.Model);
        $("#edit-Year").val(car.Year);
        $("#edit-License_plate").val(car.License_plate);
        $("#edit-availablity_status").val(car.availablity_status);
        $("#edit-engine").val(car.engine);
        $("#edit-kilometers").val(car.kilometers);
        $("#edit-fueltype").val(car.fueltype);
        $("#edit-transmissions").val(car.transmissions);
        $("#edit-seats").val(car.seats);
        $("#edit-cartype").val(car.cartype);
        $("#edit-imgurl").val(car.imgurl);
        $("#edit-Price").val(car.Price);
        $("#edit-Location").val(car.Location);
        $("#editCarModal").modal("show");
    });

    // Save Edit Car
    $("#edit-car-form").on("submit", function(e) {
        e.preventDefault();
        const carId = $("#edit-car-id").val();
        const data = Object.fromEntries(new FormData(this).entries());
        CarsAdmin.updateCar(carId, data)
            .done(function() {
                renderCars();
                $("#editCarModal").modal("hide");
                alert("Car updated successfully!");
            })
            .fail(function(xhr) {
                alert("Failed to update car: " + xhr.responseText);
            });
    });

    // Update car
    $("#update-car-form").on("submit", function(e) {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(this).entries());
        const carId = data.car_id;
        CarsAdmin.updateCar(carId, data)
            .done(function() {
                renderCars();
                $("#update-car-form")[0].reset();
                alert("Car updated successfully!");
            })
            .fail(function(xhr) {
                alert("Failed to update car: " + xhr.responseText);
            });
    });

    // delete by id
    $("#delete-car-btn").on("click", function() {
        const carId = prompt("Enter the Car ID to delete:");
        if (carId && !isNaN(carId)) {
            if (confirm("Are you sure you want to delete car with ID " + carId + "?")) {
                CarsAdmin.deleteCar(carId)
                    .done(function() {
                        alert("Car deleted successfully!");
                        renderCars();
                    })
                    .fail(function(xhr) {
                        alert("Failed to delete car: " + (xhr && xhr.responseText ? xhr.responseText : xhr));
                    });
            }
        }
    });

    // Delete car action
    $(document).on("click", ".delete-car-btn", function() {
        const carId = $(this).data("car-id");
        if (confirm("Are you sure you want to delete car with ID " + carId + "?")) {
            CarsAdmin.deleteCar(carId)
                .done(function() {
                    alert("Car deleted successfully!");
                    renderCars();
                })
                .fail(function(xhr) {
                    alert("Failed to delete car: " + (xhr && xhr.responseText ? xhr.responseText : xhr));
                });
        }
    });
});
