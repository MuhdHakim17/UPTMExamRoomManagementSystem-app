<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // use DB for direct queries
use Illuminate\Http\Request;

class ReceivingReportController extends Controller
{
    /**
     * Display all received reports from database (without model)
     */
    public function index()
    {
        // Fetch all rows from the reports table
        $reports = DB::table('reports')->get();

        // Pass data to Blade view
        return view('Receiving-Report', ['reports' => $reports]);
    }
    public function accept($id)
{
    DB::table('reports')->where('id', $id)->update(['status' => 'accepted']);
    return redirect()->back()->with('success', 'Report accepted successfully.');
}

public function remove($id)
{
    DB::table('reports')->where('id', $id)->delete();
    return redirect()->back()->with('success', 'Report removed successfully.');
}

}
