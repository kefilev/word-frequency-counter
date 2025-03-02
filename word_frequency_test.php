<?php

declare(strict_types=1);

require_once 'word_frequency_counter.php';

function assertEqual($expected, $actual, $testName) {
    if ($expected === $actual) {
        echo "[✔] PASS: $testName\n";
    } else {
        echo "[✘] FAIL: $testName - Expected: " . json_encode($expected) . " but got: " . json_encode($actual) . "\n";
    }
}

// Reset the storage file
file_put_contents('word_count.json', json_encode([]));

// Initialize the counter
$counter = new WordFrequencyCounter();

// Test 1: Process first text
$counter->processText("Love grows where kindness lives.");
assertEqual(1, $counter->getWordCount("love"), "Word 'love' should appear once");
assertEqual(1, $counter->getWordCount("kindness"), "Word 'kindness' should appear once");

// Test 2: Process second text
$counter->processText("Kindness lives in every heart.");
assertEqual(2, $counter->getWordCount("kindness"), "Word 'kindness' should now appear twice");
assertEqual(2, $counter->getWordCount("lives"), "Word 'lives' should now appear twice");
assertEqual(1, $counter->getWordCount("heart"), "Word 'heart' should appear once");

// Test 3: Get all word counts
$allCounts = $counter->getAllWordCounts();
assertEqual(2, $allCounts['kindness'] ?? 0, "Checking 'kindness' in full count list");
assertEqual(1, $allCounts['heart'] ?? 0, "Checking 'heart' in full count list");

// Test 4: Get a non-existent word
assertEqual(0, $counter->getWordCount("unknownword"), "Unknown word should return 0");

echo "Tests completed.\n";
