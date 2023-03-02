<?php

$list = array (
    '09:00-11:00',
    '11:00-13:00',
    '15:00-16:00',
    '17:00-20:00',
    '20:30-21:30',
    '21:30-22:30',
);
function isValidTimeInterval(string $timeInterval): bool
{
    $matches = [];
    if (!preg_match('/^([0-9]{2}):([0-9]{2})-([0-9]{2}):([0-9]{2})$/', $timeInterval, $matches)) {
        return false;
    }

    if ($matches[1] > 23 || $matches[1] < 0) {
        return false;
    }

    if ($matches[2] > 60 || $matches[2] < 0) {
        return false;
    }

    if ($matches[3] > 23 || $matches[3] < 0) {
        return false;
    }

    if ($matches[4] > 60 || $matches[4] < 0) {
        return false;
    }

    $totalMinutesFrom = (($matches[1] * 60) + $matches[2]);
    $totalMinutesTo = (($matches[3] * 60) + $matches[4]);

    if ($totalMinutesFrom > $totalMinutesTo) {
        return false;
    }

    return true;
}

function timeToMinutes(string $time): int
{
    $times = explode(':', $time);
    return ($times[0] * 60) + $times[1];
}

function intervalToMinMax(string $timeInterval): array
{
    $times = explode('-', $timeInterval);
    return [
        timeToMinutes($times[0]),
        timeToMinutes($times[1]),
    ];
}
function checkTimeInterval(string $timeInterval): bool
{
    global $list;

    $minMaxMinutes = intervalToMinMax($timeInterval);

    foreach ($list as $rowTimeInterval) {
        $mixMaxRowInterval = intervalToMinMax($rowTimeInterval);
        if ($mixMaxRowInterval[1] <= $minMaxMinutes[0]) {
            continue;
        }

        if ($mixMaxRowInterval[0] >= $minMaxMinutes[1]) {
            continue;
        }
        return false;
    }
    return true;
}

echo isValidTimeInterval('14:00-15:00');
echo isValidTimeInterval('24:00-12:00');

$checkInterval = [
    '09:00-11:00',
    '11:00-13:00',
    '23:00-23:30'
];

$result = [];

foreach ($checkInterval as $check) {
    $result[$check] = checkTimeInterval($check);
}

var_dump($result);