<?php

namespace App\Actions\ProgressBar;

use App\Budget;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class BudgetTotals
{
    public function __construct()
    {
        $budget = null;
        $this->year = date('Y');
        $this->month = date('F');
        if (Auth::check()) {
            $user = Auth::user();

            try {
                $budget = Budget::where([
                    ['year', '=', $this->year],
                    ['period', '=', $this->month],
                    ['user_id', '=', $user->id]
                ])->get();

            } catch (Exception $e) {
                report($e);
                Log::info('Could not find data with the supplied parameters.');
            }
            $this->rda = [];
            if ($budget != null ) {
                foreach($budget as $category) {
                    $percent = $category->planned > 0 ? round(($category->actual / $category->planned) * 100) : 0;

                    $data = [
                        'percent' => $percent,
                        'planned' => $category->planned,
                        'actual' => $category->actual,
                        'color' => $this->get_bar_color($percent),
                        'category' => $category->category
                    ];
                    $this->rda[] = $data;
                }

            }
            else {
                Log::info(time() . ': Budget table query did not return any results. Check your params.');
            }

        }
        else {
            // If User is Not Authenticated, Quit and Return Null Budget
            Log::info('Could Not Authenticate. Please sign in.');
        }
    }

    protected function get_bar_color($percent_value)
    {
        if ($percent_value < 75) {
            return 'primary';
        }
        else if ($percent_value >= 100 && $percent_value <= 101) {
            return 'success';
        }
        else if ($percent_value >= 75 && $percent_value < 100) {
            return 'warning';
        }
        else {
            return 'danger';
        }
    }
}
