<?php

/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 18.06.2017
 * Time: 19:05
 */

namespace App\Model;

use Nette;

class ProjektManager
{
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getProjekt($id)
    {
        $projekt = $this->database
            ->table('projekt')
            ->get($id);

        $uprava = $projekt->toArray();
        $uprava['datum_odevzdani'] = $uprava['datum_odevzdani']->format('Y-m-d');

        return $uprava;
    }

    public function getAllProjekt()
    {
        return $this->database
            ->table('projekt');
    }

    public function pridatProjekt($values)
    {
        $this->database
            ->table('projekt')
            ->insert($values);
    }

    public function editovatProjekt($id, $values)
    {
        $this->database
            ->table('projekt')
            ->where("id=?", $id)
            ->update($values);
    }

    public function smazatProjekt($id)
    {
        try {
            $this->database
                ->table('projekt')
                ->where('id=?', $id)
                ->delete();

        }  catch(\Exception $e) {
            $this->flashMessage('Chyba při mazání projektu!', 'danger');
        }

    }
}