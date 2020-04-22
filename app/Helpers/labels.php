<?php

function get_labels($budget, $chart=false)
{
    $categories = [];

    foreach($budget as $index => $category) {
        if ($chart && $category->actual > 0)
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
