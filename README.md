# Word Frequency Counter

## Description
This is a simple PHP script that counts word frequencies from text input. It:
- Accepts **POST** requests to store words and update their count.
- Accepts **GET** requests to retrieve all word counts or a specific word count.
- Stores data in a `word_count.json` file for persistence.

## Requirements
- PHP 8.2+
- Web server with PHP enabled (e.g., Apache, Nginx) OR CLI mode

## Installation
1. Clone or download this repository.
2. Ensure PHP is installed and configured.
3. Place `word_frequency_counter.php` in a server-accessible directory.

## Usage

### 1. Running the Server (Optional for Testing)
Start the PHP server:

Then, access `http://localhost:8000/word_frequency_counter.php`.

### 2. Sending Data (POST Request)
To add words from a text input:
```sh
curl -X POST -d "Love grows where kindness lives." http://localhost:8000/word_frequency_counter.php
```
Response:
```json
{"message": "Text processed successfully."}
```

### 3. Retrieving All Word Counts (GET Request)
```sh
curl -X GET http://localhost:8000/word_frequency_counter.php
```
Response Example:
```json
{"love":1,"grows":1,"where":1,"kindness":1,"lives":1}
```

### 4. Retrieving a Specific Word Count (GET Request)
```sh
curl -X GET "http://localhost:8000/word_frequency_counter.php?word=kindness"
```
Response Example:
```json
{"kindness":2}
```

## Running Tests
To run tests manually:
```sh
php word_frequency_test.php
```
This script will verify:
- Correct word count storage
- Retrieval of all word counts
- Retrieval of specific words
- Handling of unknown words

## Notes
- The script automatically creates `word_count.json` for storing data.
- Only alphabetic words are counted (punctuation is removed).
- Data persists across requests.

## Limitations
- This implementation does not handle concurrent writes efficiently.
- Works best in single-user environments or small-scale applications.

## License
This project is provided under the MIT License.

