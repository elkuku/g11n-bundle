<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 09/07/18
 * Time: 13:43
 */

namespace ElKuKu\G11nBundle\DataCollector;

use ElKuKu\G11n\G11n;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class G11nCollector extends DataCollector
{
    public function getName(): string
    {
        return 'g11n.collector';
    }

    public function reset(): void
    {
        $this->data = array();
    }

    public function collect(Request $request, Response $response, \Exception $exception = null): void
    {
        $items  = G11n::get('processedItems');
        $events = [];

        foreach (G11n::getEvents() as $event) {
            $events[] = (array)$event;
        }

        $translateds   = 0;
        $untranslateds = 0;
        $strings       = [];

        foreach ($items as $item) {
            $s = new \stdClass();

            $s->status = $item->status;
            $s->string = $item->string;

            $args = $item->args;

            array_shift($args);

            if (1 === \count($args)) {
                $args = $args[0];
            }

            $s->args = $args;

            $strings[] = $s;

            if ('-' === $item->status) {
                $untranslateds++;
            } else {
                $translateds++;
            }
        }

        $this->data = array(
            //'items' => $items,
            'strings'       => $strings,
            'events'        => $events,
            'translateds'   => $translateds,
            'untranslateds' => $untranslateds,
        );
    }

    public function getUntranslateds(): int
    {
        return $this->data['untranslateds'];
    }

    public function getTranslateds(): int
    {
        return $this->data['translateds'];
    }

    public function getStrings(): array
    {
        return $this->data['strings'];
    }

    public function getEvents(): array
    {
        return $this->data['events'];
    }
}
