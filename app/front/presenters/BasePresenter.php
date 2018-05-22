<?php

namespace App\FrontModule\Presenters;

use Kdyby\Translation\Translator;
use Nette;
use Nette\Application\ForbiddenRequestException;
use Nette\Utils\DateTime;
use Nette\Utils\FileSystem;
use Nette\Http\Request;
use Texy;
use Texy\Modules\HeadingModule;
use Tracy;
use Tulinkry\Application\UI\Presenter;
use Tulinkry\Http\Browser;

class BasePresenter extends Presenter {

    /** @var Translator @inject */
    public $translator;

    protected function notFoundException($message = NULL) {
        $this->error($message);
    }

    protected function forbiddenException($message = NULL) {
        throw new ForbiddenRequestException;
    }

    public function startup() {
        parent::startup();
        $this->template->productionMode = Tracy\Debugger::$productionMode;
        $this->template->isMobile = Browser::isMobile();
        $this->template->locale = $this->translator->getLocale();
        $timestamp = $this->parameters->params['appDir'] . DIRECTORY_SEPARATOR . 'timestamp';
        if(file_exists($timestamp)) {
            $this->template->lastUpdated = DateTime::from(@filemtime($timestamp));
        }
    }

    public static function update() {
        $timestamp = APP_DIR . DIRECTORY_SEPARATOR . 'timestamp';
        if(file_exists($timestamp)) {
            FileSystem::delete($timestamp);
        }
        FileSystem::write($timestamp, "");
    }

    protected function createTemplate($class = NULL) {
        $template = parent::createTemplate($class);

        $template->addFilter('metres', function ($s) {

            if ($s < 1000)
                return round($s, 1) . " m";
            else
                return round($s / 1000, 1) . " km";
        });

        $template->addFilter('degree', function ($s) use ($template) {
            return $s . html_entity_decode('&deg;', ENT_NOQUOTES, 'UTF-8');
        });

        $template->addFilter('timeleft', function ($s, $round = 1) use ($template) {
            if (!($s instanceof DateTime) && !($s instanceof \DateTime))
                return $s;

            $diff = $s->diff(new DateTime());
            $r = "";
            foreach (['r' => (object) ['part' => 'y', 'next' => 'm', 'ratio' => 12],
        'měs.' => (object) ['part' => 'm', 'next' => 'd', 'ratio' => 30],
        'd' => (object) ['part' => 'd', 'next' => 'h', 'ratio' => 24],
        'h' => (object) ['part' => 'h', 'next' => 'i', 'ratio' => 60],
        'min.' => (object) ['part' => 'i', 'next' => 's', 'ratio' => 60],
        'sec.' => (object) ['part' => 's', 'next' => NULL, 'ratio' => 100]] as $val => $type)
                if ($diff->{$type->part}) {
                    $r = ceil($diff->{$type->part} + ($type->next ? $diff->{$type->next} / $type->ratio : 0)) . ' ' . $val;
                    break;
                }
            // TODO: Handle correctly when diff is negative (invert === false)
            return $diff->invert ? ( $r === "" ? "0 s" : $r ) : "0 s";
        });

        $template->addFilter('activate', function($s) use ($template) {
            return preg_replace_callback("|\{since:\s*(\d+)\}|", function($matches) {
                $diff = date('Y') - $matches[1] > 0 ? date('Y') - $matches[1] : 0;
                switch ($diff) {
                    case 0: return "několik měsíců";
                    case 1: return "1 rok";
                    case 2:
                    case 3:
                    case 4: return $diff . " roky";
                    default: return $diff . " let";
                }
            }, $s);
        });

        $template->addFilter('weekday', function($s) use ($template) {
            // TODO: Implement proper weekday handling
            $weekday = $s->format("w");
            $weekdays = [
                "cs" => [
                    "long" => ["Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota"],
                    "short" => ["Ne", "Po", "Út", "St", "Čt", "Pá", "So"],
                ]
            ];
            return $weekdays ["cs"] ["long"] [$weekday];
        });

        $template->addFilter('month', function($s) use ($template) {
            // TODO: Implement proper month handling
            $monthday = $s->format("n") - 1;
            $monthdays = [
                "cs" => [
                    "long" => ["Leden", "Únor", "Březen", "Duben", "Květen", "Červen",
                        "Červenec", "Srpen", "Září", "Říjen", "Listopad", "Prosinec"],
                ]
            ];
            return $monthdays ["cs"] ["long"] [$monthday];
        });

        $template->addFilter('join', function($s) use ($template) {
            return implode(",", $s);
        });


        $template->addFilter('truncateHtml', function ($string, $limit, $break = " ", $pad = "  ...") {
            $v = function ($string, $pad = " ...") {
                //zkotrolujeme ze jsou vsechny tagy ukoncene (cele) pokud ne tak je odstranime
                $prereg = "#((<[a-z1-9]+(?:\n| ).*)((?:>|$))|(<[a-z](?:>|$)))#miU";
                preg_match_all($prereg, $string, $match);
                $uncomplete = $match[0];
                $uncomplete = array_reverse($uncomplete);
                if (!Nette\Utils\Strings::endsWith($uncomplete[0], ">")) {
                    $re = "#(" . $uncomplete[0] . ")$#miU";
                    $string = preg_replace($re, $pad, $string, -1, $count);
                }
                // najdeme všechny otevřené tagy
                $re = "#<(?!meta|img|br|hr|input\b)\b([a-z1-9]+)((\n| ).*)?(?<![\/|\/ ])>#imU";
                preg_match_all($re, $string, $match);
                $openedtags = $match[1];
                // najdeme všechny uzavřené tagy
                preg_match_all("#<\/([a-z1-9]+)>#iU", $string, $match);
                $closedtags = $match[1];
                $len_opened = count($openedtags);
                // pokud jsou všechny tagy uzavřeny vrátime $string
                if (count($closedtags) == $len_opened) {
                    return $string;
                }
                $openedtags = array_reverse($openedtags);
                // zavřeme tagy
                for ($i = 0; $i < $len_opened; $i ++) {
                    if (!in_array($openedtags[$i], $closedtags)) {
                        $string .= "</" . $openedtags[$i] . ">";
                    } else {
                        unset($closedtags[array_search($openedtags[$i], $closedtags)]);
                    }
                }
                return $string;
            };

            // pokud je text kratší než je požadováno vrátíme celý $string
            if (mb_strlen($string, 'UTF-8') <= $limit)
                return $string;
            // existuje $break mezi $limit a koncem $string?
            if (false !== ($breakpoint = mb_strpos($string, $break, $limit, "UTF-8"))) {
                if ($breakpoint < mb_strlen($string, 'UTF-8') - 1) {
                    $string = mb_substr($string, 0, $breakpoint, "UTF-8") . $pad;
                }
            }
            return $v($string, $pad);

            // abychom nemuseli používat makro |noescape vrátíme jako objekt html
            //$html = new Nette\Utils\Html();
            //return $html::el()->setHtml(Text::truncateHtmlText($string, $limit, $break, $pad));
        });

        $texy = new Texy\Texy();
        // ...a jeho konfigurace
        $texy->addHandler('script', function ($invocation, $cmd, $args, $raw) {
            switch ($cmd) {
                case 'heading':
                    if (is_int($args[0]) && $args[0] >= 1 && $args[0] <= 7) {
                        $invocation->getTexy()->headingModule->top = (int) $args[0];
                    } else if ($args[0] === 'fixed') {
                        $invocation->getTexy()->headingModule->balancing = HeadingModule::FIXED;
                    } else if ($args[0] === 'dynamic') {
                        $invocation->getTexy()->headingModule->balancing = HeadingModule::DYNAMIC;
                    }
                    return '';
                default: // neumime zpracovat, zavolame dalsi handler v rade
                    return $invocation->proceed();
            }
        });

        //$template->registerFilter(new Nette\Templates\LatteFilter);
        $template->registerHelper('texy', array($texy, 'process'));


        return $template;
    }

}
