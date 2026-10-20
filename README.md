# The Combination — Guess the Number Game

A single-page PHP mini-project where the server locks a random number
between 1 and 100 inside a "combination dial," and the player has to
crack it by guessing, using "Too High" / "Too Low" hints and an
attempt counter.

---

## Student Details

| Field | Value |
|---|---|
| Name | Bhoomi |
| Roll Number | 2442952 |
| Class | BCA 5th Semester |
| Subject | PHP |

## Project Objective

Build a web application where the computer generates a random number
(1–100). The user enters guesses through an HTML form, and the app
displays **Too High**, **Too Low**, or **Correct**, counting the total
number of attempts until the number is guessed correctly.

## Features

- Random number generation (1–100) using PHP's cryptographically
  secure `random_int()`.
- Guess submitted via an HTML `<form>`, validated and processed in PHP.
- Instant **Too High / Too Low** hints on the dial, and a **Correct!** message with the total attempts on a win.
- Live **attempt counter**.
- **Guess history** strip showing every number tried, most recent first.
- **Start over** control to abandon the current round early.
- **Play again** flow that locks a fresh number after a win.
- Server-side input validation (rejects non-numbers and out-of-range
  guesses without crashing or losing game state).
- Fully responsive, single-file-styled UI with no JavaScript required
  — the game works with pure HTML forms and PHP sessions.

## Algorithm / Flowchart

```
START
  |
  v
Is there an active game in the session?
  NO  -> generate secret number (1-100), reset attempts to 0
  YES -> keep existing secret number and attempts
  |
  v
Show the dial (idle / hint / result) and the guess form
  |
  v
Has the user submitted a guess?
  NO  -> wait (END of this request)
  YES -> continue
  |
  v
Is the guess a valid integer between 1 and 100?
  NO  -> show "Enter a whole number between 1 and 100." -> back to form
  YES -> continue
  |
  v
attempts = attempts + 1
add guess to history
  |
  v
Compare guess to secret number
  guess <  secret -> show "TOO LOW"
  guess >  secret -> show "TOO HIGH"
  guess == secret -> mark solved, show "Correct!" + total attempts
  |
  v
Solved?
  NO  -> loop back to the guess form
  YES -> show "Lock a new number" button -> restarts flow at the top
  |
  v
END
```

## Technologies Used

- **HTML5** — page structure and the guess form
- **CSS3** — the "combination lock" dial UI, states, and responsive layout
- **PHP** (no framework) — random number generation, form handling,
  validation, and game-state persistence via `$_SESSION`
- **Google Fonts** — Fraunces (display) and JetBrains Mono (numerals/UI)

No database is used — game state lives entirely in the PHP session for
the duration of the round, as required by the assignment.

## Steps to Run

1. Make sure PHP is installed (PHP 7.4+ recommended).
   - Check with: `php -v`
2. Clone this repository and move into it:
   ```bash
   git clone https://github.com/bhardwajbhoomi017-prog/2442952_GuessTheNumberGame.git
   cd 2442952_GuessTheNumberGame
   ```
3. Start PHP's built-in development server from the project folder:
   ```bash
   php -S localhost:8000
   ```
4. Open your browser at:
   ```
   http://localhost:8000/index.php
   ```
5. Enter a guess between 1 and 100 and click **Turn dial**. Keep
   guessing until the dial shows the correct number, then click
   **Lock a new number** to play again.

## Output Screenshots

**Start screen**

![Start screen](assets/output-start.png)

**"Too Low" feedback**

![Too Low feedback](assets/output-too-low.png)

**Correct guess**

![Correct guess](assets/output-correct.png)
