<?php
/**
 * Utility function to quickly dump data to the page
 * @param null $mixed
 */
function ddump($mixed = null)
{
    echo '<pre>';
    var_dump($mixed);
    echo '</pre>';
}
