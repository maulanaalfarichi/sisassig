<?php

namespace App\Helpers;
  
class DateHelper {
	public static $month = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    public static function id_date($date) {
        if (empty($date)) return '';

        $part = explode('-', $date);
        return $part[2] . ' ' . self::$month[ltrim($part[1], 0)] . ' ' . $part[0];
    }

    public static function id_datetime($datetime) {
        if (empty($datetime)) return '';

        $part = explode(' ', $datetime);
        $datepart = explode('-', $part[0]);
        $timepart = explode(':', $part[1]);
        return $datepart[2] . ' ' . self::$month[ltrim($datepart[1], 0)] . ' ' . $datepart[0] . ' ' .$timepart[0]. ':' . $timepart[1];
    }

    public static function get_age($date) {
        //if (empty($date)) return 0;

        $date = new \DateTime($date);
        $today = new \DateTime('today');
        return $today->diff($date)->y;
    }
}