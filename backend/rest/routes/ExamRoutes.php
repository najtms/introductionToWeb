<?php


Flight::route('GET /connection-check', function () {
    try {
        $dao = new ExamDao();
    } catch (Exception $e) {
        echo "Connection failed: " . $e->getMessage();
    }
});

Flight::route('GET /employees/performance', function () {
    try {
        Flight::json((Flight::get('examService'))->employees_performance_report());
    } catch (Exception $e) {
        Flight::json(["error" => $e->getMessage()], 400);
    };
});

Flight::route('DELETE /employee/delete/@employee_id', function ($employee_id) {
    $success = Flight::get('examService')->delete_employee($employee_id);

    if ($success) {
        Flight::json(['message' => 'User Deleted']);
    } else {
        Flight::json(['message' => 'Failed to delete user'], 500);
    }
});

Flight::route('PUT /employee/edit/@employee_id', function ($employee_id) {
    $data = Flight::request()->data->getData();
    Flight::get('examService')->edit_employee($employee_id, $data);
});

Flight::route('GET /orders/report', function () {
    Flight::json(Flight::get('examService')->get_orders_report());
});

Flight::route('GET /order/details/@order_id', function ($order_id) {
    Flight::json(Flight::get('examService')->get_order_details($order_id));
});

Flight::route('GET /employee/@employee_id', function ($employee_id) {
    $employee = Flight::get('examService')->get_employee($employee_id);
    if ($employee) {
        Flight::json($employee);
    } else {
        Flight::json(["error" => "Employee not found"], 404);
    }
});
