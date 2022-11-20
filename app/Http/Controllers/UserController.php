<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
			return view('home');
		}

		public function profile(User $user) {
			return view('profile')->with('user', $user);
		}

		public function leaderboard() {
			return view('leaderboard')->with('users', User::all());
		}
}
