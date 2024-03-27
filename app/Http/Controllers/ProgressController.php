<?php

namespace App\Http\Controllers;

use App\Models\progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {

            $userId = Auth::id();


            $progress = Progress::where('user_id', $userId)->get();


            return response()->json(['progress' => $progress], 200);
        } else {
            return response()->json(['error' => auth()->user()], 401);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'weight' => 'required',
            'height' => 'required',
            'chest' => 'required',
            'waist' => 'required',
            'hips' => 'required',
            'performance' => 'required'
        ]);

        $progress = progress::create([
            'user_id' => auth()->user()->id,
            'weight' => $request->weight,
            'height' => $request->height,
            'chest' => $request->chest,
            'waist' => $request->waist,
            'hips' => $request->hips,
            'performance' => $request->performance,
            'status' => 'Non terminé'
        ]);

        return response()->json(['message' => 'Physical progress created successfully', 'progress' => $progress], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(progress $progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */








    public function update(Request $request, string $id)
    {




        $validatedData = $request->validate([
            'weight' => 'required',
            'height' => 'required',
            'chest' => 'required',
            'waist' => 'required',
            'hips' => 'required',
            'performance' => 'required'

        ]);
        $progression = progress::find($id);

        $progression->update($validatedData);

        return response()->json([
            'message' => 'Progression updated successfully',
            'data' => $progression->toArray()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $progression = progress::find($id);
        $progression->delete();

        return response()->json(['msg' => 'Progression deleted successfully']);
    }
}
