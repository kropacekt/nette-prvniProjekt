<?php

/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 18.06.2017
 * Time: 9:48
 */
namespace App;

use Nette\Application\UI;
use App\Model\ProjektManager;

class ProjektControl extends UI\Control
{

    /** @var ProjektManager */
    private $projektManager;

    private $idProjektu;

    public function __construct($idProjektu, ProjektManager $projektManager)
    {
        $this->idProjektu = $idProjektu;
        $this->projektManager = $projektManager;
    }

    public function render()
    {
        $this->template->render(__DIR__ . '/ProjektControl.latte');
    }

    public function createComponentProjektForm()
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

        if (!$this->idProjektu) { //id neni -> nejde o editaci
            $form->onSuccess[] = [$this, 'processPridatProjektForm'];

        } else {
            $form->setDefaults($this->projektManager->getProjekt($this->idProjektu));
            $form->onSuccess[] = [$this, 'processEditovatProjektForm'];
        }

        return $form;
    }

    public function processPridatProjektForm(UI\Form $form)
    {
        $values = $form->values;
        $this->projektManager->pridatProjekt($values);
        $this->flashMessage("Projekt byl úspěšně uložen do databáze.", 'success');
        $this->redirect('this');

    }

    public function processEditovatProjektForm(UI\Form $form)
    {
        $values = $form->values;
        $this->projektManager->editovatProjekt($this->idProjektu, $values);
        $this->flashMessage("Projekt byl úspěšně upraven.", 'info');
    }

    /*public function handleDelete($id)
    {
        $this->projektManager->smazatProjekt($id);
        $this->redirect("Homepage:");
    }*/

}

/** rozhranní pro generovanou továrničku */
interface IProjektControlFactory
{
    /**
     * @return ProjektControl
     * @param $idProjektu
     */
    function create($idProjektu = null);
}