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
            $familymeanQuery = "SELECT `food_name`, `food_price`, `active` FROM `food_list` where `food_price` >= :food_price";
            $familymealStatement = $pdo->prepare($familymeanQuery);
            $familymealStatement->bindValue(':food_price', 5);
            $familymealStatement->execute();
            $familymealCount = $familymealStatement->rowCount();


            if ($familymealCount > 0) {
                while ($family = $familymealStatement->fetch(PDO::FETCH_ASSOC)) {
                    $food_name = $family['food_name'];
                    $food_price = $family['food_price'];
                    $active = $family['active'];


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