<?php
// Database connection
$mysqli = new mysqli("localhost", "root", "", "admindb", 3307); // Update with your actual credentials

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// SQL query to fetch all orders, including their cancellation status
$sql = "SELECT id, name, email, phone, created_at, status, cancellation_reason FROM orders";

$result = $mysqli->query($sql);

// Check if there are results
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <style>
        /* Basic styling for layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header styling */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .back-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Styling for the cancellation status */
        .cancelled {
            color: red;
            font-weight: bold;
        }

        .not-cancelled {
            color: green;
            font-weight: bold;
        }

        /* Action buttons */
        .action-btn {
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 5px;
        }

        .accept-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .reject-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }

    </style>
</head>
<body>

<!-- Header with headline and back button -->
<div class="header">
    <h1>Orders</h1>
    <a href="adashboard.html" class="back-button">Back to Dashboard</a>
</div>

<?php
// Check if there are results
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Cancellation Status</th>
                <th>Actions</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Check the cancellation status and set the class accordingly
        $cancellationStatus = ($row["status"] === 'cancelled') ? "Cancelled" : "Not Cancelled";
        $statusClass = ($row["status"] === 'cancelled') ? "cancelled" : "not-cancelled";

        // Display actions for Accept and Reject based on the current status
        $acceptRejectBtns = '';
        if ($row["status"] === 'Pending') {
            $acceptRejectBtns = "<button class='action-btn accept-btn' onclick='updateStatus(" . $row['id'] . ", \"Accepted\")'>Accept</button>
                                 <button class='action-btn reject-btn' onclick='updateStatus(" . $row['id'] . ", \"Rejected\")'>Reject</button>";
        }

        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["phone"] . "</td>
                <td>" . $row["created_at"] . "</td>
                <td>" . $row["status"] . "</td>
                <td class='$statusClass'>" . $cancellationStatus . "</td>
                <td>" . $acceptRejectBtns . "</td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No orders found";
}

// Close the connection
$mysqli->close();
?>

<script>
    function updateStatus(orderId, newStatus) {
        // Make an AJAX request to update the order status in the database
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_order_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Order " + newStatus);
                    location.reload(); // Reload page to reflect status change
                } else {
                    alert("Failed to update order status.");
                }
            } else {
                alert("Error in request.");
            }
        };
        
        xhr.send("orderId=" + orderId + "&newStatus=" + newStatus);
    }
</script>

</body>
</html>
