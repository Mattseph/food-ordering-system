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

    if (isset($_SESSION['no_riderid_found'])) {
        echo $_SESSION['no_riderid_found'];
        unset($_SESSION['no_riderid_found']);
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
            $sql = "SELECT * from delivery_rider";
            //Executiong the query
            $res = mysqli_query($conn, $sql);

            if ($res) {    //Count rows
                $count = mysqli_num_rows($res);
                //Creating a variable and assign the value.
                $id = 1;

                if ($count > 0) {    //Using while loop to get all of the data from database.
                    //It will run as long as there are data in database.
                    while ($row = mysqli_fetch_assoc($res)) {
                        $rider_id = $row['rider_id'];
                        $rider_lastname = $row['rider_lastname'];
                        $rider_firstname = $row['rider_firstname'];
                        $contact_number = $row['contact_number'];
                        $email = $row['email'];
                        $active = $row['active'];

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
            }
            ?>
        </table>
    </div>
</div>