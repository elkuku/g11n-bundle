<?php

namespace ElKuKu\G11nBundle\Twig;

use ElKuKu\G11n\G11n;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class G11nExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('_', 'g11n3t'),
            new TwigFunction('g11n4t', 'g11n4t'),
            new TwigFunction('getLangDebug', [$this, 'getLangDebug']),
            new TwigFunction('getLangs', [$this, 'getLangs']),
            new TwigFunction('getCurrentLang', [$this, 'getCurrentLang']),
        ];
    }

    public function getLangDebug()
    {
        return getenv('LANG_DEBUG');
    }

    public function getLangs(): array
    {
        return ['en-GB', 'de-DE'];
    }

    public function getCurrentLang()
    {
        return G11n::getCurrent();
    }
}
