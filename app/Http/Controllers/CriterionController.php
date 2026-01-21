<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCriterionRequest;
use App\Http\Requests\UpdateCriterionRequest;
use App\Models\Criterion;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CriterionController extends Controller
{
    public function __construct()
    {
        // Authorization is handled in FormRequests and individual methods
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('manage-criteria');
        $criteria = Criterion::with('category')->paginate(10);
        return view('criteria.index', compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('manage-criteria');
        $categories = Category::all();
        return view('criteria.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCriterionRequest $request)
    {
        Criterion::create($request->validated());

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Criterion $criterion)
    {
        Gate::authorize('manage-criteria');
        $criterion->load('category', 'ratings');
        return view('criteria.show', compact('criterion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criterion $criterion)
    {
        Gate::authorize('manage-criteria');
        $categories = Category::all();
        return view('criteria.edit', compact('criterion', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCriterionRequest $request, Criterion $criterion)
    {
        $criterion->update($request->validated());

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criterion $criterion)
    {
        Gate::authorize('manage-criteria');
        $criterion->delete();

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }
}
