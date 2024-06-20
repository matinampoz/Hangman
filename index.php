<?php
session_start();

// Αρχικοποίηση λίστας γραμμάτων και λέξεων
$letters = ["Α", "Β", "Γ", "Δ", "Ε", "Ζ", "Η", "Θ", "Ι", "Κ", "Λ", "Μ", "Ν", "Ξ", "Ο", "Π", "Ρ", "Σ", "Τ", "Υ", "Φ", "Χ", "Ψ", "Ω"];
$words = ["γάτα", "σπίτι", "δέντρο", "βιβλίο", "πλοίο", "ήλιος", "φίλος", "άνθρωπος", "κιθάρα", "θάλασσα", "πόλη", "κουζίνα", "βουνό", "αυτοκίνητο", "οικογένεια", "παράθυρο", "παιδί", "ζωή", "μουσική", "λουλούδι"];

// Επιλογή τυχαίας λέξης και αρχικοποίηση session
if (!isset($_SESSION['word'])) {
    $randIndex = array_rand($words); // Τυχαία επιλογή λέξης από τη λίστα
    $_SESSION['word'] = $words[$randIndex];
    $_SESSION['guessedLetters'] = [];
}

$word = $_SESSION['word']; // Η λέξη που πρέπει να μαντέψει ο παίκτης
$guessedLetters = isset($_SESSION['guessedLetters']) ? $_SESSION['guessedLetters'] : [];

// Διαχείριση υποβολής γραμμάτων
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['letter'])) {
    $letter = $_POST['letter'];
    if (!in_array($letter, $guessedLetters)) {
        $guessedLetters[] = $letter; // Προσθήκη του γράμματος στη λίστα των μαντεμένων γραμμάτων
    }
    $_SESSION['guessedLetters'] = $guessedLetters;
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Κρεμάλα</title>
    <link href="http://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Κρεμάλα</h1>
        <p>Μάντεψε τη λέξη:</p>
        <div class="word">
            <?php
            // Εμφάνιση της λέξης με μαντεμένα γράμματα και κάτω παύλες για τα υπόλοιπα
            for ($i = 0; $i < mb_strlen($word); $i++) {
                $currentLetter = mb_substr($word, $i, 1);
                if (in_array($currentLetter, $guessedLetters)) {
                    echo "<span class='letter'>$currentLetter </span>";
                } else {
                    echo "<span class='letter'>_ </span>";
                }
            }
            ?>
        </div>
        <div class="letters mt-3">
            <?php foreach ($letters as $letter) : ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="letter" value="<?= $letter; ?>">
                    <button type="submit" class="btn btn-info m-1" <?= in_array($letter, $guessedLetters) ? 'disabled' : ''; ?>>
                        <?= $letter; ?>
                    </button>
                </form>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
