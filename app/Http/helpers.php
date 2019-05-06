<?php

function cm()
{
    return \App\Setting::first()->current_month;
}

function cmn()
{
    return mn(cm());
}

function cy()
{
    return \App\Setting::first()->current_year;
}

function mn($number)
{
    $dt = DateTime::createFromFormat('!m', $number);
    return strtolower($dt->format('F'));
}

function month_color($number)
{
    if ($number<cm()) {
        return 'danger';
    }
    if ($number==cm()) {
        return 'primary';
    }
}

function color($number)
{
    if ($number == 1) {
        return 'warning';
    }
    if ($number <= 3) {
        return 'primary';
    }
    if ($number <= 10) {
        return 'success';
    }
    if ($number <= 20) {
        return 'info';
    }
    return 'dark';
}

function rank_color($number)
{
    if ($number == 1) {
        return 'warning text-dark';
    }
    if ($number == 2) {
        return 'primary';
    }
    if ($number == 3) {
        return 'success text-light';
    }
    if ($number == 4) {
        return 'secondary';
    }
}

function nf($number)
{
    return is_numeric($number) ? number_format($number) : null;
}

function get_points($month,$year)
{
    return \DB::table('points')->where('month', $month)->where('year', $year)->sum('amount');
}

function base_point_exists($type)
{
    return (bool) App\BasePoint::where('type', $type)->first();
}

function trophy_exists($title)
{
    return (bool) App\Trophy::where('title', $title)->first();
}

function trophies_exist($titles)
{
    $result = true;
    foreach ($titles as $title) {
        if (!trophy_exists($title)) {
            $result = false;
            break;
        }
    }
    return $result;
}

function prepare_multiple($inputs)
{
    $result = [];
    foreach ($inputs as $key => $array) {
        if(is_array($array) && count($array)){
            foreach ($array as $i => $value) {
                if ($value) {
                    $result[$i][$key] = $value;
                    $result[$i]['created_at'] = Carbon\Carbon::now();
                    $result[$i]['updated_at'] = Carbon\Carbon::now();
                }
            }
        }
    }
    return $result;
}
