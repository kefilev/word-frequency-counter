<?php

declare(strict_types=1);

class WordFrequencyCounter {
    private const STORAGE_FILE = 'word_count.json';
    private array $wordCounts = [];

    public function __construct() {
        $this->loadData();
    }

    private function loadData(): void {
        if (file_exists(self::STORAGE_FILE)) {
            $data = file_get_contents(self::STORAGE_FILE);
            $this->wordCounts = json_decode($data, true) ?? [];
        }
    }

    private function saveData(): void {
        file_put_contents(self::STORAGE_FILE, json_encode($this->wordCounts, JSON_PRETTY_PRINT));
    }

    public function processText(string $text): void {
        $words = preg_split('/\s+/', strtolower(trim($text)));
        foreach ($words as $word) {
            $cleanedWord = preg_replace('/[^a-z]/', '', $word);
            if ($cleanedWord !== '') {
                $this->wordCounts[$cleanedWord] = ($this->wordCounts[$cleanedWord] ?? 0) + 1;
            }
        }
        $this->saveData();
    }

    public function getWordCount(string $word): int {
        return $this->wordCounts[strtolower($word)] ?? 0;
    }

    public function getAllWordCounts(): array {
        return $this->wordCounts;
    }
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    $counter = new WordFrequencyCounter();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = file_get_contents('php://input');
        if (empty($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'No text provided.']);
            exit;
        }
        $counter->processText($input);
        echo json_encode(['message' => 'Text processed successfully.']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['word'])) {
            echo json_encode([$_GET['word'] => $counter->getWordCount($_GET['word'])]);
        } else {
            echo json_encode($counter->getAllWordCounts());
        }
    }
}
