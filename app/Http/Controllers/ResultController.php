<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criterion;
use App\Services\SmartCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ResultController extends Controller
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    public function index()
    {
        if (!Gate::allows('view-results')) {
            abort(403);
        }

        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();

        if ($alternatives->isEmpty() || $criteria->isEmpty()) {
            return view('results.index', [
                'message' => 'Belum ada data alternatif atau kriteria. Silakan lengkapi data terlebih dahulu.',
            ]);
        }

        $results = $this->smartService->calculate($alternatives, $criteria);

        return view('results.index', [
            'alternatives' => $alternatives,
            'criteria' => $criteria,
            'normalized' => $results['normalized'],
            'finalValues' => $results['finalValues'],
            'ranked' => $results['ranked'],
        ]);
    }

    public function show($id)
    {
        if (!Gate::allows('view-results')) {
            abort(403);
        }

        $alternative = Alternative::findOrFail($id);
        $criteria = Criterion::with('category')->get();
        $allAlternatives = Alternative::all();

        $results = $this->smartService->calculate($allAlternatives, $criteria);
        
        $alternativeResult = $results['ranked']->firstWhere('alternative.id', $id);

        // Prepare normalized values for this alternative
        $normalizedForAlternative = [];
        foreach ($criteria as $criterion) {
            $normalizedForAlternative[$criterion->id] = $results['normalized'][$id][$criterion->id] ?? 0;
        }

        return view('results.show', [
            'alternative' => $alternative,
            'criteria' => $criteria,
            'normalized' => $normalizedForAlternative,
            'finalValue' => $results['finalValues'][$id] ?? 0,
            'rank' => $alternativeResult['rank'] ?? null,
        ]);
    }
}
