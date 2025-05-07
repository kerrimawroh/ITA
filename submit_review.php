<?php
require 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dish_id']) && is_numeric($_POST['dish_id']) &&
        isset($_POST['rating']) && is_numeric($_POST['rating']) && $_POST['rating'] >= 1 && $_POST['rating'] <= 5 &&
        isset($_POST['review_text'])) {

        $dishId = $_POST['dish_id'];
        $rating = $_POST['rating'];
        $reviewText = trim($_POST['review_text']);

        try {
            $stmt = $pdo->prepare("INSERT INTO reviews (menu_id, rating, review_text) VALUES (:dish_id, :rating, :review_text)");
            $stmt->bindParam(':dish_id', $dishId, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':review_text', $reviewText, PDO::PARAM_STR);
            $stmt->execute();
            $success = "Review submitted successfully!";
        } catch (PDOException $e) {
            $error = "Error submitting review: " . $e->getMessage();
        }

    } else {
        $error = "Invalid input. Please ensure you select a rating and provide a review.";
    }
}

$dishIdForForm = isset($_GET['dish_id']) && is_numeric($_GET['dish_id']) ? $_GET['dish_id'] : '';
?>

<div class="add-review-form">
    <h3>Leave a Review</h3>
    <?php if ($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="submit_review.php">
        <input type="hidden" name="dish_id" value="<?php echo htmlspecialchars($dishIdForForm); ?>">
        <div>
            <label for="rating">Rating (1-5):</label>
            <select name="rating" id="rating" required>
                <option value="">Select Rating</option>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>
        </div>
        <div>
            <label for="review_text">Your Review:</label><br>
            <textarea name="review_text" id="review_text" rows="5" required></textarea>
        </div>
        <button type="submit">Submit Review</button>
    </form>
</div>