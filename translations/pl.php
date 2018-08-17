<?php

// sunday first as date('w') is zero-based on sunday
$days = array(
    'niedzielę',
    'poniedziałek',
    'wtorek',
    'środę',
    'czwartek',
    'piątek',
    'sobotę',
);

$months = array(
    'stycznia',
    'lutego',
    'marca',
    'kwietni',
    'maja',
    'czerwca',
    'lipica',
    'sierpnia',
    'wrzesinia',
    'października',
    'listopada',
    'grudnia',
);


return array(
    'Unable to fully convert this rrule to text.' => 'Nie udało się przekonwertować reguły.',
    'for %count% times' => function ($str, $params) use ($days, $months) {
        return 'przez %count% razy';
    },
    'for one time' => 'jeden raz',
    '(~ approximate)' => '(~ w przybliżeniu)',
    'until %date%' => 'do %date%', // e.g. every year until July 4, 2014
    'day_date' => function ($str, $params) use ($days, $months) { // outputs a day date, e.g. July 4, 2014
        return $months[date('n', $params['date']) - 1] . ' '. date('j, Y', $params['date']);
    },
    'day_month' => function ($str, $params) use ($days, $months) { // outputs a day month, e.g. July 4
        return  $params['day']. ' '. $months[$params['month'] - 1];
    },
    'day_names' => $days,
    'month_names' => $months,
    'and' => 'i',
    'or' => 'lub',
    'in_month' => 'w', // e.g. weekly in January, May and August
    'in_week' => 'w', // e.g. yearly in week 3
    'on' => function($str, $param) use ($days, $months) {
        return 'w';
    }, // e.g. every day on Tuesday, Wednesday and Friday
    'the_for_monthday' => 'the', // e.g. monthly on Tuesday the 1st
    'the_for_weekday' => 'the', // e.g. monthly on the 4th Monday
    'on the' => 'od', // e.g. every year on the 1st and 200th day
    'of_the_month' => 'of the month', // e.g. every year on the 2nd or 3rd of the month
    'every %count% years' => 'co %count% lat',
    'every year' => 'co rok',
    'every_month_list' => 'każdy', // e.g. every January, May and August
    'every %count% months' => 'co %count% miesięcy',
    'every month' => 'co miesiąc',
    'every %count% weeks' => 'co %count% tygodni',
    'every week' => 'co tydzień',
    'every %count% days' => 'co %count% dni',
    'every day' => 'codziennie',
    'last' => 'ostatni', // e.g. 2nd last Friday
    'days' => 'dni',
    'day' => 'dzień',
    'weeks' => 'tygodni',
    'week' => 'tydzień',
    // formats a number with a prefix e.g. every year on the 1st and 200th day
    // negative numbers should be handled as in '5th to the last' or 'last'
    //
    // if has_negatives is true in the params, it is good form to add 'day' after
    // each number, as in: 'every month on the 5th day or 2nd to the last day' or
    // it may be confusing like 'every month on the 5th or 2nd to the last day'
    'ordinal_number' => function ($str, $params) {
        $number = $params['number'];

        $ends = array('-go', '-go', ' dnia', ' dnia', ' dnia', ' dnia', ' dnia', ' dnia', ' dnia', ' dnia');
        $suffix = '';

        $isNegative = $number < 0;

        if ($number == -1) {
            $abbreviation = 'last';
        } else {
            if ($isNegative) {
                $number = abs($number);
                $suffix = ' to the last';
            }

            if (($number % 100) >= 11 && ($number % 100) <= 13) {
                $abbreviation = $number.'th';
            } else {
                $abbreviation = $number.$ends[$number % 10];
            }
        }

        if (!empty($params['has_negatives'])) {
            $suffix .= ' day';
        }

        return $abbreviation . $suffix;
    },
);
