<?php

// Require PHP Config File
require("./config.php");

// Require Database Class
require("./includes/Database.class.php");

// Initalize Database Class
$db = new Database;

// Fetch User From Database
$db->query("SELECT * FROM users WHERE user_id = :user_id");
$db->bind(":user_id", $_GET['id']);
$user = $db->fetchResult();

// Exit If No User
if (!$user) {
    exit("Invalid Link");
}

// Check If User Has Access
if ($user['status'] != 1) {
    exit("Profile has been locked!");
}

// Fetch Transactions
$db->query("SELECT * FROM transactions WHERE user_id = :user_id");
$db->bind(":user_id", $_GET['id']);
$transactions = $db->fetchResults();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proof Of Concept</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-danger">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 mx-auto">Proof Of Concept</span>
        </div>
    </nav>
    <!-- End Navbar -->


    <!-- Main Body Of Page -->
    <div class="container mt-5">
        <div class="row">

            <!-- Proflie Section -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title text-center">Profile</h4>
                    </div>
                    <div class="card-body">

                        <!-- User ID -->
                        <div class="form-group">
                            <label>User ID</label>
                            <p><?= $user['user_id']; ?></p>
                        </div>
                        <!-- End User ID -->

                        <!-- First Name -->
                        <div class="form-group">
                            <label>First Name</label>
                            <p><?= $user['first_name']; ?></p>
                        </div>
                        <!-- End First Name -->

                        <!-- Last Name -->
                        <div class="form-group">
                            <label>Last Name</label>
                            <p><?= $user['last_name']; ?></p>
                        </div>
                        <!-- End Last Name -->

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <p><?= $user['email']; ?></p>
                        </div>
                        <!-- Email -->

                    </div>
                </div>
            </div>
            <!-- End Proflie Section -->

            <!-- Transactions Section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title text-center">Transactions</h4>
                    </div>
                    <div class="card-body">

                        <table id="transactionsTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Iterating Over All Transactions -->
                                <?php foreach ($transactions as $transaction) : ?>
                                    <tr>
                                        <th scope="row"><?= $transaction['transaction_id']; ?></th>
                                        <td><?= $transaction['title']; ?></td>
                                        <td>$<?= number_format($transaction['amount'], 2, '.', ','); ?></td>
                                        <td><?= date('m/d/Y', $transaction['created_at']); ?></td>
                                        <td>
                                            <?php
                                            if($transaction['status'] == 0) {
                                                echo '<span class="badge bg-pending">Pending</span>';
                                            } elseif($transaction['status'] == 1) {
                                                echo '<span class="badge bg-success">Completed</span>';
                                            }elseif($transaction['status'] == 2) {
                                                echo '<span class="badge bg-danger">Cancelled</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- End Iterating Over All Transactions -->

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- End Transactions Section -->

        </div>
    </div>
    <!-- End Main Body Of Page -->


    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        // Initalize DataTable
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                pageLength: 3,
                lengthMenu: [3, 5, 10, 20],
            });
        });
    </script>
</body>

</html>