<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $guarded = ['id'];

    public function star()
    {
        return $this->belongsTo(Star::class);
    }

    public static function top10($year,$month)
    {
        $query = "stars.*, SUM(points.amount) as sum";
        $collection =  Star::select(\DB::raw($query))
            ->where('year', $year)
            ->where('month', '<=', $month)
            ->leftJoin('points', 'points.star_id', '=', 'stars.id')
            ->orderBy('sum', 'DESC')
            ->groupBy('stars.id')
            ->limit(10)
            ->get();
        return $collection;
    }

    public static function topN($n, $year=null)
    {
        $year = $year ?? cy();
        $query = "stars.*, SUM(points.amount) as sum";
        $collection =  Star::select(\DB::raw($query))
            ->where('year', $year)
            ->leftJoin('points', 'points.star_id', '=', 'stars.id')
            ->orderBy('sum', 'DESC')
            ->groupBy('stars.id')
            ->limit($n)
            ->get();
        return $collection;
    }

    // order is month name or sum
    public static function tops($year=null, $order='sum', $limit=null)
    {
        $year = $year ?? cy();

        $query = "stars.*, SUM(points.amount) as sum";
        for ($i=1; $i <=12 ; $i++) {
            $query .= ", (SELECT SUM(IF(points.month=$i, points.amount, 0))) AS ". mn($i);
        }

        $collection =  Star::select(\DB::raw($query))
            ->where('year', $year)
            ->leftJoin('points', 'points.star_id', '=', 'stars.id')
            ->orderBy($order, 'DESC')
            ->groupBy('stars.id');

        if ($limit) {
            $collection = $collection->limit($limit);
        }
        $collection = $collection->get();

        return $collection;
    }
}
