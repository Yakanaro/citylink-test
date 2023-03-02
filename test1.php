<?php

# Использовать данные:

// Список районов
$areas = array (
    1 => '5-й поселок',
    2 => 'Голиковка',
    3 => 'Древлянка',
    4 => 'Заводская',
    5 => 'Зарека',
    6 => 'Ключевая',
    7 => 'Кукковка',
    8 => 'Новый сайнаволок',
    9 => 'Октябрьский',
    10 => 'Первомайский',
    11 => 'Перевалка',
    12 => 'Сулажгора',
    13 => 'Университетский городок',
    14 => 'Центр',
);

// Близкие районы, связь осуществляется по индентификатору района из массива $areas
$nearby = array (
    1 => array(2,11),
    2 => array(12,3,6,8),
    3 => array(11,13),
    4 => array(10,9,13),
    5 => array(2,6,7,8),
    6 => array(10,2,7,8),
    7 => array(2,6,8),
    8 => array(6,2,7,12),
    9 => array(10,14),
    10 => array(9,14,12),
    11 => array(13,1,9),
    12 => array(1,10),
    13 => array(11,1,8),
    14 => array(9,10),
);

// список сотрудников
$workers = array (
    0 => array (
        'login' => 'login1',
        'area_name' => 'Октябрьский', //9
    ),
    1 => array (
        'login' => 'login2',
        'area_name' => 'Зарека', //5
    ),
    2 => array (
        'login' => 'login3',
        'area_name' => 'Сулажгора', //12
    ),
    3 => array (
        'login' => 'login4',
        'area_name' => 'Древлянка', //3
    ),
    4 => array (
        'login' => 'login5',
        'area_name' => 'Центр', //14
    ),
);

function check_worker($area)
{
    global $workers;

    $key = array_search( $area, array_column( $workers, 'area_name' ));
    print_r($key);

    if ($key === false){
        return false;
    }

    return $workers[$key]['login'];
}

function check_neighbors($area)
{
    global $areas, $nearby;

    $area_num = array_search($area, $areas);

    $neighbors_arr = array_map(function($n) use ($area_num){
        if (!in_array($area_num, $n)) {
            return null;
        }
        return $n;
    }, $nearby);

    $neighbors_arr = array_values(array_diff($neighbors_arr, array('')));
    if(!$neighbors_arr)
        return [];
    $neighbors_arr = call_user_func_array('array_merge', $neighbors_arr);
    return array_unique(array_values(array_diff($neighbors_arr, array($area_num))));
}

function find_worker($area)
{
    global $areas;

    $result = check_worker($area);

    if($result === false){
        $neighbors_arr = check_neighbors($area);

        $tmp = '';
        foreach ($neighbors_arr as $value) {
            $result = check_worker($areas[$value]).' '.$tmp;
            $tmp = $result;
        }
        if(trim($result)){
            return $result;
        }else{
            return null;
        }
    }
    return $result;
}

echo find_worker('Древлянка');
