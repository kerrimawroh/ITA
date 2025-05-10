<!DOCTYPE html>
<html>
<head>
    <title>Breakfast Menu</title>
    <link rel="stylesheet" href="meals.css">
</head>
<body>
    <h2>Breakfast Menu</h2>
    <?php
    require 'db.php';

    try {
        $stmt = $pdo->query("SELECT * FROM snacks");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($menuItems)): ?>
            <p>No menu items available today.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($menuItems as $item): ?>
                    <li class="menu-item">
                        <div class="menu-item-details">
                            <h3 class="dish-name"><?php echo htmlspecialchars($item['dish_name']); ?></h3>
                            <p class="description"><?php echo htmlspecialchars($item['description']); ?></p>
                            <p class="price">₹<?php echo htmlspecialchars(number_format($item['price'], 2)); ?></p>
                        </div>
                        <a href="index1.php?dish_id=<?php echo htmlspecialchars($item['id']); ?>#reviews" class="review-button">View & Rate</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;

    } catch (PDOException $e) {
        echo "Error fetching menu: " . $e->getMessage();
    }
    ?>
</body>
</html>