<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-04-10
 * Time: 13:15
 */

namespace App\AdminModule\Components\Import\Forms;


use App\Model\AdminSongsModel;
use Exception;
use Nette\Forms\Container;
use Nette\Forms\Controls\SelectBox;
use Nette\Utils\ArrayHash;
use Nette\Utils\Callback;
use Nette\Utils\Strings;
use Tracy\Debugger;
use Tulinkry\Application\UI\Form;

class ImportFormStep2Factory
{
    /**
     * @var AdminSongsModel
     */
    private $songs;

    public function __construct(AdminSongsModel $songs)
    {
        $this->songs = $songs;
    }

    /**
     * Create the step 2 form from the already processed data and success callback.
     *
     * @param $data array the processed data
     * @param $onNewCallback callable callback for new songs
     * @return Form new form instance
     */
    public function create($data, $onNewCallback)
    {
        $form = new Form();
        $songs = $this->songs->all();

        $this->generateContainers($data ?: [], $songs, $form, $form->addContainer('songs'));

        $form->addSubmit('submit', 'Importovat')
            ->setAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = function (Form $form, $values) use ($data, $onNewCallback) {
            if (!$data) {
                $form->presenter->flashMessage('Platnost dat vypršela, zkuste to prosím znovu.', 'danger');
                $form->presenter->redirect('this');
                return;
            }

            $cnt = 0;
            foreach ($values['songs'] as $index => $song) {
                switch ($song->action) {
                    case 'new':
                        unset($song['action']);
                        try {
                            Callback::invokeArgs($onNewCallback, array($song));
                            $cnt++;
                        } catch (Exception $e) {
                            $form['songs'][$index]['author']->addError('Nepodařilo se vložit tuto píseň: ' . $e->getMessage());
                            $form['songs'][$index]['name']->addError('Nepodařilo se vložit tuto píseň: ' . $e->getMessage());
                            $form['songs'][$index]['action']->addError('Nepodařilo se vložit tuto píseň, chcete ji ignorovat?');
                        }
                        break;
                    default:
                        // do nothing, (duplicate or already exists)
                }
            }

            if (!$form->hasErrors()) {
                $form->presenter->flashMessage('Bylo importováno ' . $cnt . ' písní.', 'success');
                $form->presenter->redirect('this');
            }
        };

        return $form;
    }

    private function computeSimilarity($originalSong, $newSong)
    {
        similar_text(Strings::lower($originalSong->author), Strings::lower($newSong->author), $author_similarity);
        similar_text(Strings::lower($originalSong->name), Strings::lower($newSong->name), $song_name_similarity);
        return array($author_similarity, $song_name_similarity);
    }

    private function findSimilarity($originalSong, $newSong, $itemCallback)
    {
        list($author_similarity, $song_name_similarity) = $this->computeSimilarity($originalSong, $newSong);

        if ($author_similarity >= 60 && $song_name_similarity >= 80) {
            return Callback::invokeArgs($itemCallback, [$originalSong, 'similarity = ' . round($song_name_similarity, 1) . '%']);
        }

        $levenshtein = levenshtein(Strings::lower($newSong->name), Strings::lower($originalSong->name));
        if ($author_similarity >= 60 and $levenshtein < 3) {
            return Callback::invokeArgs($itemCallback, [$originalSong, 'levenshtein = ' . $levenshtein]);
        }

        if ($author_similarity >= 60 && soundex($newSong->name) == soundex($originalSong->name)) {
            return Callback::invokeArgs($itemCallback, [$originalSong, 'soundex match']);
        }

        return [];
    }

    /**
     * Check the song against the database records.
     *
     * @param array $songs
     * @param $song
     * @return boolean true if already imported in the database
     */
    public function isAlreadyImported($songs, $song)
    {
        foreach ($songs as $id => $originalSong) {
            if (Strings::lower($originalSong->name) === Strings::lower($song->name) && Strings::lower($originalSong->author) === Strings::lower($song->author)) {
                Debugger::log('Skipping song ' . join(' - ', [$song->author ?: 'Neznámý', $song->name]) . ' as it has been already imported');
                return true;
            }

            if (Strings::lower($originalSong->name) === Strings::lower($song->name)) {
                Debugger::log('Skipping song ' . $song->name . ' as it has been already imported');
                return true;
            }
        }
        return false;
    }

    /**
     * When the song is considered similar to the given song, fill the selectbox with appropriate items.
     *
     * @param ArrayHash $d_song the original song
     * @param ArrayHash $song the new song
     * @param SelectBox $select the selectbox
     * @return nothing
     */
    public function computeSimilarSongs($d_song, $song, SelectBox $select, callable $callback)
    {
        $newItems = $this->findSimilarity($d_song, $song, $callback);

        $select->setItems($select->items + $newItems);

        if (count($newItems) > 0) {
            $select->setDefaultValue(array_keys($newItems)[0]);
        }
    }

    /**
     * Generate containers for valid data. The container should examine similarity between already uploaded songs
     * and also among the post data songs.
     *
     * @param array $data uploaded data
     * @param array $songs database songs
     * @param Form $form the form
     * @param $songs_container Container the container for new form container
     */
    private function generateContainers($data, array $songs, Form $form, Container $songs_container)
    {
        for ($i = 0; $i < count($data); $i++) {
            $song = $data[$i];

            if ($this->isAlreadyImported($songs, $song)) {
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
                'new' => 'Nová',
                'ignore' => 'Ignorovat',
            ])->setDefaultValue('new');

            /*
             * Discover the similarity between the database songs
             */
            foreach ($songs as $id => $originalSong) {
                list($author_similarity, $song_similarity) = $this->computeSimilarity($originalSong, $song);

                // do not continue with likely database match
                if ($author_similarity >= 90 && $song_similarity >= 90) {
                    $songs_container->removeComponent($container);
                    $form->removeGroup($form->getCurrentGroup());
                    continue;
                }

                $this->computeSimilarSongs($originalSong, $song, $select, function ($d_song, $similarityReason) {
                    return [$d_song->id => sprintf('%s (%s)', $d_song->name, $similarityReason)];
                });
            }

            /*
             * Discover the similarity between the rest of the songs in the form submittion
             */
            for ($j = $i + 1; $j < count($data); $j++) {
                $originalSong = $data[$j];

                $this->computeSimilarSongs($originalSong, $song, $select, function ($d_song, $similarityReason) {
                    return ['duplicate' => sprintf('Duplicate of %s (%s)', $d_song->name, $similarityReason)];
                });
            }
        }
    }
}