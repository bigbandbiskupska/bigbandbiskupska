<?php
/**
 * Created by PhpStorm.
 * User: ktulinger
 * Date: 2019-04-10
 * Time: 13:13
 */

namespace App\AdminModule\Components\Import\Forms;


use Nette\Http\FileUpload;
use Nette\Utils\ArrayHash;
use Nette\Utils\Callback;
use Tracy\Debugger;
use Tulinkry\Application\UI\Form;

class ImportFormStep1Factory
{
    /**
     * Get the form for step 1 for importing songs.
     *
     * @param callable $onDataCallback the callback for decoded data from the form
     * @return Form the new instance of form
     */
    public function create(callable $onDataCallback)
    {
        $form = new Form();
        $form->addText('separator', 'Oddělovač sloupců')
            ->addRule(\Nette\Forms\Form::FILLED)
            ->setDefaultValue(',');
        $form->addText('author_column', 'Číslo sloupce se jménem autora')
            ->addRule(\Nette\Forms\Form::FILLED)
            ->addRule(\Nette\Forms\Form::INTEGER)
            ->addRule(\Nette\Forms\Form::MIN, 1)
            ->setDefaultValue(2);
        $form->addText('song_column', 'Číslo sloupce se jménem písně')
            ->addRule(\Nette\Forms\Form::FILLED)
            ->addRule(\Nette\Forms\Form::INTEGER)
            ->addRule(\Nette\Forms\Form::MIN, 1)
            ->setDefaultValue(3);
        $form->addUpload('repertoar', 'Soubor s repertoárem')
            ->addRule(\Nette\Forms\Form::FILLED);
        $form->addSubmit('submit', 'Importovat')
            ->setAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = function (Form $form, ArrayHash $values) use ($onDataCallback) {
            $data = $this->parseUploadedFile($values['repertoar'], $values['separator'], $values['author_column'], $values['song_column']);
            $data = $this->sortUploadedData($data);

            if (count($data) === 0) {
                $form['repertoar']->addError('Tento soubor neobsahuje žádná data anebo neodpovídají zadanému formátu.');
            } else {
                Callback::invokeArgs($onDataCallback, [$data]);
            }
        };

        return $form;
    }

    /**
     * Parse the uploaded file as csv.
     *
     * @param FileUpload $file uploaded file
     * @param string $separator csv separator
     * @param int $author_column index of author column (starts with 1)
     * @param int $song_column index of song name column (starts with 1)
     * @return array array of (author => ..., name => ...)
     */
    private function parseUploadedFile(FileUpload $file, $separator, $author_column, $song_column)
    {
        return array_filter(array_map(function ($line) use ($file, $separator, $author_column, $song_column) {
            $prepared = array_map('trim', str_getcsv($line, $separator));

            if (!isset($prepared[$author_column - 1])) {
                Debugger::log('Column ' . $author_column . ' does not exists for ' . join(';', $prepared), Debugger::ERROR);
                return null;
            }
            if (!isset($prepared[$song_column - 1])) {
                Debugger::log('Column ' . $song_column . ' does not exists for ' . join(';', $prepared), Debugger::ERROR);
                return null;
            }

            return (object)array('author' => $prepared[$author_column - 1], 'name' => $prepared[$song_column - 1]);
        }, explode(PHP_EOL, $file->contents)));
    }

    /**
     * Sort the data in the array based on name and author.
     * @param array $data the data of (author => ..., name => ...)
     * @return array sorted array
     */
    private function sortUploadedData(array $data)
    {
        usort($data, function ($a, $b) {
            $cmp = strcmp($a->name, $b->name);
            if ($cmp != 0) {
                return $cmp;
            }
            return strcmp($a->author, $b->author);
        });

        return $data;
    }
}