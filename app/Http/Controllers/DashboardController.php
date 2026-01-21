<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Criterion;
use App\Models\Alternative;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'criteria' => Criterion::count(),
            'alternatives' => Alternative::count(),
            'ratings' => Rating::count(),
        ];

        if (Gate::allows('manage-criteria')) {
            // Admin dashboard
            return view('dashboard.admin', compact('stats'));
        } else {
            // Juri dashboard
            $userRatings = Rating::where('user_id', auth()->id())->count();
            return view('dashboard.juri', compact('stats', 'userRatings'));
        }
    }
}
