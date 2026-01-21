<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Criterion;
use App\Models\Rating;
use Illuminate\Support\Collection;

class SmartCalculationService
{
    /**
     * Calculate normalized values U(Xij) for all alternatives and criteria.
     *
     * Formula:
     * - For Benefit: U(Xij) = Xij / Xmax
     * - For Cost: U(Xij) = Xmin / Xij
     *
     * @param Collection $alternatives
     * @param Collection $criteria
     * @return array Normalized values [alternative_id][criterion_id] => normalized_value
     */
    public function normalize(Collection $alternatives, Collection $criteria): array
    {
        $normalized = [];
        
        foreach ($criteria as $criterion) {
            $ratings = Rating::where('criterion_id', $criterion->id)->get();
            
            // Calculate average ratings for Juri 2 and Juri 3
            $averagedRatings = $this->calculateAveragedRatings($ratings, $alternatives);
            
            // Get min and max values for this criterion
            $values = array_values($averagedRatings);
            $max = max($values);
            $min = min($values);
            
            foreach ($alternatives as $alternative) {
                $value = $averagedRatings[$alternative->id] ?? 0;
                
                if ($criterion->type === 'benefit') {
                    // Benefit: U(Xij) = Xij / Xmax
                    $normalized[$alternative->id][$criterion->id] = $max > 0 ? $value / $max : 0;
                } else {
                    // Cost: U(Xij) = Xmin / Xij
                    $normalized[$alternative->id][$criterion->id] = $value > 0 ? $min / $value : 0;
                }
            }
        }
        
        return $normalized;
    }

    /**
     * Calculate final values Vj for each alternative.
     *
     * Formula: Vj = Σ(Wi * U(Xij))
     *
     * @param Collection $alternatives
     * @param Collection $criteria
     * @param array $normalized Normalized values from normalize() method
     * @return array Final values [alternative_id] => final_value
     */
    public function calculateFinalValues(Collection $alternatives, Collection $criteria, array $normalized): array
    {
        $finalValues = [];
        
        foreach ($alternatives as $alternative) {
            $vj = 0;
            
            foreach ($criteria as $criterion) {
                $uij = $normalized[$alternative->id][$criterion->id] ?? 0;
                $wi = $criterion->weight;
                
                $vj += $wi * $uij;
            }
            
            $finalValues[$alternative->id] = $vj;
        }
        
        return $finalValues;
    }

    /**
     * Rank alternatives based on final values.
     *
     * @param Collection $alternatives
     * @param array $finalValues Final values from calculateFinalValues() method
     * @return Collection Ranked alternatives with rank and final_value
     */
    public function rank(Collection $alternatives, array $finalValues): Collection
    {
        $ranked = $alternatives->map(function ($alternative) use ($finalValues) {
            return [
                'alternative' => $alternative,
                'final_value' => $finalValues[$alternative->id] ?? 0,
            ];
        })->sortByDesc('final_value')->values();
        
        // Add rank number
        return $ranked->map(function ($item, $index) {
            $item['rank'] = $index + 1;
            return $item;
        });
    }

    /**
     * Calculate complete SMART analysis (normalize, calculate final values, and rank).
     *
     * @param Collection $alternatives
     * @param Collection $criteria
     * @return array Contains normalized, finalValues, and ranked results
     */
    public function calculate(Collection $alternatives, Collection $criteria): array
    {
        $normalized = $this->normalize($alternatives, $criteria);
        $finalValues = $this->calculateFinalValues($alternatives, $criteria, $normalized);
        $ranked = $this->rank($alternatives, $finalValues);
        
        return [
            'normalized' => $normalized,
            'finalValues' => $finalValues,
            'ranked' => $ranked,
        ];
    }

    /**
     * Calculate averaged ratings from Juri 2 and Juri 3.
     * If only one juri has rated, use that value.
     * If both have rated, average them.
     *
     * @param Collection $ratings
     * @param Collection $alternatives
     * @return array Averaged ratings [alternative_id] => averaged_value
     */
    protected function calculateAveragedRatings(Collection $ratings, Collection $alternatives): array
    {
        $averaged = [];
        
        // Get all juri user IDs
        $juriIds = \App\Models\User::where('role', 'juri')->pluck('id');
        
        foreach ($alternatives as $alternative) {
            // Get ratings for this alternative from all juri
            $alternativeRatings = $ratings->where('alternative_id', $alternative->id)
                ->whereIn('user_id', $juriIds)
                ->pluck('value');
            
            if ($alternativeRatings->count() > 0) {
                // Average all juri ratings
                $averaged[$alternative->id] = $alternativeRatings->avg();
            } else {
                $averaged[$alternative->id] = 0;
            }
        }
        
        return $averaged;
    }

    /**
     * Get averaged ratings for a specific criterion and alternative.
     * This method handles the requirement to average Juri 2 and Juri 3 ratings.
     *
     * @param int $criterionId
     * @param int $alternativeId
     * @return float Averaged rating value
     */
    public function getAveragedRating(int $criterionId, int $alternativeId): float
    {
        $ratings = Rating::where('criterion_id', $criterionId)
            ->where('alternative_id', $alternativeId)
            ->whereHas('user', function ($query) {
                $query->where('role', 'juri');
            })
            ->pluck('value');
        
        return $ratings->count() > 0 ? $ratings->avg() : 0;
    }
}

