<?php
        // принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел.
        // Пример: как аргументы принимаются три строки «Иванов», «Иван» и «Иванович», а возвращается одна строка — «Иванов Иван Иванович».
    function getFullnameFromParts($surname, $name, $patronymic){
        return $surname.' '.$name.' '.$patronymic;
    }

    //принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronomyc’.
    function getPartsFromFullname($fullName=''){
        $fio =['surname', 'name', 'patronymic'];
        $fio_ = explode(" ", $fullName);
        // print_r($fio).'</br>';
        // print_r($fio_).'</br>';
        return array_combine($fio, $fio_);
    }

    function getShortName($fullName){
        $person = getPartsFromFullname($fullName);

        return mb_strtoupper(mb_substr($person['name'], 0, 1)).mb_strtolower(mb_substr($person['name'].'.', 1, -1)).' '.mb_strtoupper(mb_substr($person['surname'], 0, 1, 'UTF-8')).'.';
    }

    function getGenderFromName($fullName){
        $person = getPartsFromFullname($fullName);
        $sex = 0;
        $name = $person['name'];
        $surname = $person['surname'];
        $patronymic = $person['patronymic'];
        // echo mb_substr($patronymic, mb_strlen($patronymic)-2, 2).'</br>';
        // echo mb_substr($name, mb_strlen($name)-1, 1).'</br>';
        // echo mb_substr($surname, mb_strlen($surname)-1, 1).'</br>';

// male check
        if(mb_substr($patronymic, mb_strlen($patronymic)-2, 2) ==='ич'){
            $sex += 1;
        }
        if(mb_substr($name, mb_strlen($name)-1, 1) ==='й' || mb_substr($name, mb_strlen($name)-1, 1) === 'н'){
            $sex += 1;
        }
        if(mb_substr($surname, mb_strlen($surname)-1, 1) ==='в'){
            $sex += 1;
        }
//female check
    // отчество
        if(mb_substr($patronymic, mb_strlen($patronymic)-3, 3) ==='вна'){
            $sex -= 1;
        }
    // имя
        if(mb_substr($name, mb_strlen($name)-1, 1) ==='a'){
            $sex -= 1;
        }
    // фамилия
        if(mb_substr($surname, mb_strlen($surname)-2, 2) ==='ва'){
            $sex -= 1;
        }

        if($sex === 0){
            return 0;
        } elseif ($sex > 0 ){
            return 1;
        } else {
            return -1;
        }
    }

    function getGenderDescription($persons = []){
        //print_r($persons).'</br>';
        $aggr = ['female'=>'', 'male'=>'', 'na'=>''];
        $aggr['female'] = 0;
        $aggr['male'] = 0;
        $aggr['na'] = 0;

        foreach($persons as $person){
            
            switch(getGenderFromName($person['fullname'])){
                case 1 :
                    $aggr['male'] += 1;
                    break;
                case 0 :
                    $aggr['na'] += 1;
                    break;
                case -1 :
                    $aggr['female'] += 1;
                    break;
                };
        }
        //echo 'sum: '.array_sum($aggr);
        echo 'Гендерный состав аудитории:</br>';
        echo '---------------------------</br>';
        echo 'Мужчины - '.round($aggr['male']*100/array_sum($aggr),2).'%</br>';
        echo 'Женщины - '.round($aggr['female']*100/array_sum($aggr),2).'%</br>';
        echo 'Не удалось определить - '.round($aggr['na']*100/array_sum($aggr),2).'%</br>';
        //print_r($aggr).'</br>';
    }

    function getPerfectPartner($surname, $name, $patronymic, $persons){
        $return = '';
        $fullName = getFullnameFromParts($surname, $name, $patronymic);
        $gender = getGenderFromName($fullName);

        $rand_key = array_rand($persons);
        $randomPerson = $persons[$rand_key]['fullname'];
        $randomPersonGender = getGenderFromName($persons[$rand_key]['fullname']);
        $i=0; // not more than $i iterations(debug purpose);

        while($gender === $randomPersonGender || $gender === 0 || $randomPersonGender === 0 || $i < 15){
            
            if($gender != $randomPersonGender && $gender != 0 && $randomPersonGender != 0) {
                 $return = getShortName($fullName).' + '.getShortName($randomPerson).'=</br>';
                 $return = $return.'&hearts; Идеально на '.(rand(5000,10000)/100).'% &hearts;';
                 break;
            }

            $rand_key = array_rand($persons);
            $randomPerson = $persons[$rand_key]['fullname'];
            $randomPersonGender = getGenderFromName($persons[$rand_key]['fullname']);

            $i += 1;
        }
        
        return $return;
    }
?>