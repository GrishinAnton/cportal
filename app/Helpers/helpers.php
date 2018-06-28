<?php

if (! function_exists('rus_date')) {
    /**
     * Get russian date
     *
     * @param $dates
     * @return array
     */
    function rus_date($dates)
    {
        $rus = [];
        foreach ($dates as $key => $date) {
            $exp = explode('-', $key);
            switch ($exp['1']) {
                case 01:
                    $rus[$key] = 'Январь '.$exp[0];
                    break;
                case 02:
                    $rus[$key] = 'Февраль '.$exp[0];
                    break;
                case 03:
                    $rus[$key] = 'Март '.$exp[0];
                    break;
                case 04:
                    $rus[$key] = 'Апрель '.$exp[0];
                    break;
                case 05:
                    $rus[$key] = 'Мая '.$exp[0];
                    break;
                case 06:
                    $rus[$key] = 'Июнь '.$exp[0];
                    break;
                case 07:
                    $rus[$key] = 'Июль '.$exp[0];
                    break;
                case '08':
                    $rus[$key] = 'Август '.$exp[0];
                    break;
                case '09':
                    $rus[$key] = 'Сентябрь '.$exp[0];
                    break;
                case 10:
                    $rus[$key] = 'Октябрь '.$exp[0];
                    break;
                case 11:
                    $rus[$key] = 'Ноябрь '.$exp[0];
                    break;
                case 12:
                    $rus[$key] = 'Декабрь '.$exp[0];
                    break;
            }
        }

        return $rus;
    }
}

if (! function_exists('input_date')) {
    /**
     * Get date from input date
     *
     * @param bool $filled
     * @param null $date
     * @return array|null
     */
    function input_date($filled = false, $date = null)
    {
        if ($filled) {
            $date = explode('-', $date);

            if (empty($date[1])) {
                $date[1] = date('m');
            }
        } else {
            $date[0] = date('Y');
            $date[1] = date('m');
        }

        return $date;
    }
}

if (! function_exists('format_date')) {
    /**
     * Format date
     *
     * @param $format
     * @param $date
     * @return string
     */
    function format_date($format, $date)
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (! function_exists('day_of_week')) {
    /**
     * Day of week
     *
     * @param $date
     * @return mixed
     */
    function day_of_week($date)
    {
        $day = format_date('D', $date);

        $dayOfWeek = [
            'Mon' => 'Пн',
            'Tue' => 'Вт',
            'Wed' => 'Ср',
            'Thu' => 'Чт',
            'Fri' => 'Пт',
            'Sat' => 'Сб',
            'Sun' => 'Вс',
        ];

        return $dayOfWeek[$day];
    }
}

if (! function_exists('month_ru')) {
    /**
     * Month english to russia
     *
     * @param $month
     * @return mixed
     */
    function month_ru($month) {
        $months = [
            'January' => 'Январь',
            'February' => 'Февраль',
            'March' => 'Март',
            'April' => 'Апрель',
            'May' => 'Май',
            'June' => 'Июнь',
            'July' => 'Июль',
            'August' => 'Август',
            'September' => 'Сентябрь',
            'October' => 'Октябрь',
            'November' => 'Ноябрь',
            'December' => 'Декабрь',
        ];

        return $months[$month];
    }
}
