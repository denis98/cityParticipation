<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index() {
			return view('areas');
		}

		public function show(Area $area) {
			return view('area')->with('area', $area);
		}
}
