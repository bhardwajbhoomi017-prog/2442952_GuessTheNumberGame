

<?php
session_start();


// Start a new game: first visit, or explicit restart
if (!isset($_SESSION['secret']) || isset($_POST['restart'])) {
  $_SESSION['secret']       = random_int(1, 100);
  $_SESSION['attempts'] = 0;
  $_SESSION['history']      = [];
  $_SESSION['solved']       = false;
}


$feedback = '';
$feedbackType = ''; // 'high' | 'low' | 'correct' | ''


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guess']) && !$_SESSION['solved']) {
 $guess = filter_var($_POST['guess'], FILTER_VALIDATE_INT);


  if ($guess === false || $guess < 1 || $guess > 100) {
      $feedback = 'Enter a whole number between 1 and 100.';
        $feedbackType = 'invalid';
  } else {
        $_SESSION['attempts']++;
        $_SESSION['history'][] = $guess;


        if ($guess < $_SESSION['secret']) {
            $feedback = 'TOO LOW';
              $feedbackType = 'low';
        } elseif ($guess > $_SESSION['secret']) {
              $feedback = 'TOO HIGH';
              $feedbackType = 'high';
        } else {
              $feedback = 'CORRECT';
              $feedbackType = 'correct';
              $_SESSION['solved'] = true;
        }
  }
}


$attempts = $_SESSION['attempts'];
$history       = $_SESSION['history'];
$solved        = $_SESSION['solved'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The Combination &mdash; Guess the Number</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>


<main class="vault">


  <header class="vault__header">
        <span class="vault__eyebrow">01&ndash;100</span>
        <h1 class="vault__title">The&nbsp;Combination</h1>
     <p class="vault__subtitle">A number is locked in the dial. Crack it.</p>
 </header>


 <div class="dial <?php echo $feedbackType ? 'dial--' . $feedbackType : ''; ?>" aria-live="polite">
     <div class="dial__ring">
         <div class="dial__readout">
               <?php if ($solved): ?>
                   <?php echo str_pad((string)$_SESSION['secret'], 3, '0', STR_PAD_LEFT); ?>
               <?php elseif ($feedbackType && $feedbackType !== 'invalid'): ?>
                     <?php echo strtoupper($feedback); ?>
               <?php else: ?>
                   &mdash;&mdash;&mdash;
               <?php endif; ?>
            </div>
     </div>
 </div>


 <?php if ($solved): ?>


     <p class="result">
            Correct! You guessed it in
            <strong><?php echo $attempts; ?></strong>
            <?php echo $attempts === 1 ? 'attempt' : 'attempts'; ?>.
     </p>
     <form method="post" class="form">
         <button type="submit" name="restart" value="1" class="btn btn--primary">Lock a new number</button>
     </form>


 <?php else: ?>


     <?php if ($feedbackType === 'invalid'): ?>
         <p class="hint hint--invalid"><?php echo htmlspecialchars($feedback); ?></p>
     <?php endif; ?>


     <form method="post" class="form">
            <label for="guess" class="form__label">Your guess</label>
            <div class="form__row">
               <input
                     type="number"
                     id="guess"
                     name="guess"
                     min="1"
                     max="100"
                     placeholder="50"
                     autocomplete="off"
                     autofocus
                     required
               >
               <button type="submit" class="btn btn--primary">Turn dial</button>
         </div>
     </form>


     <p class="meta">
            Attempts: <strong><?php echo $attempts; ?></strong>
            <?php if ($attempts > 0): ?>
               <button form="restart-form" type="submit" class="link-btn">start over</button>
            <?php endif; ?>
     </p>
     <form id="restart-form" method="post">
            <input type="hidden" name="restart" value="1">
     </form>


 <?php endif; ?>
    <?php if (!empty($history)): ?>
       <ol class="history">
           <?php foreach (array_reverse($history) as $i => $g): ?>
               <li><span class="history__n"><?php echo htmlspecialchars($g); ?></span></li>
           <?php endforeach; ?>
     </ol>
 <?php endif; ?>


</main>


</body>
</html>
