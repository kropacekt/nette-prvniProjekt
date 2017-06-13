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

    protected function createComponentVytvoritProjektForm()
    {
        $form = new UI\Form;
        $form->addText('nazev', 'Název projektu:')
            ->setAttribute('class', 'form-control')
            ->setRequired("Název projektu je povinný!");

        $form->addText('datum_odevzdani', 'Datum odevzdání:')
            ->setAttribute('class', 'form-control')
            ->setType('date')
            ->setRequired("Datum odevzdání projektu je povinný!");

        $form->addSelect('typ', 'Typ projektu:', ['časově omezený', 'continuous integration'])
            ->setAttribute('class', 'form-control');

        $form->addCheckbox('webovy_projekt', ' webový projekt');

        $form->addSubmit('odeslat')
            ->setAttribute('class', 'btn btn-default');

        $form->onSuccess[] = [$this, 'vytvoritProjektFormSucceeded'];

        return $form;
    }

    public function vytvoritProjektFormSucceeded($form, $values)
    {
        $do = ($values->typ == 0 ? 'časově omezený' : 'continuous integration');
        $wp = ($values->webovy_projekt == 0 ? 'ne' : 'ano');

        $this->database->table('projekt')->insert([
            'nazev' => $values->nazev,
            'datum_odevzdani' => $values->datum_odevzdani,
            'typ' => $do,
            'webovy_projekt' => $wp
        ]);

        $this->flashMessage("Projekt byl úspěšně uložen do databáze", 'success');
        $this->redirect('this');
    }
}