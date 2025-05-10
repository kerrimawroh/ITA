<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Menu & Reviews</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Today's Canteen Menu</h1>
      

        <section id="reviews">
            <?php
            if (isset($_GET['dish_id']) && is_numeric($_GET['dish_id'])) {
                include 'reviews.php';
                include 'submit_review.php';
            } else {
                echo "<h2>Browse the menu and click 'View & Rate' to see reviews and leave your own!</h2>";
            }
            ?>
        </section>
    </div>
</body>
</html>