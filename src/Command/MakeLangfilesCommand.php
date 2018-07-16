<?php

namespace ElKuKu\G11nBundle\Command;

use ElKuKu\G11n\Support\ExtensionHelper;
use ElKuKu\G11nUtil\G11nUtil;
use ElKuKu\G11nUtil\Type\LanguageFileType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeLangfilesCommand extends Command
{
    protected static $defaultName = 'g11n:langfiles';

    private $rootDir;

    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Create and update language files')
            ->addArgument(
                'langs',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Language codes (e.g. en-GB)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Make language files');

        $langs = $input->getArgument('langs');

        $g11nUtil = new G11nUtil($output->getVerbosity());

        $languageFile = (new LanguageFileType())
            ->setExtension('default')
            ->setDomain('default')
            ->setTemplatePath($this->rootDir.'/translations/template.pot');

        ExtensionHelper::setDomainPath($this->rootDir.'/translations');

        foreach ($langs as $lang) {
            $languageFile->setLang($lang);
            $g11nUtil->processFiles($languageFile);
        }

        // Javascript
        $languageFile->setTemplatePath($this->rootDir.'/translations/template.js.pot')
            ->setExtension('default.js');

        foreach ($langs as $lang) {
            $languageFile->setLang($lang);
            $g11nUtil->processFiles($languageFile);
        }

        $io->success('Language files created.');
    }
}
