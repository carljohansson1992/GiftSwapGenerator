<?php
// $argc is a PHP variable that counts the number of arguments passed with the script, including
// the script's name. If $argc < 2, no names have been passed, only the script name.
// But let's be honest, if there are only two names, they can figure out who to give a present to themselves. 
// That's why the if statement checks for $argc < 3.

if ($argc < 3) {
    echo "Ho ho ho! 🎅\nPlease provide two or more participants for the Christmas gift exchange!\n";
    exit(1);
}

// $argv is the array of arguments. Here, we extract the array starting from index 1,
// since index 0 is the script's name.
$participants = array_slice($argv, 1);

// Check for duplicate names and prompt the user if any are found
$counts = array_count_values($participants);
$duplicates = array_filter($counts, function($count) {
    return $count > 1;
});

if (!empty($duplicates)) {
    echo "Uh oh! It seems like some participants have the same name. 🎅\n";
    echo "Please make sure to differentiate them, and don't forget to wrap names with spaces in single quotes!\n";
    echo "For example: 'Santa Claus'.\n";
    exit(1);
}

function generateGiftExchanges($participants) {
    do {
        $receivers = $participants;
        shuffle($receivers);

        $valid = true;
        foreach ($participants as $i => $giver) {
            if ($giver === $receivers[$i] || 
                $participants[array_search($receivers[$i], $participants)] === $giver) {
                $valid = false;
                break;
            }
        }
    } while (!$valid); 

    $giftExchanges = array_combine($participants, $receivers);
    return $giftExchanges;
}

$giftExchanges = generateGiftExchanges($participants);

// Print the festive gift exchanges
echo "\n🎁🎄 Here are the gift exchanges for this year's Christmas celebration! 🎄🎁\n";
echo "---------------------------------------------------\n";

foreach ($giftExchanges as $giver => $receiver) {
    $capitalizedGiver = ucwords($giver);
    $capitalizedReceiver = ucwords($receiver);
    echo "$capitalizedGiver is giving a gift to 🎁 $capitalizedReceiver!\n";
}

echo "---------------------------------------------------\n";
echo "Happy gifting! May your holidays be filled with joy and cheer! 🎉\n";

// To run the script in the terminal: 
// cd /path/to/your/folder
// php giftExChanges.php name1 name2 name3