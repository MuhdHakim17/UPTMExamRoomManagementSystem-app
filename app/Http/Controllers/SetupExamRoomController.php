<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupExamRoomController extends Controller
{
    public function index()
    {
        $rooms = DB::table('exam_rooms')->get();
        return view('Setup-Exam-Room', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'floor' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        DB::table('exam_rooms')->insert([
            'floor' => $request->floor,
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('examroom.index')->with('success', 'Room added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'floor' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        DB::table('exam_rooms')
            ->where('id', $id)
            ->update([
                'floor' => $request->floor,
                'room_number' => $request->room_number,
                'capacity' => $request->capacity,
            ]);

        return redirect()->route('examroom.index')->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        DB::table('exam_rooms')->where('id', $id)->delete();
        return redirect()->route('examroom.index')->with('success', 'Room deleted successfully!');
    }
}
