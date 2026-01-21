<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlternativeRequest;
use App\Http\Requests\UpdateAlternativeRequest;
use App\Models\Alternative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatives = Alternative::paginate(10);
        return view('alternatives.index', compact('alternatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('input-rating') && !Gate::allows('manage-criteria')) {
            abort(403);
        }
        return view('alternatives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAlternativeRequest $request)
    {
        Alternative::create($request->validated());

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternatif berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alternative $alternative)
    {
        $alternative->load('ratings.criterion', 'ratings.user');
        return view('alternatives.show', compact('alternative'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternative $alternative)
    {
        if (!Gate::allows('input-rating') && !Gate::allows('manage-criteria')) {
            abort(403);
        }
        return view('alternatives.edit', compact('alternative'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlternativeRequest $request, Alternative $alternative)
    {
        $alternative->update($request->validated());

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternatif berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternative $alternative)
    {
        if (!Gate::allows('manage-criteria')) {
            abort(403);
        }
        
        $alternative->delete();

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternatif berhasil dihapus.');
    }
}
