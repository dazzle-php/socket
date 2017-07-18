<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$options = [
    'mode' => 'client',
];

foreach ($argv as $argIndex=>$argVal)
{
    if ($argIndex && preg_match('#^--([^=]+)=(.+)$#si', $argVal, $matches) && $matches)
    {
        $options[$matches[1]] = $matches[2];
    }
}

foreach ($options as $optionKey=>$optionVal)
{
    $$optionKey = strtolower($optionVal);
}
