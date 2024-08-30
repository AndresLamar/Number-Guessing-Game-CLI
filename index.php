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

function playGame($option, $number, $guess)
{
    $chances = ($option === 1) ? 10 : (($option === 2) ? 5 : 3);

    $startTime = microtime(true);

    for ($i = 1; $i < $chances; $i++) {
        if ($guess === $number) {

            $endTime = microtime(true);
            $elapsedTime = $endTime - $startTime;

            echo "\nCongratulations! You guessed the correct number in " . ($i + 1) . " attempts.\n";
            echo "It took you " . round($elapsedTime, 2) . " seconds.\n";
            break;
        } elseif ($guess > $number) {
            echo "\n Incorrect! The number is less than $guess. Try again.\n";
        } else {
            echo "\n Incorrect! The number is greater  than $guess. Try again.\n";
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

    echo "\nEnter your guess: ";
    $guess = (int) fgets(STDIN);

    $number = generateNumber();

    playGame($option, $number, $guess);


    echo "\nDo you want to play again? (y/n): ";
    $playAgain = trim(fgets(STDIN));

    if ($playAgain === 'y' || $playAgain === 'Y' || $playAgain === 'yes') {
        continue;
    } else {
        echo "\nThank you for playing. Goodbye!\n";
        break;
    }
} while (true);
