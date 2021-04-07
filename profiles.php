<?php

// Require PHP Config File
require("./config.php");

// Require Database Class
require("./includes/Database.class.php");

// Initalize Database Class
$db = new Database;

// Fetch User From Database
$db->query("SELECT * FROM users");
$users = $db->fetchResults();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proof Of Concept - Users</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-danger">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1 mx-auto">Proof Of Concept Users List</span>
        </div>
    </nav>
    <!-- End Navbar -->


    <!-- Main Body Of Page -->
    <div class="container mt-5">
        <div class="row">

            <!-- Users Section -->
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="title text-center">Users</h4>
                    </div>
                    <div class="card-body">

                        <table id="usersTable" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Profile</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Iterating Over All Transactions -->
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <th scope="row"><?= $user['user_id']; ?></th>
                                        <td><?= $user['first_name']; ?></td>
                                        <td><?= $user['last_name']; ?></td>
                                        <td><?= $user['email'] ?></td>
                                        <td>
                                            <?php
                                            if ($user['status'] == 1) {
                                                echo '<span class="badge bg-success">Active</span>';
                                            } elseif ($user['status'] == 2) {
                                                echo '<span class="badge bg-danger">Suspended</span>';
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="./profile/<?= $user['user_id']; ?>" target="_blank" class="text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                                    <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                                    <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                                                </svg>
                                            </a>
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
            $('#usersTable').DataTable({
                pageLength: 15,
                lengthMenu: [15, 30, 60],
            });
        });
    </script>
</body>

</html>