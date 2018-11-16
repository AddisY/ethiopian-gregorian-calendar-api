<?php

namespace App\Http\Controllers;

//use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use App;

class ConvertController extends Controller
{
    public function convert_EC(Request $request){
        $day = (int) $request->day;
        $month = (int) $request->month;
        $year = (int) $request->year;
        $calender = new App\CalenderFinal();

        if($calender->validateGD($year, $month, $day)){
            $date = $year . "-" . $month . "-" . $day ;
            $dateTime = new \DateTime($date);
            $toEC = $calender->toEthiopianDate($dateTime);
            return $toEC;
        }
        return "validation failed";


    }
    public function convert_GC(Request $request){
        $day = (int) $request->day;
        $month = (int) $request->month;
        $year = (int) $request->year;
        $calender = new App\CalenderFinal();

        $toGC = $calender->toGregorianDate($year, $month, $day);

        return $toGC;
    }
}
