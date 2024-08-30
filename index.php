<?php

function showMenu()
{
    echo "\nWelcome to the Number Guessing Game!\n";
    echo "I'm thinking of a number between 1 and 100. \n";
    echo "You have X chances to guess the correct number depending of the difficulty you choose. \n";

    echo "\nPlease select the difficulty level: \n";
    echo "1. Easy (10 chances) \n";
    echo "2. Medium (5 chances) \n";
    echo "3. Hard (3 chances) \n";

    echo "\nEnter your choice: ";
}

function generateNumber()
{
    return rand(1, 100);
}

function provideHint($number, $guess, $hintsUsed, $lowRange, $highRange, &$hintsGiven)
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

    // $hintIndex = $hintsUsed % count($hints);
    // $hint = $hints[$hintIndex]($number, $guess);

    // if ($hint === '') {
    //     $hintIndex = ($hintIndex + 1) % count($hints);
    //     $hint = $hints[$hintIndex]($number, $guess);
    // }

    return $hint;
}


function playGame($option, $number, $guess, $showHints)
{
    $chances = ($option === 1) ? 10 : (($option === 2) ? 5 : 3);

    $lowRange = 1;
    $highRange = 100;

    $startTime = microtime(true);

    $hintsUsed = 0;

    $hintsGiven = [];

    for ($i = 1; $i < $chances; $i++) {
        if ($guess === $number) {

            $endTime = microtime(true);
            $elapsedTime = $endTime - $startTime;

            echo "\nCongratulations! You guessed the correct number in " . ($i + 1) . " attempts.\n";
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
            $hint = provideHint($number, $guess, $hintsUsed, $lowRange, $highRange, $hintsGiven);
            echo $hint;
        }

        echo "\nEnter your guess: ";
        $guess = (int) fgets(STDIN);
    }

    if ($i === $chances) {
        echo "\nSorry, you ran out of chances. The correct number was $number.\n";
    }
}

do {
    showMenu();

    $option = (int) fgets(STDIN);

    $output = match ($option) {
        1 => "Great! You have selected the Easy difficulty level.",
        2 => "Great! You have selected the Medium difficulty level.",
        3 => "Great! You have selected the Hard difficulty level.",
        default => 'Invalid option. Please try again.',
    };

    echo "\n" . $output . "\n" . "Let's start the game!\n";

    echo "\n(Show hints? (y/n)): ";
    $showHints = trim(fgets(STDIN));

    echo "\nEnter your guess: ";
    $guess = (int) fgets(STDIN);

    $number = generateNumber();

    playGame($option, $number, $guess, $showHints);


    echo "\nDo you want to play again? (y/n): ";
    $playAgain = trim(fgets(STDIN));

    if ($playAgain === 'y' || $playAgain === 'Y' || $playAgain === 'yes') {
        continue;
    } else {
        echo "\nThank you for playing. Goodbye!\n";
        break;
    }
} while (true);
