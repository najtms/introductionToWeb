// Define allLoadedCars in a higher scope
let allLoadedCars = [];
function loadCars(category, destinationSelector) {
    console.log(`Attempting to load ${category} cars into ${destinationSelector}`);
    $.ajax({
        url: Constants.PROJECT_BASE_URL + 'car/carTypeThree?carType=' + encodeURIComponent(category),
        type: 'GET',
        success: function(cars) {
            const container = $(destinationSelector);
            container.empty();

            // Clear all cars
            if (destinationSelector === "#hatchback-cars" ||
                destinationSelector === "#sportcar-cars" ||
                destinationSelector === "#wagons-cars" ||
                destinationSelector === "#suvs-cars") {
                allLoadedCars = allLoadedCars.filter(car => false); 
            }

            const filteredCars = cars.filter(car => car.cartype.toLowerCase() === category.toLowerCase());

            if (filteredCars.length > 0) {
                allLoadedCars = allLoadedCars.concat(filteredCars);

                filteredCars.forEach(car => {
                    const isAvailable = car.availablity_status === 1;
                    const availabilityText = isAvailable ? 'Available' : 'Not Available';
                    const availabilityColorClass = isAvailable ? 'text-success' : 'text-danger';
                    container.append(`
                        <div class="col-lg-6 col-xl-4">
                            <div class="card mb-5 mb-xl-0">
                                <div class="card-body p-5 w-h">
                                    <div class="small fw-bold">${car.Brand} ${car.Model}</div>
                                    <div class="small fw-bold text-muted fs-7">or similar ${car.cartype}</div>
                                    <div class="mb-3">
                                        <img class="img-wh" src="${car.imgurl}" alt="Car image">
                                    </div>
                                    <div class="lines-div"></div>
                                    <ul class="list-unstyled mt-2 mb-2">
                                        <li><i class="bi bi-pin-angle-fill"></i><strong> ${car.Location}</strong></li>
                                    </ul>
                                    <div class="lines-div"></div>
                                    <ul class="list-unstyled mt-1 ml-auto text-end list-inline">
                                        <li class="text-muted"><strong>Price for 2 Days</strong></li>
                                        <li class="fs-5"><strong>BAM ${parseFloat(car.Price).toFixed(2)}</strong></li>
                                        <li class="fs-6 ${availabilityColorClass}">${availabilityText}</li>
                                    </ul>
                                    <div class="d-grid pt-2">
                                        <a class="btn btn-outline-primary" data-toggle="modal" data-target="#carModal" data-car-id="${car.car_id}">Reserve Now!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                container.append(`<p class="text-muted">No ${category} cars available at the moment.</p>`);
            }

            bindCarModalHandler();
        },
        error: function(xhr, status, error) {
            console.error(`Failed to load ${category} cars:`, status, error);
            $(destinationSelector).html(`<p class="text-danger">Failed to load ${category} cars. Please try again later.</p>`);
        }
    });
}

function bindCarModalHandler() {
    $('#carModal').off('show.bs.modal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const carId = parseInt(button.data('car-id'));
        let selectedCar = allLoadedCars.find(car => car.car_id == carId);

        if (!selectedCar && button.closest('.card-body').length) {
            const card = button.closest('.card-body');
            selectedCar = {
                Brand: card.find('.small.fw-bold').first().text().split(' ')[0],
                Model: card.find('.small.fw-bold').first().text().split(' ').slice(1).join(' '),
                imgurl: card.find('img').attr('src'),
                Location: card.find('strong').first().text(),
                Price: parseFloat(card.find('.fs-5 strong').text().replace('BAM', '').trim()),
                availablity_status: card.find('.fs-6').hasClass('text-success') ? 1 : 0,
                car_id: carId
            };
        }

        const modal = $(this);

        if (selectedCar) {
            modal.find('#modalCarName').text(`${selectedCar.Brand} ${selectedCar.Model}`);
            modal.find('#carModalLabel').text(`Reserve ${selectedCar.Brand} ${selectedCar.Model}`);
            modal.find('#modalCarImage').attr('src', selectedCar.imgurl);
            modal.find('#modalCarLocation').text(selectedCar.Location);
            modal.find('#modalCarPrice').text(`BAM ${parseFloat(selectedCar.Price).toFixed(2)}`);
            modal.find('#modalCarAvailability')
                .text(selectedCar.availablity_status === 1 ? 'Available' : 'Not Available')
                .removeClass('text-success text-danger')
                .addClass(selectedCar.availablity_status === 1 ? 'text-success' : 'text-danger');
            modal.find('#reservationCarId').val(selectedCar.car_id);

            modal.find('#reserveCarButton').prop('disabled', selectedCar.availablity_status !== 1);
        } else {
            modal.find('#modalCarName').text('Car Details Not Found');
            modal.find('#carModalLabel').text('Error Loading Car');
            modal.find('#modalCarImage').attr('src', '');
            modal.find('#modalCarLocation').text('');
            modal.find('#modalCarPrice').text('');
            modal.find('#modalCarAvailability').text('Error').removeClass('text-success text-danger');
            modal.find('#reserveCarButton').prop('disabled', true);
        }
    });
}

function loadRandomCars(destinationSelector) {
    $.ajax({
        url: Constants.PROJECT_BASE_URL + 'car/randomThree',
        type: 'GET',
        success: function(cars) {
            const container = $(destinationSelector);
            container.empty();

            if (cars.length > 0) {
                cars.forEach(car => {
                    const isAvailable = car.availablity_status === 1;
                    const availabilityText = isAvailable ? 'Available' : 'Not Available';
                    const availabilityColorClass = isAvailable ? 'text-success' : 'text-danger';
                    container.append(`
                        <div class="col-lg-6 col-xl-4">
                            <div class="card mb-5 mb-xl-0">
                                <div class="card-body p-5 w-h">
                                    <div class="small fw-bold">${car.Brand} ${car.Model}</div>
                                    <div class="small fw-bold text-muted fs-7">or similar ${car.cartype}</div>
                                    <div class="mb-3">
                                        <img class="img-wh" src="${car.imgurl}" alt="Car image" style="max-height: 250px;">
                                    </div>
                                    <div class="lines-div"></div>
                                    <ul class="list-unstyled mt-2 mb-2">
                                        <li>
                                            <i class="bi bi-pin-angle-fill"></i>
                                            <strong>${car.Location}</strong>
                                        </li>
                                    </ul>
                                    <div class="lines-div"></div>
                                    <ul class="list-unstyled mt-1 ml-auto text-end list-inline">
                                        <li class="text-muted"><strong>Price for 2 Days</strong></li>
                                        <li class="fs-5"><strong>BAM ${parseFloat(car.Price).toFixed(2)}</strong></li>
                                        <li class="fs-6 ${availabilityColorClass}">${availabilityText}</li>
                                    </ul>
                                    <div class="d-grid pt-2">
                                        <a class="btn btn-outline-primary" data-toggle="modal" data-target="#carModal" data-car-id="${car.car_id}">Reserve Now!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            } else {
                container.append('<p class="text-muted">No cars available at the moment.</p>');
            }
        },
        error: function() {
            $(destinationSelector).html('<p class="text-danger">Failed to load cars. Please try again later.</p>');
        }
    });
}

function deleteCar(carId, onSuccess, onError) {
    const token = localStorage.getItem("user_token");
    if (!token) {
        alert("You are not authorized to perform this action.");
        if (onError) onError("Missing token");
        return;
    }
    $.ajax({
        url: Constants.PROJECT_BASE_URL + 'car/' + carId,
        type: "DELETE",
        beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Bearer " + token);
        },
        success: function() {
            if (onSuccess) onSuccess();
        },
        error: function(xhr) {
            if (onError) onError(xhr && xhr.responseText ? xhr.responseText : xhr);
        }
    });
}

$(document).ready(function() {
    console.log("Cars.js loaded");

    allLoadedCars = [];

    //ucitavanje sva auta
    loadCars("Hatchback", "#hatchback-cars");
    loadCars("Sport", "#sportcar-cars");
    loadCars("Wagon", "#wagons-cars");
    loadCars("Suv", "#suvs-cars");

    bindCarModalHandler();

    $('#reserveCarButton').on('click', function() {
        const carId = $('#reservationCarId').val();
        const pickUpDate = $('#pickUpDate').val();
        const returnDate = $('#returnDate').val();
        const customerName = $('#customerName').val();
        const customerEmail = $('#customerEmail').val();

        if (!pickUpDate || !returnDate || !customerName || !customerEmail) {
            alert('Please fill in all reservation details.');
            return;
        }

        const reservationData = {
            car_id: carId,
            pick_up_date: pickUpDate,
            return_date: returnDate,
            customer_name: customerName,
            customer_email: customerEmail
        };

        console.log("Attempting to reserve car:", reservationData);

        $.ajax({ // TODO ne kontam kako sklopit sve
            url: Constants.PROJECT_BASE_URL + 'booking/', 
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(reservationData),
            success: function(response) {
                alert('Car reserved successfully!');
                $('#carModal').modal('hide');
            },
            error: function(xhr, status, error) {
                console.error("Reservation failed:", status, error, xhr.responseText);
                alert('Reservation failed. Please try again.');
            }
        });
    });
});