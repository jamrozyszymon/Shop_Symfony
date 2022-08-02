<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SluggExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('slugg', [$this, 'slugg']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSlugg($string)
    {
        $string = preg_replace("/ +/", "-", trim($string));
        $string = mb_strtolower(preg_replace('/[^A-Za-z0-9-]+/', '', $string), 'UTF-8');
        return $string;
    }
}
