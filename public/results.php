<!-- filename: public/results.php -->
<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';
requireLogin();

// If POST, save the result and return attempt_id in JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic = sanitizeInput($_POST['topic'] ?? '');
    $score = intval($_POST['score'] ?? 0);
    $total = intval($_POST['total'] ?? 10);

    $topic_id = getTopicIdByName($pdo, $topic);
    if (!$topic_id) {
        echo json_encode(['success'=>false]);
        exit();
    }

    // Store the attempt
    $stmt = $pdo->prepare("INSERT INTO quiz_attempts (user_id, topic_id, score, total_questions) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $topic_id, $score, $total]);
    $attempt_id = $pdo->lastInsertId();

    echo json_encode(['success'=>true, 'attempt_id'=>$attempt_id]);
    exit();
}

// If GET, show the results page
$attempt_id = isset($_GET['attempt_id']) ? intval($_GET['attempt_id']) : 0;
$stmt = $pdo->prepare("SELECT qa.*, qt.topic_name FROM quiz_attempts qa JOIN quiz_topics qt ON qa.topic_id = qt.id WHERE qa.id = ? AND qa.user_id = ?");
$stmt->execute([$attempt_id, $_SESSION['user_id']]);
$attempt = $stmt->fetch();

$pageTitle = 'Quiz Results - QuizMaster';
$cssPath = '../assets/css/styles.css';
$jsPath = '../assets/js/script.js';
?>
<?php include '../includes/header.php'; ?>

<main>
    <div class="container">
        <?php if (!$attempt): ?>
            <div class="results-container">
                <h3>Invalid quiz attempt ID.</h3>
                <a href="dashboard.php" class="btn-primary">Back to Dashboard</a>
            </div>
        <?php else: ?>
        <div class="results-container">
            <h2>Quiz Results: <?php echo htmlspecialchars($attempt['topic_name']); ?></h2>
            <div class="score-display"><?php echo $attempt['score'] . '/' . $attempt['total_questions']; ?></div>
            <div class="grade-display <?php
                $percent = ($attempt['score'] / $attempt['total_questions'])*100;
                if ($percent >= 80) echo 'grade-a';
                elseif ($percent >= 60) echo 'grade-b';
                elseif ($percent >= 40) echo 'grade-c';
                else echo 'grade-f';
            ?>">
                <?php echo calculateGrade($attempt['score'], $attempt['total_questions']); ?>
            </div>
            <div class="speedometer-container"></div>
            <a href="dashboard.php" class="btn-primary" style="margin-top:2rem;">Back to Home</a>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
