<?php

$result = $_POST['result'] ?? '';
$answer = $_POST['answer'] ?? '';
$wins = $_POST['wins'] ?? 0;
$loses = $_POST['loses'] ?? 0;

if ($answer != '') {
    if ($answer == $result) {
        $wins++;
        echo '<b>Правильно!</b>';
    } else {
        $loses++;
        echo '<b>Неправильно!</b>';
    }

    echo '<br/>';
    echo "Выигрышей: $wins, проигрышей: $loses";
    echo '<br/>';
    echo '<br/>';
}

echo "Давай поиграем в игру математика" . '<br/><br/>';
$one = rand(50, 100);
$two = rand(1, 50);
$result = $one - $two;

echo "$one - $two" . '<br/>';

echo " </br>
<form name='math' action='three.php' method='post' xmlns=\"http://www.w3.org/1999/html\">
<input type='hidden' name='result' value='$result'/>
<input type='hidden' name='wins' value='$wins'/>
<input type='hidden' name='loses' value='$loses'/>
<label>Введи результат</label><input name='answer'></input>
<button type='submit'>Проверить?</button>
</form>
<a href='three.php'>Заново</a>
";