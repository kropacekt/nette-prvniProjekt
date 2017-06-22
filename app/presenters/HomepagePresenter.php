<?php

namespace App\Presenters;

use App\Model\ProjektManager;
use App\Model\ProjekUzivatelManager;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var ProjektManager */
    private $projektManager;

    /** @var ProjektManager */
    private $projekUzivatelManager;

    public function __construct(ProjektManager $projektManager, ProjekUzivatelManager $projekUzivatelManager)
    {
        $this->projektManager = $projektManager;
        $this->projekUzivatelManager = $projekUzivatelManager;
    }

    public function renderDefault()
    {
        $this->template->projekty = $this->projektManager->getProjektAll();
        $this->template->uzivatele = $this->projekUzivatelManager->getUzivateleProjekt();
    }

}
