<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('slug', [$this, 'slug']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function doSlug($string)
    {
        $string = preg_replace("/ +/", "-", trim($string));
        $string = mb_strtolower(preg_replace('/[^A-Za-z0-9-]+/', '', $string), 'UTF-8');
        return $string;
    }
}
