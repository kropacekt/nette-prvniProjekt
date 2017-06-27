<?php
/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 26.06.2017
 * Time: 11:01
 */

namespace App\Presenters;

use Nette\Application\UI;

class HomepagePresenter extends UI\Presenter
{
    public function actionDefault()
    {
        $this->redirect("Projekt:default");
    }
}