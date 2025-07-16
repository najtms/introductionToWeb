var OrdersService = {
    get_orders: function() {
        $.ajax({
            type: 'GET',
            url: Constants.get_api_base_url() + '/orders/report',
            dataType: 'json',
            success: function(orders) {
                var tbody = $('#order-details tbody');
                tbody.empty();
                orders.forEach(function(order) {
                    tbody.append(`
                        <tr>
                            <td class="text-center">
                                <button type="button" class="btn btn-success order-details-btn" data-order-id="${order.orderNumber}">Details</button>
                            </td>
                            <td>${order.orderNumber}</td>
                            <td>${order.total_amount}</td>
                        </tr>
                    `);
                });
                // Initialize DataTable for pagination, search, and order
                if ($.fn.DataTable.isDataTable('#order-details')) {
                    $('#order-details').DataTable().destroy();
                }
                $('#order-details').DataTable();
            },
            error: function(xhr) {
                alert('Failed to load orders.');
            }
        });
    },
    get_order_details: function(order_id) {
        $.ajax({
            type: 'GET',
            url: Constants.get_api_base_url() + '/order/details/' + order_id,
            dataType: 'json',
            success: function(details) {
                var tbody = $('#order-details-modal tbody');
                tbody.empty();
                var total = 0;
                details.forEach(function(item, idx) {
                    tbody.append(`
                        <tr>
                            <th scope="row">${idx+1}</th>
                            <td>${item.productName}</td>
                            <td>${item.quantityOrdered}</td>
                            <td>${item.priceEach}</td>
                        </tr>
                    `);
                    total += item.quantityOrdered * item.priceEach;
                });
                tbody.append(`<tr><td colspan="3"><strong>Total bill</strong></td><td>${total.toFixed(2)}</td></tr>`);
            },
            error: function(xhr) {
                alert('Failed to load order details.');
            }
        });
    }
}

// Bind Details button click
$(document).on('click', '.order-details-btn', function() {
    var order_id = $(this).data('order-id');
    OrdersService.get_order_details(order_id);
    $('#order-details-modal').modal('show');
});

// On page load
$(document).ready(function() {
    OrdersService.get_orders();
});
