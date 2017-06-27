<?php

/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 18.06.2017
 * Time: 9:48
 */
namespace App;

use App\Model\ProjekUzivatelManager;
use App\Model\UzivatelManager;
use Nette\Application\UI;
use App\Model\ProjektManager;

class ProjektControl extends UI\Control
{

    /** @var ProjektManager */
    private $projektManager;

    /** @var ProjekUzivatelManager */
    private $projekUzivatelManager;

    /** @var UzivatelManager */
    private $uzivatelManager;

    private $idProjektu;

    public function __construct($idProjektu, ProjektManager $projektManager, UzivatelManager $uzivatelManager, ProjekUzivatelManager $projekUzivatelManager)
    {
        $this->idProjektu = $idProjektu;
        $this->projektManager = $projektManager;
        $this->projekUzivatelManager = $projekUzivatelManager;
        $this->uzivatelManager = $uzivatelManager;
        define("POCET_UZIVATELU", $this->uzivatelManager->getUzivatelAllCount());
    }

    public function render()
    {
        $this->template->id = $this->idProjektu;
        $this->template->pocet_uzivatelu = POCET_UZIVATELU;
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

        //vsichni uzivatele z dtb
        $uzivatele = $this->uzivatelManager->getUzivatelAll();

        foreach ($uzivatele as $uzivatel) {
            $form->addSelect($uzivatel['id'], '#'.$uzivatel['id'], [$uzivatel['id'] => $uzivatel['jmeno'].' '.$uzivatel['prijmeni']])
                ->setAttribute('class', 'form-control btn-block')
                ->setPrompt('-');
        }

        $form->addSubmit('odeslat')
            ->setAttribute('class', 'btn btn-primary btn-lg');

        if (!$this->idProjektu) { //id neni -> nejde o editaci => pridani noveho projektu
            $form->onSuccess[] = [$this, 'processPridatProjektForm'];

        } else { //editace
            //id uzivatelu, kteri jsou prirazeni k projektu
            $uzivateleProjektu = $this->projekUzivatelManager->getUzivateleProjekt($this->idProjektu);

            //detaily editovaneho projektu
            $defaultValues = $this->projektManager->getProjekt($this->idProjektu);

            $defaultValues = $defaultValues + $uzivateleProjektu;
            $form->setDefaults($defaultValues);

            $form->onSuccess[] = [$this, 'processEditovatProjektForm'];
        }

        return $form;
    }

    public function getProjektValues($values)
    {
        return [
            "nazev" => $values->nazev,
            "datum_odevzdani" => $values->datum_odevzdani,
            "typ" => $values->typ,
            "webovy_projekt" => $values->webovy_projekt
        ];
    }

    public function getUzivateleValues($values)
    {
        $uzivateleValues = [0=>NULL]; //id uzivatelu zacinaji od 1
        for($i = 1; $i <= POCET_UZIVATELU; $i++) {
            $uzivateleValues[] = $values->$i;
        }

        //odstrani NULL hodnoty
        return array_filter($uzivateleValues);
    }

    public function processPridatProjektForm(UI\Form $form)
    {
        $values = $form->values;

        $projektValues = $this->getProjektValues($values);
        $uzivateleValues = $this->getUzivateleValues($values);

        $this->projektManager->pridatProjekt($projektValues);

        //projekt jeste pred chvili neexistoval - id neni v promenne $idProjektu, proto extra funkce
        $this->projekUzivatelManager->pracovniSila($this->projektManager->getIdProjektLast(), $uzivateleValues);

        $this->flashMessage("Projekt byl úspěšně uložen do databáze.", 'success');
        $this->redirect('this');

    }

    public function processEditovatProjektForm(UI\Form $form)
    {
        $values = $form->values;
        $projektValues = $this->getProjektValues($values);
        $uzivateleValues = $this->getUzivateleValues($values);

        $this->projektManager->editovatProjekt($this->idProjektu, $projektValues);
        $this->projekUzivatelManager->pracovniSila($this->idProjektu, $uzivateleValues);

        $this->flashMessage("Projekt byl úspěšně upraven.", 'info');
        $this->redirect('this');
    }

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