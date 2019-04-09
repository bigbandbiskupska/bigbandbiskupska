<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-04-09
 * Time: 10:50
 */

namespace App\AdminModule\Components;


use App\Model\AdminSongsModel;
use Exception;
use Nette\Application\UI\Control;
use Nette\Utils\Json;
use Nette\Utils\Strings;
use Tracy\Debugger;
use Tulinkry\Application\UI\Form;

class ImportControl extends Control
{
    /**
     * @var AdminSongsModel
     * @inject
     */
    public $songs;

    private $data = [];

    public function createComponentFirstStepForm($name)
    {
        $form = new Form($this, $name);

        $form->addText('separator', 'Oddělovač sloupců')
            ->addRule(\Nette\Forms\Form::FILLED)
            ->setDefaultValue(',');
        $form->addText('author_column', 'Číslo sloupce se jménem autora')
            ->addRule(\Nette\Forms\Form::FILLED)
            ->setDefaultValue(2);
        $form->addText('song_column', 'Číslo sloupce se jménem písně')
            ->addRule(\Nette\Forms\Form::FILLED)
            ->setDefaultValue(3);
        $form->addUpload('repertoar', 'Soubor s repertoárem')
            ->addRule(\Nette\Forms\Form::FILLED);
        $form->addSubmit('submit', 'Importovat');

        $form->onSuccess[] = function ($form, $values) {
            $this->data = array_filter(array_map(function ($line) use ($values) {
                $prepared = array_map('trim', str_getcsv($line, $values['separator']));

                if (!isset($prepared[$values->author_column - 1])) {
                    Debugger::log('Column ' . $values->author_column . ' does not exists for ' . join(';', $prepared), Debugger::ERROR);
                    return null;
                }
                if (!isset($prepared[$values->song_column - 1])) {
                    Debugger::log('Column ' . $values->song_column . ' does not exists for ' . join(';', $prepared), Debugger::ERROR);
                    return null;
                }

                return (object)array('author' => $prepared[$values->author_column - 1], 'name' => $prepared[$values->song_column - 1]);
            }, explode(PHP_EOL, $values['repertoar']->contents)));
            usort($this->data, function ($a, $b) {
                $cmp = strcmp($a->name, $b->name);
                if ($cmp != 0) {
                    return $cmp;
                }
                return strcmp($a->author, $b->author);
            });

            if (count($this->data) === 0) {
                $form['repertoar']->addError('Tento soubor neobsahuje žádná data anebo neodpovídají zadanému formátu.');
            }
        };

        return $form;
    }

    public function createComponentSecondStepForm($name)
    {
        $form = new Form($this, $name);
        $hidden = $form->addHidden('data');

        $songs = $this->songs->all();

        if (count($this->data) === 0 && $form->isSuccess()) {
            $this->data = Json::decode($form['data']->value);
        }

        $songs_container = $form->addContainer('songs');

        for ($i = 0; $i < count($this->data); $i++) {
            $song = $this->data[$i];
            if ($this->songs->by(['name' => $song->name, 'author' => $song->author])) {
                Debugger::log('Skipping song ' . join(' - ', [$song->author ?: 'Neznámý', $song->name]) . ' as it has been already imported');
                continue;
            }

            if ($this->songs->by(['name' => $song->name])) {
                Debugger::log('Skipping song ' . $song->name . ' as it has been already imported');
                continue;
            }

            $form->addGroup(join(' - ', [$song->name, $song->author ?: 'Neznámý']));
            $container = $songs_container->addContainer('song' . $i);
            $container->setCurrentGroup($form->getCurrentGroup());
            $container->addText('author', 'Autor')
                ->setDefaultValue($song->author ?: 'Neznámý');
            $container->addText('name', 'Název')
                ->setDefaultValue($song->name);

            $select = $container->addSelect('action', 'Akce', [
                'new' => 'Nová'
            ])->setDefaultValue('new');

            foreach ($songs as $id => $d_song) {
                similar_text(Strings::lower($d_song->author), Strings::lower($song->author), $author_percent);
                similar_text(Strings::lower($d_song->name), Strings::lower($song->name), $song_percent);

                if ($author_percent >= 60 && $song_percent >= 80) {
                    $select->setItems($select->getItems() + [$d_song->id => $d_song->name . ' (% = ' . $song_percent . '%)']);
                    $select->setDefaultValue($d_song->id);
                    continue;
                }

                $levenshtein = levenshtein(Strings::lower($song->name), Strings::lower($d_song->name));
                if ($author_percent >= 60 and $levenshtein < 3) {
                    $select->setItems($select->getItems() + [$d_song->id => $d_song->name . ' (lvst = ' . $levenshtein . ')']);
                    $select->setDefaultValue($d_song->id);
                    continue;
                }

                if ($author_percent >= 60 && soundex($song->name) == soundex($d_song->name)) {
                    $select->setItems($select->getItems() + [$d_song->id => $d_song->name . ' (soundex match)']);
                    $select->setDefaultValue($d_song->id);
                    continue;
                }
            }

            for ($j = $i + 1; $j < count($this->data); $j++) {
                $d_song = $this->data[$j];

                similar_text(Strings::lower($d_song->author), Strings::lower($song->author), $author_percent);
                similar_text(Strings::lower($d_song->name), Strings::lower($song->name), $song_percent);

                if ($author_percent >= 60 && $song_percent >= 80) {
                    $select->setItems($select->getItems() + ['duplicate' => 'Duplicate of ' . $d_song->name . ' (% = ' . $song_percent . '%)']);
                    $select->setDefaultValue('duplicate');
                    continue;
                }

                $levenshtein = levenshtein(Strings::lower($song->name), Strings::lower($d_song->name));
                if ($author_percent >= 60 and $levenshtein < 3) {
                    $select->setItems($select->getItems() + ['duplicate' => 'Duplicate of ' . $d_song->name . ' (lvst = ' . $levenshtein . ')']);
                    $select->setDefaultValue('duplicate');
                    continue;
                }

                if ($author_percent >= 60 && soundex($song->name) == soundex($d_song->name)) {
                    $select->setItems($select->getItems() + ['duplicate' => 'Duplicate of ' . $d_song->name . ' (soundex match)']);
                    $select->setDefaultValue('duplicate');
                    continue;
                }
            }
        }

        $hidden->setDefaultValue(Json::encode($this->data));
        $form->addSubmit('submit', 'Importovat');

        $form->onSuccess[] = function ($form, $values) {
            $cnt = 0;
            foreach ($values['songs'] as $index => $song) {
                switch ($song->action) {
                    case 'new':
                        unset($song['action']);
                        try {
                            $this->songs->create([
                                array_merge((array)$song, [
                                    'hidden' => true,
                                    'tags' => ''
                                ])
                            ]);
                            $cnt++;
                        } catch (Exception $e) {
                            $form['songs'][$index]['author']->addError('Nepodařilo se vložit tuto píseň: ' . $e->getMessage());
                            $form['songs'][$index]['name']->addError('Nepodařilo se vložit tuto píseň: ' . $e->getMessage());
                        }
                        break;
                    default:
                        // do nothing, (duplicate or already exists)
                }
            }

            if (!$form->hasErrors()) {
                $this->presenter->flashMessage($cnt . ' písní bylo úspěšně vloženo', 'success');
                $this->redirect('this');
            }
        };

        return $form;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . '/templates/import.latte');

        $this->template->step = 1;
        if ($this['firstStepForm']->submitted && !$this['firstStepForm']->success) {
            $this->template->step = 1;
        }
        if ($this['firstStepForm']->success || ($this['secondStepForm']->submitted && !$this['secondStepForm']->success)) {
            $this->template->step = 2;
        }

        $this->template->render();
    }
}