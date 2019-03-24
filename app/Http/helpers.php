<?php

function cm()
{
    return \App\Setting::first()->current_month;
}

function cmn()
{
    return mn(cm());
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

function cy()
{
    return \App\Setting::first()->current_year;
}

function mn($number)
{
    $dt = DateTime::createFromFormat('!m', $number);
    return strtolower($dt->format('F'));
}

function nf($number)
{
    return is_numeric($number) ? number_format($number) : null;
}

function base_point_exists($type)
{
    return (bool) App\BasePoint::where('type', $type)->first();
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
