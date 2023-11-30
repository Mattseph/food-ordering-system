<?php include '../partials/head.php'; ?>

<div class="main-content">
    <?php
    if (isset($_SESSION['add'])) //Checking whether the session is set or not
    {    //DIsplaying session message
        echo $_SESSION['add'];
        //Removing session message
        unset($_SESSION['add']);
    }

    if (isset($_SESSION['delete'])) {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }

    if (isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }

    if (isset($_SESSION['no_rider_data_found'])) {
        echo $_SESSION['no_rider_data_found'];
        unset($_SESSION['no_rider_data_found']);
    }


    ?>
    <div class="wrapper">
        <h1>Delivery Rider Profile</h1>
        <div>
            <a href="<?php echo SITEURL; ?>admin/delivery_rider_manage/add_delivery.php" class="btn btn-first">Add Delivery</a>
            <!--Button for add admin-->
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Lastame</th>
                <th>Firstname</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            //Selecting all from table admin.
            $riderQuery = "SELECT * from delivery_rider ORDER BY rider_id DESC";
            //Executiong the query
            $riderStatement = $pdo->query($riderQuery);
            $riders = $riderStatement->fetchAll(PDO::FETCH_ASSOC);

            if ($riders) {    //Count rows

                //Creating a variable and assign the value.
                $id = 1;
                //Using foreach loop to get all of the data from database.
                //It will run as long as there are data in database.
                foreach ($riders as $rider) {
                    $rider_id = $rider['rider_id'];
                    $rider_lastname = $rider['rider_lastname'];
                    $rider_firstname = $rider['rider_firstname'];
                    $contact_number = $rider['contact_number'];
                    $email = $rider['email'];
                    $active = $rider['active'];

                    //Display the values in the table
            ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $rider_lastname; ?></td>
                        <td><?php echo $rider_firstname; ?></td>
                        <td><?php echo $contact_number; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $active; ?></td>

                        <td>
                            <a href="<?php echo SITEURL; ?>admin/delivery_rider_manage/update_delivery.php?rider_id=<?php echo $rider_id; ?>" class="btn btn-second">Update</a>
                            <a href="<?php echo SITEURL; ?>admin/delivery_rider_manage/delete_delivery.php?rider_id=<?php echo $rider_id; ?>" class="btn btn-third">Delete</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>