<?php


namespace App\Actions\Utility;


class DateUtility
{

    public static function first_of_month() {
        // Get First And Last Days Of Current Month
        $timestamp = strtotime(date('f Y'));
        $month_start = date('Y-m-01', $timestamp);
        return $month_start;
    }

    public static function last_of_month() {
        $timestamp = strtotime(date('f Y'));
        $month_end = date('Y-m-t', $timestamp);
        return $month_end;
    }

}