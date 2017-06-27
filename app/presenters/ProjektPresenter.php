<?php
/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 13.06.2017
 * Time: 9:19
 */

namespace App\Presenters;

use App\IProjektControlFactory;
use App\Model\ProjektManager;
use Nette\Application\UI;

class ProjektPresenter extends UI\Presenter
{
    /** @var IProjektControlFactory @inject */
    public $projektControlFactory;

    /** @var ProjektManager */
    private $projektManager;

    private $idProjektu;

    public function __construct(ProjektManager $projektManager)
    {
        $this->projektManager = $projektManager;
    }

    // vypis vsech projektu a jejich uzivatelu
    public function actionDefault()
    {
        $this->template->projekty = $this->projektManager->getProjektAll();
    }

    protected function createComponentProjekt()
    {
        $form = $this->projektControlFactory->create($this->idProjektu);
        return $form;
    }

    public function actionEditovat($id)
    {
        if($this->projektManager->getProjekt($id)) {
            $this->idProjektu = intval($id);
        } else {
            $this->error("Projekt neexistuje!");
        }
    }

    public function actionSmazat($id)
    {
        try {
            $this->projektManager->smazatProjekt($id);
            $this->flashMessage('Projekt byl úspěšně smazán.', 'info');
        } catch(\Exception $e) {
            $this->flashMessage('Projekt, který byl zadán ke smazání, neexistuje nebo jsou k němu připojeni pracovníci.', 'danger');
        }

        $this->redirect("Projekt:");

    }

}