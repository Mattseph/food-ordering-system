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
            $messageQuery = "SELECT * from messages ORDER BY date_message DESC";
            //Executiong the query

            $messageStatement = $pdo->query($messageQuery);
            $messageCount = $messageStatement->rowCount();

            if ($messageCount > 0) {    //Count rows
                $messages = $messageStatement->fetchAll(PDO::FETCH_ASSOC);
                //Creating a variable and assign the value.
                $ID = 1;

                //Using while loop to get all of the data from database.
                //It will run as long as there are data in database.
                foreach ($messages as $message) {
                    $message_id = $message['message_id'];
                    $user_id = $message['user_id'];
                    $message = $message['message'];
                    $date = $message['date_message'];

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
            ?>
        </table>
    </div>
</div>