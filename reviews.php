<?php
require 'db.php';

if (isset($_GET['dish_id']) && is_numeric($_GET['dish_id'])) {
    $dishId = $_GET['dish_id'];

    try {
        $stmt = $pdo->prepare("SELECT r.* FROM reviews r JOIN menu m ON r.menu_id = m.id WHERE r.menu_id = :dish_id ORDER BY r.created_at DESC");
        $stmt->bindParam(':dish_id', $dishId, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Student Reviews:</h3>";
        if (empty($reviews)): ?>
            <p class="no-reviews">No reviews yet for this dish. Be the first!</p>
        <?php else: ?>
            <div class="reviews-container">
                <?php foreach ($reviews as $review): ?>
                    <div class="review-item">
                        <p class="rating">Rating: <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                        <p class="review-text"><?php echo htmlspecialchars($review['review_text']); ?></p>
                        <small>Reviewed on: <?php echo htmlspecialchars(date('F j, Y', strtotime($review['created_at']))); ?></small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;

    } catch (PDOException $e) {
        echo "Error fetching reviews: " . $e->getMessage();
    }
} else {
    echo "<p class='error-message'>Invalid dish ID.</p>";
}
?>