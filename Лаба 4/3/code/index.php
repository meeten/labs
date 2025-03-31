<!DOCTYPE html>
<html>
<head>
    <title>Количество слов с повторяющимися буквами</title>
</head>
<body>
    <form method="post">
        <textarea name="text"><?php if(isset($_POST["text"])) { echo htmlspecialchars($_POST["text"]); } ?></textarea>
        <input type="submit" value="Анализировать">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $text = $_POST["text"];
        $words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $totalWords = count($words);
        $repeatedLettersWords = 0;
        
        foreach ($words as $word) {
            // Очищаем слово от знаков препинания и приводим к нижнему регистру
            $cleanWord = preg_replace('/[^a-zA-Zа-яА-ЯёЁ]/u', '', $word);
            $cleanWord = mb_strtolower($cleanWord, 'UTF-8');
            
            if (mb_strlen($cleanWord, 'UTF-8') > 1) { // Игнорируем слова из одной буквы
                $letters = preg_split('//u', $cleanWord, -1, PREG_SPLIT_NO_EMPTY);
                $uniqueLetters = array_unique($letters);
                if (count($letters) > count($uniqueLetters)) {
                    $repeatedLettersWords++;
                }
            }
        }
        
        echo "<h3>Результат анализа:</h3>";
        echo "Всего слов: $totalWords<br>";
        echo "Слов с повторяющимися буквами: $repeatedLettersWords";
    }
    ?>
</body>
</html>