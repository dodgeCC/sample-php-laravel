<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Job;

class Utils
{
    public static function getJobTypeFilter()
    {
        return [
            '' => 'Select Type',
            Job::TYPE_FULL_TIME => 'Permanent',
            Job::TYPE_INTERNSHIP => 'Internship',
            Job::TYPE_PART_TIME => 'Part-time',
            Job::TYPE_CONTRACT => 'Contract'
        ];
    }

    public static function getJobContractIntervalFilter()
    {
        return [
            '' => 'Select Interval',
            Job::INTERVAL_DAY => 'Days',
            Job::INTERVAL_MONTH => 'Months',
            Job::INTERVAL_YEAR => 'Years'
        ];
    }

    public static function getPointFromAddress($address)
    {
        $point = null;
        $addresses = app('geocoder')->geocode($address)->get();
        if($addresses->isNotEmpty() && $coordinates = $addresses[0]->getCoordinates()){
            $point = DB::raw("(GeomFromText('POINT(".$coordinates->getLongitude()." ".$coordinates->getLatitude().")'))");
        }
        return $point;
    }

    public static function getPointFromCoordinates($coordinates)
    {
        return DB::raw("(PointFromText('POINT(".$coordinates[1]." ".$coordinates[0].")'))");
    }

    public static function getCoordinatesFromAddress($address)
    {
        $latitude = null;
        $longitude = null;
        $addresses = app('geocoder')->geocode($address)->get();
        if($addresses->isNotEmpty() && $coordinates = $addresses[0]->getCoordinates()){
            $latitude = $coordinates->getLatitude();
            $longitude = $coordinates->getLongitude();
        }
        return ($latitude && $longitude) ? [$latitude, $longitude] : null;
    }
}
