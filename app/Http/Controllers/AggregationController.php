<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criterion;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AggregationController extends Controller
{
    // Admin view: all normalized, average, and aggregation values
    public function admin()
    {
        if (!Gate::allows('view-results')) abort(403);
        $alternatives = Alternative::all();
        $criteria = Criterion::all();
        // Ambil normalisasi dari hasil SMART (bisa gunakan service jika ada)
        $normalized = [];
        foreach ($alternatives as $alt) {
            foreach ($criteria as $crit) {
                // Ambil rating normalisasi (misal: rata-rata juri, atau rating juri 1, atau sesuai kebutuhan)
                $rating = Rating::where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->avg('value');
                $normalized[$alt->id][$crit->id] = $rating ?? 0;
            }
        }
        return view('results.aggregation_admin', [
            'alternatives' => $alternatives,
            'criteria' => $criteria,
            'normalized' => $normalized
        ]);
    }

    // Juri 1 view
    public function juri1()
    {
        if (!Gate::allows('view-results')) abort(403);
        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();
        $juri = User::where('role', 'juri')->orderBy('id')->get();
        $ratings = Rating::all();
        $data = [];
        foreach ($alternatives as $alt) {
            foreach ($criteria as $crit) {
                $row = [
                    'alternative' => $alt->name,
                    'category' => $crit->category->name,
                    'criterion' => $crit->name,
                ];
                $row['normalized_juri1'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[0]->id ?? null)->first()->value ?? null;
                $row['normalized_juri2'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[1]->id ?? null)->first()->value ?? null;
                $row['normalized_juri3'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[2]->id ?? null)->first()->value ?? null;
                if(isset($row['normalized_juri2'],$row['normalized_juri3'])) {
                    $row['average_juri23'] = ($row['normalized_juri2'] + $row['normalized_juri3'])/2;
                } else {
                    $row['average_juri23'] = null;
                }
                if(isset($row['normalized_juri1'],$row['average_juri23'])) {
                    $row['aggregation'] = ($row['normalized_juri1'] + $row['average_juri23'])/2;
                } else {
                    $row['aggregation'] = null;
                }
                $data[] = (object)$row;
            }
        }
        return view('results.aggregation_juri1', ['aggregations' => $data]);
    }

    // Juri 2 view
    public function juri2()
    {
        if (!Gate::allows('view-results')) abort(403);
        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();
        $juri = User::where('role', 'juri')->orderBy('id')->get();
        $ratings = Rating::all();
        $data = [];
        foreach ($alternatives as $alt) {
            foreach ($criteria as $crit) {
                $row = [
                    'alternative' => $alt->name,
                    'category' => $crit->category->name,
                    'criterion' => $crit->name,
                ];
                $row['normalized_juri2'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[1]->id ?? null)->first()->value ?? null;
                $row['normalized_juri3'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[2]->id ?? null)->first()->value ?? null;
                if(isset($row['normalized_juri2'],$row['normalized_juri3'])) {
                    $row['average_juri23'] = ($row['normalized_juri2'] + $row['normalized_juri3'])/2;
                } else {
                    $row['average_juri23'] = null;
                }
                $data[] = (object)$row;
            }
        }
        return view('results.aggregation_juri2', ['aggregations' => $data]);
    }

    // Juri 3 view
    public function juri3()
    {
        if (!Gate::allows('view-results')) abort(403);
        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();
        $juri = User::where('role', 'juri')->orderBy('id')->get();
        $ratings = Rating::all();
        $data = [];
        foreach ($alternatives as $alt) {
            foreach ($criteria as $crit) {
                $row = [
                    'alternative' => $alt->name,
                    'category' => $crit->category->name,
                    'criterion' => $crit->name,
                ];
                $row['normalized_juri3'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[2]->id ?? null)->first()->value ?? null;
                $row['normalized_juri2'] = $ratings->where('alternative_id', $alt->id)->where('criterion_id', $crit->id)->where('user_id', $juri[1]->id ?? null)->first()->value ?? null;
                if(isset($row['normalized_juri2'],$row['normalized_juri3'])) {
                    $row['average_juri23'] = ($row['normalized_juri2'] + $row['normalized_juri3'])/2;
                } else {
                    $row['average_juri23'] = null;
                }
                $data[] = (object)$row;
            }
        }
        return view('results.aggregation_juri3', ['aggregations' => $data]);
    }
}
