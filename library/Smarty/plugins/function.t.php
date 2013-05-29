<?php

function smarty_function_t($params, &$smarty)
{
    $text = trim($params['text']);
    return t($text);
}
