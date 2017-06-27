<?php
/**
 * Created by PhpStorm.
 * User: Tomáš Kropáček
 * Date: 20.06.2017
 * Time: 11:31
 */

namespace App\Model;

use Nette;

class ProjekUzivatelManager
{

    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function getUzivateleProjekt($idProjektu)
    {
        $projekt = $this->database->table('projekt')
            ->get($idProjektu);

        $uzivateleProjektu = [];

        foreach ($projekt->related('projekt_uzivatel') as $projektUzivatel) {
            $idUzivatele = $projektUzivatel->ref('uzivatel', 'fk_u')->id;
            $uzivateleProjektu[$idUzivatele] = $idUzivatele;
        }

        return $uzivateleProjektu;
    }

    // metoda priradi uzivatele, kteri byli prirazeni a odstrani, kteri byli odstraneni
    public function pracovniSila($idProjektu, $uzivatele)
    {
        //jiz prirazeni uzivatele
        $projektUzivatele = $this->database->table("projekt_uzivatel")
            ->where('fk_p = ?', $idProjektu)
            ->fetchAll();

        if($uzivatele) {

            for ($i = 1; $i<=20; $i++) {

                if(array_key_exists($i, $uzivatele)) {
                    try { //form se odesle s uz prirazenymi uzivateli - chyta chybu duplicate
                        $this->database->table("projekt_uzivatel")
                            ->insert(["fk_p" => $idProjektu, "fk_u" => $uzivatele[$i]]);

                    } catch (\Exception $e) {}

                }

                else {
                    foreach ($projektUzivatele as $pu) {
                        if($i == $pu['fk_u']) { //uzivatel byl prirazen, ale byl odstranen
                            $this->database->table("projekt_uzivatel")
                                ->where('fk_u = ?', $pu['fk_u'])
                                ->where('fk_p = ?', $idProjektu)
                                ->delete();
                        }
                    }
                }

            }

        }

        else { // nebyly prirazeni zadni uzivatele
             $this->database->table("projekt_uzivatel")
                 ->where('fk_p = ?', $idProjektu)
                 ->delete();
        }
    }

}