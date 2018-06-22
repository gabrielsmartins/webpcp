<?php

namespace App\DAO;

use App\Entities\Apontamento;
use App\Entities\TipoApontamento;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class ApontamentoDAO extends GenericDAO {

    public function __construct() {
        parent::__construct();
        $this->className = Apontamento::class;
    }
    
    
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
  
        if ($criterio != 'ordem') {
            return parent::pesquisarPorCriterio($criterio, $valor, $limit, $page);
        }

        try{
         $query = $this->em->getRepository($this->className)->createQueryBuilder('a')
                ->innerJoin('a.programacao', 'p')
                ->innerJoin('p.ordemProducao', 'o')
                ->where('o.id LIKE :ordem')
                ->setParameter('ordem',$valor.'%')
                ->getQuery();

         return $this->paginate($query, $limit, $page);

        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }

    }
    
    
    

    public function obterApontamentosPorPeriodo($dataInicio = null, $dataFim = null) {
        try {

            if ($dataInicio == null || $dataFim == null) {
                $query = $this->em->getRepository($this->className)->createQueryBuilder('a')
                        ->orderBy('a.dataInicio', 'asc')
                        ->getQuery();
            } else {
                $query = $this->em->getRepository($this->className)->createQueryBuilder('a')
                        ->where('(a.dataInicio BETWEEN :dataIni AND :dataFim)')
                        ->orderBy('a.dataInicio', 'asc')
                        ->setParameter('dataIni', $dataInicio->format('Y-m-d 00:00:00'))
                        ->setParameter('dataFim', $dataFim->format('Y-m-d 23:59:59'))
                        ->getQuery();
            }


            return $query->getResult();
        } catch (QueryException $ex) {
            return $ex->getMessage() . $ex->getTrace();
        }
    }

    public function obterApontamentoPorSetor($dataInicio = null, $dataFim = null) {
        try {

            if ($dataInicio == null || $dataFim == null) {
                $query = $this->em->createQueryBuilder()
                        ->select('s.descricao as setor,a.tipo,SUM(a.quantidade) as quantidade')
                        ->from('App\Entities\Apontamento', 'a')
                        ->innerJoin('a.programacao', 'p')
                        ->innerJoin('p.recurso', 'r')
                        ->innerJoin('r.setor', 's')
                        ->where('a.tipo = :producao or a.tipo = :descarte')
                        ->groupBy('s.descricao,a.tipo')
                        ->orderBy('s.descricao', 'asc')
                        ->setParameter('producao', TipoApontamento::PRODUCAO)
                        ->setParameter('descarte', TipoApontamento::DESCARTE)
                        ->getQuery();
            } else {
                $query = $this->em->createQueryBuilder('a')
                        ->select('s.descricao as setor,a.tipo,SUM(a.quantidade) as quantidade')
                        ->from('App\Entities\Apontamento', 'a')
                        ->innerJoin('a.programacao', 'p')
                        ->innerJoin('p.recurso', 'r')
                        ->innerJoin('r.setor', 's')
                        ->where('(a.tipo = :producao or a.tipo = :descarte) AND (a.dataInicio BETWEEN :dataIni AND :dataFim)')
                        ->groupBy('s.descricao,a.tipo')
                        ->orderBy('s.descricao', 'asc')
                        ->setParameter('producao', TipoApontamento::PRODUCAO)
                        ->setParameter('descarte', TipoApontamento::DESCARTE)
                        ->setParameter('dataIni', $dataInicio->format('Y-m-d 00:00:00'))
                        ->setParameter('dataFim', $dataFim->format('Y-m-d 23:59:59'))
                        ->getQuery();
            }


            return $query->getResult();
        } catch (QueryException $ex) {
            return $ex->getMessage() . $ex->getTrace();
        }
    }

}
