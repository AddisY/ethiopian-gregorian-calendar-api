<?php
/**
 * Created by PhpStorm.
 * User: newjo
 * Date: 5/3/2017
 * Time: 2:42 PM
 */

namespace App;

class CalenderFinal
{
    const JDOFFSET = 1723856;

    public function toEthiopianDate(\DateTime $dateTime){
        $jdn = $this->toJDN($dateTime);
        return $this->convertToEthiopianDate($jdn);
    }

    public function toJDN(\DateTime $dateTime){
            $a = (int)((14 - (int)$dateTime->format('m'))/12);
            $y = (int) $dateTime->format('Y') + 4800 - $a;
            $m = (int) $dateTime->format('m') + 12 * $a - 3;

            return (int) $dateTime->format('j') + (int)((153 * $m + 2)/5)+ 365 * $y + (int) ($y/4) - (int)($y / 100) + (int) ($y /400) - 32045;
    }

    public function convertToEthiopianDate($jdn){
            $r = ($jdn - self::JDOFFSET) % 1461;
            $n = $r%365 + 365 *(int)(($r/1460));

            $year = 4 *(int)(($jdn - self::JDOFFSET) / 1461) + (int)($r / 365) - (int)($r / 1460);
            $month = (int)($n/30) + 1;
            $day = $n%30 + 1;

            $ethiopianDate = ['year' => $year,'month' => $month, 'day' => $day];
        return $ethiopianDate;
    }

    public function validateED($year, $month, $day){
        if ($month < 1 || $month > 13 || ($month == 13 && $year % 4 == 3 && $day > 6) || ($month == 13 && $year % 4 != 3 && $day > 5)
            || $day < 1 || $day > 30)
        {
            return false;
        }
        return true;
    }

    public function validateGD($year, $month, $day){
        if( $month < 1 || $month > 12 || ($month == 1 && $day > 31) || ($month == 2 && $year % 4 != 3 && $day > 28) || ($month == 2 && $year % 4 == 3 && $day > 29) || ($month == 3 && $day > 31) || ($month == 4 && $day > 30) || ($month == 5 && $day > 31) || ($month == 6 && $day > 30) || ($month == 7 && $day > 31) || ($month == 8 && $day > 31) || ($month == 9 && $day > 30) || ($month == 10 && $day > 31) || ($month == 11 && $day > 30) || ($month == 12 && $day > 31) ){
            return false;
        }
        return true;
    }

    public function toGregorianDate($year, $month, $day){
        if($this->validateED($year, $month, $day)){
            $jdn = $this->fromEthiopianToJDN($year, $month, $day);
            return $this->convertToGregorian($jdn);
        }
    }

    public function convertToGregorian($jdn){

        $r = $jdn + 68569;
        $n = (int)(4*($r/146097));
        $r = $r - (int)((146097*$n + 3)/4);
        $year =(int) (4000 * ($r + 1)/1461001);
        $r = $r - (int)(1461*$year/4) + 31;
        $month = (int) (80*($r/2447));
        $day = $r -(int) (2447*($month/80));
        $r = (int)($month/11);
        $month = $month + 2 - 12*$r;
        $year = 100*($n - 49) + $year + $r;

        $gregorianDate = ['year' => $year,'month' => $month, 'day' => $day];
        return $gregorianDate;
    }

    public function fromEthiopianToJDN($year, $month, $day){
        return (self::JDOFFSET + 365) + 365 * ($year - 1) +(int) ($year / 4) + 30 * $month +
        $day - 31;
    }


}