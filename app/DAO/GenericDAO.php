<?php



namespace App\DAO;

use Doctrine\ORM\EntityRepository;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;



abstract class GenericDAO extends EntityRepository{
    
    use PaginatesFromParams;
    
    
    protected $em;
    protected $className;
    
     
    
    public function __construct() {
        $this->em = App::make('Doctrine\ORM\EntityManagerInterface');
    }
    
  
    
    public function salvar($entity){
        $this->em->persist($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function alterar($entity){
        $this->em->merge($entity);
        $this->em->flush();
        return $entity;
    }
    
    public function remover($entity){
        $this->em->remove($entity);
        $this->em->flush();
    }
    
    public function listar(){
        $lista = $this->em->getRepository($this->className)->findAll();
        return $lista;
    }
    
    public function pesquisar($id) {
        $object = $this->em->getRepository($this->className)->find($id);
        return $object;
    }
    
    
    
    public function listarComPaginacao(int $limit = 10, int $page = 1) : LengthAwarePaginator{
        try{

        
         $query = $this->em->getRepository($this->className)->createQueryBuilder('u')
                  ->orderBy('u.id','asc')
                ->getQuery()
                ;
        
        
        
         return $this->paginate($query, $limit, $page);
        
        
        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }
    }

    
    
    public function pesquisarPorCriterio($criterio, $valor,int $limit = 10, int $page = 1) : LengthAwarePaginator {
        try{

        
        $query = $this->em->getRepository($this->className)->createQueryBuilder('u')
                ->where('UPPER(u.'.$criterio.') LIKE UPPER(:'.$criterio.')')
               ->orderBy('u.'.$criterio, 'asc')
                ->setParameter($criterio, $valor.'%')
                ->getQuery();
        
         return $this->paginate($query, $limit, $page);
        
        
        } catch (QueryException $ex) {
             return $ex->getMessage() . $ex->getTrace();
        }
    }
    
}
