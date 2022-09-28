<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    
    public function index(){
        $units = Unit::all();
        return response()->json(['units' => $units], 200);
    }

}
