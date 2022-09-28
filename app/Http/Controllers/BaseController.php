<?php

namespace App\Http\Controllers;

use Krishnahimself\DateConverter\DateConverter;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BaseController extends Controller
{
  public function getUserId(){
    return Auth::id();
  }

  public function getParsedDatetime($data){
    $parseDate= Carbon::parse($data);
    $year= $parseDate->format('Y');
    $month= $parseDate->format('m');
    $day= $parseDate->format('d');

    $u='<a class="badge bg-warning text-white text-wrap p-1 border" style="pointer-events: none; cursor: default;">' .$parseDate->diffForHumans(). '</a>';
    // return $parseDate->toDayDateTimeString(). " " .$u ;
    $nepaliDate = DateConverter::fromEnglishDate($year, $month, $day)->toFormattedNepaliDate();

    return $nepaliDate . " ". $u;
  
  }
}