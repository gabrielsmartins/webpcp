<?php



namespace App\DAO;

use App\Entities\RecebimentoMaterial;


class RecebimentoMaterialDAO extends GenericDAO {
 
    public function __construct() {
        parent::__construct();
        $this->className = RecebimentoMaterial::class;
    }
}
