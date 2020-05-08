<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PseudoToColourExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('colour', [$this, 'doSomething']),
        ];
    }

    public function doSomething($str)
    {
        $value = bin2hex($str);
        $colour = substr($value, 0, 3);

        return $colour;
    }

}
