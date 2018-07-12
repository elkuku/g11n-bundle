<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 09/07/18
 * Time: 10:59
 */

namespace ElKuKu\G11nBundle\EventSubscriber;

use ElKuKu\G11n\G11n;
use ElKuKu\G11n\G11nException;
use ElKuKu\G11n\Support\ExtensionHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class G11nSubscriber implements EventSubscriberInterface
{
    private $rootDir;
    private $defaultLang;
    private $debug;

    public function __construct(string $rootDir, string $defaultLang, bool $debug)
    {
        $this->rootDir     = $rootDir;
        $this->defaultLang = $defaultLang;
        $this->debug = $debug;
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => [['processRequest']]];
    }

    public function processRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        $lang = $request->query->get('lang');

        if ($lang) {
            $request->getSession()->set('lang', $lang);
        } else {
            $lang = $request->getSession()->get('lang', $this->defaultLang);
        }

        G11n::setCurrent($lang);

        G11n::setDebug($this->debug);

        try {
            ExtensionHelper::setCacheDir($this->rootDir.'/var/cache');
            ExtensionHelper::setDomainPath($this->rootDir.'/translations');

            if ($this->debug) {
                ExtensionHelper::cleanCache();
            }

            G11n::loadLanguage();
        } catch (G11nException $e) {
            echo $e->getMessage();
        }
    }
}
