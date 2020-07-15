<?php

/**
 * Returns array of only budget category names.
 * If $chart is true, returns only category names of
 * budget items with an actual value greater than zero.
 */
function get_labels($budget, $chart=false)
{
    $categories = [];

    foreach($budget as $index => $category) {
        if ($chart)
        {
            if ($category->actual > 0)
            {
                $categories[] = $category->category;
            }
        }
        else
        {
            $categories[] = $category->category;
        }
    }
    return $categories;
}
