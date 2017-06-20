<?php

namespace App\Presenters;

use App\Model\ProjektManager;
use Nette;


class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var ProjektManager */
    private $projektManager;

    public function __construct(ProjektManager $projektManager)
    {
        $this->projektManager = $projektManager;
    }

    public function renderDefault()
    {
        $this->template->projekty = $this->projektManager->getAllProjekt();

    }

}
