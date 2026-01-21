<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criterion;
use App\Services\SmartCalculationService;
use Illuminate\Http\Request;

class PublicResultController extends Controller
{
    protected $smartService;

    public function __construct(SmartCalculationService $smartService)
    {
        $this->smartService = $smartService;
    }

    /**
     * Display public results page (no authentication required)
     */
    public function index()
    {
        $alternatives = Alternative::all();
        $criteria = Criterion::with('category')->get();

        if ($alternatives->isEmpty() || $criteria->isEmpty()) {
            return view('public.results', [
                'message' => 'Hasil kontes belum tersedia. Data masih dalam proses pengumpulan.',
                'alternatives' => collect(),
                'criteria' => collect(),
                'ranked' => collect(),
                'normalized' => [],
                'finalValues' => [],
                'contributionData' => [],
                'juriRatings' => [],
            ]);
        }

        $results = $this->smartService->calculate($alternatives, $criteria);

        // Prepare data for charts - contribution of each criterion to final score
        $contributionData = $this->prepareContributionData($alternatives, $criteria, $results);

        // Prepare juri ratings data
        $juriRatings = $this->prepareJuriRatings($alternatives, $criteria);

        return view('public.results', [
            'alternatives' => $alternatives,
            'criteria' => $criteria,
            'normalized' => $results['normalized'],
            'finalValues' => $results['finalValues'],
            'ranked' => $results['ranked'],
            'contributionData' => $contributionData,
            'juriRatings' => $juriRatings,
        ]);
    }

    /**
     * Prepare data for chart visualization
     * Returns contribution of each criterion (Wi * U(Xij)) for each alternative
     */
    protected function prepareContributionData($alternatives, $criteria, $results)
    {
        $data = [];

        foreach ($alternatives as $alternative) {
            $alternativeData = [
                'name' => $alternative->name,
                'code' => $alternative->code,
                'criteria' => [],
            ];

            foreach ($criteria as $criterion) {
                $uij = $results['normalized'][$alternative->id][$criterion->id] ?? 0;
                $contribution = $criterion->weight * $uij;

                $alternativeData['criteria'][] = [
                    'name' => $criterion->name,
                    'category' => $criterion->category->name,
                    'weight' => $criterion->weight,
                    'normalized' => $uij,
                    'contribution' => $contribution,
                ];
            }

            $data[] = $alternativeData;
        }

        return $data;
    }

    /**
     * Prepare juri ratings data for display
     * Shows ratings from Juri 1, and average from Juri 2 & 3
     */
    protected function prepareJuriRatings($alternatives, $criteria)
    {
        $data = [];
        
        // Get all juri users
        $juriUsers = \App\Models\User::where('role', 'juri')->orderBy('id')->get();
        $juri1 = $juriUsers->first();
        $juri2And3 = $juriUsers->skip(1)->take(2);

        foreach ($alternatives as $alternative) {
            $alternativeData = [
                'name' => $alternative->name,
                'code' => $alternative->code,
                'criteria' => [],
            ];

            foreach ($criteria as $criterion) {
                $criterionData = [
                    'name' => $criterion->name,
                    'juri1_rating' => null,
                    'juri2_3_avg' => null,
                ];

                // Get Juri 1 rating
                if ($juri1) {
                    $juri1Rating = \App\Models\Rating::where('criterion_id', $criterion->id)
                        ->where('alternative_id', $alternative->id)
                        ->where('user_id', $juri1->id)
                        ->first();
                    $criterionData['juri1_rating'] = $juri1Rating ? $juri1Rating->value : null;
                }

                // Get average of Juri 2 & 3 ratings
                $juri2_3Ratings = \App\Models\Rating::where('criterion_id', $criterion->id)
                    ->where('alternative_id', $alternative->id)
                    ->whereIn('user_id', $juri2And3->pluck('id'))
                    ->pluck('value');
                
                if ($juri2_3Ratings->count() > 0) {
                    $criterionData['juri2_3_avg'] = $juri2_3Ratings->avg();
                }

                $alternativeData['criteria'][] = $criterionData;
            }

            $data[] = $alternativeData;
        }

        return $data;
    }
}

