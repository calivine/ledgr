<?php


function valid_format($date)
{
    $date_array = explode("-", $date);
    dump($date_array);

    return true;
}

function first_of_month()
{
    // Get First And Last Days Of Current Month
    $timestamp = strtotime(date('f Y'));
    $month_start = date('Y-m-01', $timestamp);
    return $month_start;
}

function last_of_month()
{
    $timestamp = strtotime(date('f Y'));
    $month_end = date('Y-m-t', $timestamp);
    return $month_end;
}

function last_month()
{
    return date('F',strtotime('-1 months'));
}

function date_to_string($date)
{
    return date('j F Y', strtotime($date));
}

function todays_date()
{
    return date('F d, Y', strtotime(today('America/New_York')));
}

function days_remaining()
{
    $timestamp = strtotime(date('f Y'));
    return date('t', $timestamp) - date('d', strtotime(today()));
}
