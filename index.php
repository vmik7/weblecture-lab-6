<?php 
    // Считываем html
    $data = file_get_contents("http://grafika.me/node/37");

    // Преобразуем в текст
    $text = preg_replace('/<[^>]+>|<\/[^>]+>/Ums', '', $data);

    // Преобразуем специальные html символы в обычные
    $text_decoded = html_entity_decode($text);

    // Удаляем все комментарии в коде
    $text_with_out_comments = preg_replace('/\/\/(.*)/', '', $text_decoded);

    // Ищем все блоки между begin ... end;
    preg_match_all('/begin([^а-яА-Я]+;[^а-яА-Я]*)end/ms', $text_with_out_comments, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $item) {

        // Убираем все циклы и лишние end;
        $entry = preg_replace('/for(.*)begin|while(.*)begin|end;/U', '', $item[1]);

        // Ищем операторы
        preg_match_all('/(.*);/Us', $entry, $out, PREG_SET_ORDER);

        echo '<h1>Найден блок begin...end:</h1>';
        echo '<hr/>';
        echo $item[0];
        echo '<hr/>';
        echo '<h2>Вот все операторы в нём:</h2>';
        echo '<hr/>';
        
        foreach ($out as $op) {
            echo $op[0];
            echo '<br/>';
        }

        echo '<hr/>';
    }

?>