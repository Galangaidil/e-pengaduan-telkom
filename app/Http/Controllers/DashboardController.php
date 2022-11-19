<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Complaint::whereMonth('created_at', Carbon::now()->month)->count();

        return Inertia::render('Dashboard', [
            'countTotalComplaint' => $data
        ]);
    }
}
