<?php
require 'db.php';

$error = '';
$dishId = ''; // Initialize dishId
$success = '';
$submittedReviewText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dish_id']) && is_numeric($_POST['dish_id']) &&
        isset($_POST['rating']) && is_numeric($_POST['rating']) && $_POST['rating'] >= 1 && $_POST['rating'] <= 5 &&
        isset($_POST['review_text'])) {

        $dishId = $_POST['dish_id'];
        $rating = $_POST['rating'];
        $reviewText = trim($_POST['review_text']);
        $submittedReviewText = htmlspecialchars($reviewText);

        try {
            $stmt = $pdo->prepare("INSERT INTO reviews (menu_id, rating, review_text, created_at) VALUES (:dish_id, :rating, :review_text, NOW())");
            $stmt->bindParam(':dish_id', $dishId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':review_text', $reviewText, PDO::PARAM_STR);
            $stmt->execute();
            $success = "Thank you for your review!";
           

        } catch (PDOException $e) {
            $error = "Error submitting review: " . $e->getMessage();
        }
    } else {
        $error = "Invalid input. Please ensure you select a rating and provide a review.";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews and Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f8f8;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h2 {
            color: #28a745;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            text-align: center;
        }

        h3{
            color: #343a40;
            margin-top: 20px;
            margin-bottom: 10px;
            text-align: center;
        }

        .error-message {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .reviews-container {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            background-color: white;
            max-width: 600px;
            width: 90%;
        }

        .review-item {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .review-item p {
            margin: 5px 0;
        }

        .rating {
            font-weight: bold;
            color: #008000;
        }

        .no-reviews {
            font-style: italic;
            color: #888;
            text-align: center;
        }

        .redirect-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .redirect-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <h2><?php echo $success; ?></h2>
             <?php if ($submittedReviewText): ?>
                <h3>Your Review:</h3>
                <p><?php echo $submittedReviewText; ?></p>
            <?php endif; ?>
            <button class="redirect-button" onclick="window.location.href='welcome.php'">Go to Welcome Page</button>
        <?php elseif ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
            <button class="redirect-button" onclick="window.location.href='welcome.php'">Go to Welcome Page</button>
        <?php else : ?>
             <p>No review submitted.</p>
             <button class="redirect-button" onclick="window.location.href='welcome.php'">Go to Welcome Page</button>
        <?php endif; ?>
    </div>
</body>
</html>
