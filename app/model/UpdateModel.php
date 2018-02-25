<?php

namespace App\Model;

use Tulinkry\Poll\Services\NeonPollProvider;
use Tulinkry\Services\ParameterService;
use Nette\DI\Container;

class UpdateModel {

    /**
     * @var ParameterService
     */
    private $parameters;

    /**
     * @var NeonPollProvider
     */
    private $polls;

    public function __construct(ParameterService $parameters, NeonPollProvider $polls) {
        $this->parameters = $parameters;
        $this->polls = $polls;
    }

    public function __invoke() {
        $poll = null;
        foreach ($this->polls->all() as $p) {
            if ($p->question->text === 'Anketa o divácky aktuálně nejoblíbenější píseň') {
                $poll = $p;
            }
        }

        if (!$poll) {
            $poll = $this->polls->create('Anketa o divácky aktuálně nejoblíbenější píseň');
        }

        if (!isset($this->parameters->params['poll'])) {
            return;
        }

        $songs = $this->parameters->params['poll'];
        $answers = $this->polls->getAnswers($poll->id);
        if (count($answers) !== count($songs)) {
            foreach ($songs as $song) {
                $skip = false;
                foreach ($answers as $answer) {
                    if ($answer->getText() === $song) {
                        $skip = true;
                        break;
                    }
                }
                if ($skip) {
                    continue;
                }
                $this->polls->addAnswer($poll->id, $song);
            }
        }
    }

}

;
