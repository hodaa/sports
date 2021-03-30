<?php


namespace App\Services;

class MatchService
{

    /**
     * @param $query
     * @param $week
     * @return mixed
     */
    public function filterByWeek($query, $week)
    {
        return $query->join('weeks', 'weeks.id', '=', 'matches.week_id')
            ->where('weeks.week', $week);
    }

    /**
     * @param $query
     * @param $year
     * @return mixed
     */
    public function filterByYear($query, $year, $week = null)
    {
        if (!$week) {
            $query->join('weeks', 'weeks.id', '=', 'matches.week_id');
        }
        $query->join('seasons', 'seasons.id', '=', 'weeks.season_id')
            ->where('seasons.year', $year);

        return $query;
    }

    /**
     * @param $image
     * @return string
     */
    public function uploadImage($image): string
    {
        $name = time().".".$image->getClientOriginalExtension();
        $path= '/images/matches';
        $image->move(public_path($path), $name, 0777, true);
        return  $path."/".$name;
    }
}
