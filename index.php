<?php
    include('func.php');
    include('data.php');
    echo '</br>=====«Разбиение и объединение ФИО»====</br>';
    //задача «Разбиение и объединение ФИО»;
    echo getFullnameFromParts('Шепелев', 'Алексей', 'Владимирович').'</br>';
    echo '</br>=====«Сокращение ФИО»=====</br>';
    //задача «Сокращение ФИО»
    echo getShortName('Жаркова Алла Юрьевна').'</br>';
    echo '</br>=====«Функция определения пола по ФИО»========</br>';
    //задача «Функция определения пола по ФИО»;
    switch(getGenderFromName('Мельникова Ксения Витальевна')){
        case 1 :
            echo 'М'.'</br>';
            break;
        case 0 :
            echo 'Н/О'.'</br>';
            break;
        case -1 :
            echo 'Ж'.'</br>';
            break;
        };

    //print_r(getPartsFromFullname('марианна Всеволодовна Трушникова'));
    echo '</br>=====Определение возрастно-полового состава======</br>';
    getGenderDescription($example_persons_array);
    echo '</br>=====Идеальный подбор пары=======</br>';
    echo getPerfectPartner('Гауляйторовна', 'Клавдия','Петровна', $example_persons_array);
?>