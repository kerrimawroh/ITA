<?php
require 'db.php';

$error = '';
$success = '';
$dishId = '';
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
            header("Location: thankyou.php?success=" . urlencode($success)); // Redirect to thankyou.php
            exit();

        } catch (PDOException $e) {
            $error = "Error submitting review: " . $e->getMessage();
            header("Location: thankyou.php?error=" . urlencode($error)); //send the error
            exit();
        }
    } else {
        $error = "Invalid input. Please ensure you select a rating and provide a review.";
        header("Location: thankyou.php?error=" . urlencode($error)); //send the error
        exit();
    }
} else {
    header("Location: thankyou.php"); //if it is not a post.  Important for security and preventing unexpected behavior.
    exit();
}
?>