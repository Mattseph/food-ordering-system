<?php include '../partials/head.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Budget Meal View</h1>

        <table>
            <tr>
                <th>Title</th>
                <th>Price</th>
                <th>Active</th>
            </tr>

            <?php
            $budgetmealQuery = "SELECT `food_name`, `food_price`, `active` FROM `food_list` where `food_price` < :food_price";
            $budgetmealStatement = $pdo->prepare($budgetmealQuery);
            $budgetmealStatement->bindValue(':food_price', 5);
            $budgetmealStatement->execute();

            $budgetmealCount = $budgetmealStatement->rowCount();


            if ($budgetmealCount > 0) {

                while ($budget = $budgetmealStatement->query(PDO::FETCH_ASSOC)) {
                    $food_name = $budget['food_name'];
                    $food_price = $budget['food_price'];
                    $active = $budget['active'];


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