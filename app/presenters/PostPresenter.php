<?php
/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 13.06.2017
 * Time: 9:19
 */

namespace App\Presenters;

use Nette;
use Nette\Application\UI;

class PostPresenter extends UI\Presenter
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    protected function createComponentProjektForm()
    {
        $form = new UI\Form;

        $form->addText('nazev', 'Název projektu:')
            ->setAttribute('class', 'form-control')
            ->setRequired("Název projektu je povinný!");

        $form->addText('datum_odevzdani', 'Datum odevzdání:')
            ->setAttribute('class', 'form-control')
            ->setType('date')
            ->setRequired("Datum odevzdání projektu je povinný!");

        $form->addSelect('typ', 'Typ projektu:', ['časově omezený' => 'časově omezený', 'continuous integration' => 'continuous integration'])
            ->setAttribute('class', 'form-control');

        $form->addCheckbox('webovy_projekt', ' webový projekt');

        $form->addSubmit('odeslat')
            ->setAttribute('class', 'btn btn-default');

        $form->onSuccess[] = [$this, 'projektFormSucceeded'];

        return $form;
    }

    public function projektFormSucceeded($form, $values)
    {
        $id = $this->getParameter('id');

        if($id) {
            /* UPRAVA */
            $this->database
                ->table('projekt')
                ->where("id=?", $id)
                ->update($values);

            $this->flashMessage("Projekt byl úspěšně upraven.");

        } else {
            /* VKLADANI */
            $this->database
                ->table('projekt')
                ->insert($values);

            $this->flashMessage("Projekt byl úspěšně uložen do databáze.", 'success');
        }

        $this->redirect('this');
    }

    /* editace */
    public function actionProjekt($id)
    {
        if($id) {
            $projekt = $this->database
                ->table('projekt')
                ->get($id);

            if (!$projekt) {
                $this->error('Projekt nebyl nalezen.');
            }

            $uprava = $projekt->toArray();
            //dump($uprava);
            $uprava['datum_odevzdani'] = $uprava['datum_odevzdani']->format('Y-m-d');

            //dump($uprava);
            $this->template->id = $id;
            $this['projektForm']->setDefaults($uprava);
        }

    }

    public function actionSmazat($id)
    {
        try {
            $this->database
                ->table('projekt')
                ->where('id=?', $id)
                ->delete();

            $this->redirect("this");

        }  catch(\Exception $e) {
            $this->flashMessage('Chyba při mazání projektu!', 'danger');
        }

    }

}