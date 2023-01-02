<?php include '../partials/head.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Messages</h1>
        <!--Header-->
        <?php
        if (isset($_SESSION['add'])) {    //Displaying session message
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

        ?>

        <table>
            <tr>
                <th>Message ID</th>
                <th>User ID</th>
                <th>Message</th>
                <th>Date</th>
            </tr>

            <?php
            //Selecting all from table admin.
            $sql = "SELECT * from messages ORDER BY date_message DESC";
            //Executiong the query
            $res = mysqli_query($conn, $sql);

            if ($res) {    //Count rows
                $count = mysqli_num_rows($res);
                //Creating a variable and assign the value.
                $ID = 1;

                if ($count > 0) {    //Using while loop to get all of the data from database.
                    //It will run as long as there are data in database.
                    while ($rows = mysqli_fetch_assoc($res)) {
                        $message_id = $rows['message_id'];
                        $user_id = $rows['user_id'];
                        $message = $rows['message'];
                        $date = $rows['date_message'];

                        //Display the values in the table
            ?>
                        <tr>
                            <td><?php echo $ID++; ?></td>
                            <td><?php echo $user_id; ?></td>
                            <td><?php echo $message; ?></td>
                            <td><?php echo $date; ?></td>
                        </tr>
            <?php
                    }
                }
            }
            ?>
        </table>
    </div>
</div>