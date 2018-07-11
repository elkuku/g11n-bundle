<?php

namespace ElKuKu\G11nBundle\Twig;

use ElKuKu\G11n\G11n;
use ElKuKu\G11n\Support\ExtensionHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class G11nExtension extends AbstractExtension
{
    private $rootDir;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('_', 'g11n3t'),
            new TwigFunction('g11n4t', 'g11n4t'),
            new TwigFunction('getLangDebug', [$this, 'getLangDebug']),
            new TwigFunction('getLangs', [$this, 'getLangs']),
            new TwigFunction('getCurrentLang', [$this, 'getCurrentLang']),
            new TwigFunction('replaceRootPath', [$this, 'replaceRootPath']),
        ];
    }

    public function getLangDebug(): bool
    {
        return getenv('LANG_DEBUG') ? true : false;
    }

    public function getLangs(string $extension = 'default'): array
    {
        return array_merge([G11n::getDefault()], ExtensionHelper::getLanguages($extension));
    }

    public function getCurrentLang(): string
    {
        return G11n::getCurrent();
    }

    public function replaceRootPath(string $path): string
    {
        return str_replace($this->rootDir, '...', $path);
    }
}
