<?php include '../partials/head.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Family Meal</h1>

        <table>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Active</th>
            </tr>

            <?php
            $sql = "SELECT `food_name`, `food_price`, `active` FROM `food_list` where `food_price` >= 5";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);


            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $food_name = $row['food_name'];
                    $food_price = $row['food_price'];
                    $active = $row['active'];


            ?>
                    <tr>
                        <td><?php echo $food_name; ?></td>
                        <td>$<?php echo $food_price; ?></td>
                        <td><?php echo $active; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>
</div>