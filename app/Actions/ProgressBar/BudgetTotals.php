<?php

namespace App\Actions\ProgressBar;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class BudgetTotals
{
    public function __construct($budget)
    {

        foreach($budget as $index => &$category) {
            $percent = $category['planned'] > 0 ? round(($category['actual'] / $category['planned']) * 100) : 0;

            $data = [
                'percent' => $percent,
                'planned' => $category['planned'],
                'actual' => $category['actual'],
                'color' => $this->get_bar_color($percent),
                'category' => $category['category']
            ];
            $this->rda[] = $data;
        }
    }

    protected function get_bar_color($percent_value)
    {
        if ($percent_value < 75) {
            return 'success';
        }
        else if ($percent_value >= 100 && $percent_value <= 101) {
            return 'primary';
        }
        else if ($percent_value >= 75 && $percent_value < 100) {
            return 'warning';
        }
        else {
            return 'danger';
        }
    }
}
