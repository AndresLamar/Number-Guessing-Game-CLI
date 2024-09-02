<?php

require_once('./src/game.php');

$game = new Game();

do {
    $game->showMenu();
    $option = (int) fgets(STDIN);

    if ($option === 5) {
        echo "Saliendo del programa...\n";
        break;
    }

    // if ($option === 4) {
    //     echo '\nHigh Scores:\n';
    // }

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

    $number = $game->generateNumber();

    $game->playGame($option, $number, $guess, $showHints);

    echo "\nDo you want to play again? (y/n): ";
    $playAgain = trim(fgets(STDIN));

    if ($playAgain === 'y' || $playAgain === 'Y' || $playAgain === 'yes') {
        continue;
    } else {
        echo "\nThank you for playing. Goodbye!\n";
        break;
    }
} while (true);
