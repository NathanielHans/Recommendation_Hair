<?php

namespace App\Http\Controllers;

use App\Models\feedback_system;
use App\Http\Requests\Storefeedback_systemRequest;
use App\Http\Requests\Updatefeedback_systemRequest;

class FeedbackSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalRekomendasi = feedback_system::count();

        $averagePrecision = feedback_system::avg('precision');
        $averagePrecision = $averagePrecision ? round($averagePrecision, 2) : 0;
        return view('home', compact('totalRekomendasi', 'averagePrecision'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storefeedback_systemRequest $request)
    {
            $validated = $request->validate([
            'precision' => 'required|numeric|min:0|max:1',
        ]);

        feedback_system::create([
            'precision' => $validated['precision'],
        ]);

        return redirect('/recommendation')->with('success', 'Precision berhasil disimpan dengan nilai: ' . $validated['precision']);
    }

    /**
     * Display the specified resource.
     */
    public function show(feedback_system $feedback_system)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(feedback_system $feedback_system)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatefeedback_systemRequest $request, feedback_system $feedback_system)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(feedback_system $feedback_system)
    {
        //
    }
}
