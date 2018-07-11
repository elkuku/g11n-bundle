<?php

namespace ElKuKu\G11nBundle\Command;

use ElKuKu\G11nBundle\Twig\G11nExtension;
use ElKuKu\G11nUtil\G11nUtil;
use ElKuKu\G11nUtil\Type\LanguageTemplateType;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class MakeTemplatesCommand
 */
class MakeTemplatesCommand extends Command
{
    protected static $defaultName = 'g11n:templates';

    private $rootDir;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Create and update language template files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $cacheDir  = $this->rootDir.'/var/cache/twig';
        $extension = 'src';

        // Cleanup
        (new Filesystem(new Local($this->rootDir.'/var/cache')))
            ->deleteDir('twig');

        $g11nUtil = new G11nUtil($output->getVerbosity());

        $template = new LanguageTemplateType();

        $g11nUtil->makePhpFromTwig(
            $this->rootDir.'/templates',
            $this->rootDir.'/templates',
            $cacheDir.'/'.$extension,
            [new G11nExtension($this->rootDir)],
            true
        );

        $paths = [$this->rootDir, $cacheDir];

        $template
            ->setPackageName('G11nTest')
            ->setTemplatePath($this->rootDir.'/translations/template.pot')
            ->setPaths($paths)
            ->setExtensionDir($extension);

        $g11nUtil->processTemplates($template);

        $this->replaceTemplate($template->templatePath, $this->rootDir);

        $g11nUtil->replaceTwigPaths(
            $this->rootDir.'/templates',
            $cacheDir.'/'.$extension,
            $template->templatePath,
            $this->rootDir
        );

        $io->success('Templates created.');
    }

    private function replaceTemplate(string $path, string $projectDir)
    {
        // Manually strip the root path - ...
        $contents = file_get_contents($path);
        $contents = str_replace($projectDir, '', $contents);

        file_put_contents($path, $contents);

        return $this;
    }
}
