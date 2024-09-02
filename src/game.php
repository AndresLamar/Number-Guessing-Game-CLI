<?php

class Game
{
    private $file = 'high_scores.json';
    private $records = [];

    public function __construct()
    {
        if (file_exists($this->file)) {
            $json = file_get_contents($this->file);
            $this->records = json_decode($json, true);
        }
    }

    public function showMenu()
    {
        echo "\nWelcome to the Number Guessing Game!\n";
        echo "I'm thinking of a number between 1 and 100. \n";
        echo "You have X chances to guess the correct number depending of the difficulty you choose. \n";

        echo "\nPlease select the difficulty level: \n";
        echo "1. Easy (10 chances) \n";
        echo "2. Medium (5 chances) \n";
        echo "3. Hard (3 chances) \n";
        echo "\nOther options: \n";
        echo "4. List high scores \n";
        echo "5. Exit \n";

        echo "\nEnter your choice: ";
    }

    public function generateNumber()
    {
        return rand(1, 100);
    }

    public function playGame($option, $number, $guess, $showHints)
    {
        $chances = ($option === 1) ? 10 : (($option === 2) ? 5 : 3);

        $lowRange = 1;
        $highRange = 100;

        $startTime = microtime(true);

        $hintsUsed = 0;
        $hintsGiven = [];

        $totalAttempts = 0;

        for ($i = 1; $i < $chances; $i++) {
            if ($guess === $number) {

                $endTime = microtime(true);
                $elapsedTime = $endTime - $startTime;

                $totalAttempts += $i;

                $highScore = $this->getHighScore($option);

                if ($highScore === null || $totalAttempts < $highScore['attempts']) {
                    $this->updateHighScore($option, $totalAttempts, $elapsedTime);
                }

                echo "\nCongratulations! You guessed the correct number in " . ($i) . " attempts.\n";
                echo "It took you " . round($elapsedTime, 2) . " seconds.\n";
                break;
            } elseif ($guess > $number) {
                echo "\n Incorrect! The number is less than $guess. Try again.\n";
                $highRange = $guess - 1;
            } else {
                echo "\n Incorrect! The number is greater than $guess. Try again.\n";
                $lowRange = $guess + 1;
            }

            if ($showHints === 'y' || $showHints === 'Y' || $showHints === 'yes') {
                $hintsUsed++;
                $hint = $this->provideHint($number, $guess, $hintsUsed, $lowRange, $highRange, $hintsGiven);
                echo $hint;
            }

            echo "\nEnter your guess: ";
            $guess = (int) fgets(STDIN);
        }

        if ($i === $chances) {
            echo "\nSorry, you ran out of chances. The correct number was $number.\n";
        }
    }

    public function provideHint($number, $guess, $hintsUsed, $lowRange, $highRange, &$hintsGiven)
    {
        $hints = [
            function ($number, $guess) use (&$hintsGiven) {

                if (!in_array('parity', $hintsGiven)) {
                    $hintsGiven[] = 'parity';
                    return ($number % 2 === 0) ? "\nHint: The number is even.\n" : "\nHint: The number is odd.\n";
                }
                return '';
            },
            function ($number, $guess) use ($lowRange, $highRange, $hintsUsed) {

                $rangeWidth = intval(($highRange - $lowRange) / max(2, $hintsUsed + 2));
                $lowerBound = max($lowRange, $number - $rangeWidth);
                $upperBound = min($highRange, $number + $rangeWidth);
                return "\nHint: The number is between $lowerBound and $upperBound.\n";
            }
        ];

        $hintIndex = $hintsUsed % count($hints);
        $hint = $hints[$hintIndex]($number, $guess, $lowRange, $highRange);

        if ($hint === '') {
            $hintIndex = ($hintIndex + 1) % count($hints);
            $hint = $hints[$hintIndex]($number, $guess, $lowRange, $highRange);
        }

        return $hint;
    }

    public function getHighScore($option)
    {
        if (empty($this->records)) {
            return null;
        }

        $bestScore = null;

        $difficulty = match ($option) {
            1 => 'easy',
            2 => 'medium',
            3 => 'hard',
            default => null,
        };

        foreach ($this->records as $record) {
            if ($record['difficulty'] === $difficulty) {
                if ($bestScore === null || $record['attempts'] < $bestScore['attempts']) {
                    $bestScore = $record;
                }
            }
        }

        return $bestScore ?? null;
    }

    public function saveToJson($records)
    {
        $json = json_encode($records, JSON_PRETTY_PRINT);
        file_put_contents($this->file, $json);
    }

    public function updateHighScore($option, $attempts, $time)
    {
        $difficulty = match ($option) {
            1 => 'easy',
            2 => 'medium',
            3 => 'hard',
            default => null,
        };

        $updated = false;

        foreach ($this->records as $key => $record) {
            if ($record['difficulty'] === $difficulty) {
                if ($attempts < $record['attempts']) {
                    $this->records[$key]['attempts'] = $attempts;
                    $this->records[$key]['time'] = round($time, 2);
                    $updated = true;
                }
                break;
            }
        }

        if (!$updated) {
            $this->records[] = [
                'difficulty' => $difficulty,
                'attempts' => $attempts,
                'time' => round($time, 2),
            ];
        }

        // Guardar los registros actualizados
        $this->saveToJson($this->records);
    }

    public function showHighScores()
    {
        if (empty($this->records)) {
            return "No high scores found.\n";
        }

        $scores = [
            'Easy' => $this->getHighScore(1),
            'Medium' => $this->getHighScore(2),
            'Hard' => $this->getHighScore(3),
        ];

        echo str_repeat("=", 30) . "\n";
        echo "       HIGH SCORES       \n";
        echo str_repeat("=", 30) . "\n";

        foreach ($scores as $difficulty => $score) {
            if ($score === null) {
                echo "$difficulty: No high score yet.\n";
            } else {
                echo "$difficulty: Attempts: {$score['attempts']} | Time: {$score['time']} seconds\n";
            }
        }

        echo str_repeat("=", 30) . "\n";
    }
}
