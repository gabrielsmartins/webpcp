<?php

namespace App\Entities;

use App\Util\ValorAcimaDoSolicitadoException;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recebimento_material")
 */
class RecebimentoMaterial {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer",name="receb_id")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime",name="receb_dt")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="receb_usr_id", referencedColumnName="usr_id")
     */
    private $responsavel;

    /**
     * @ORM\OneToMany(targetEntity="ItemRecebimento", mappedBy="recebimento",cascade={"persist"})
     */
    private $itens;

    public function __construct($responsavel) {
        $this->responsavel = $responsavel;
        $this->data = new DateTime('now');
        $this->itens = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function getItens() {
        return $this->itens;
    }

    function setItens($itens) {
        $this->itens = $itens;
    }

    function getItensRecebimento() {
        return $this->itens;
    }

    function adicionarItem(ItemRecebimento $item) {
        if ($item->getQuantidade() > $item->getItemRequisicao()->getQuantidade()) {
            throw new ValorAcimaDoSolicitadoException("Quantidade informada é maior que a quantidade solicitada na requisição");
        }
        $valor = $item->getItemRequisicao()->getMaterial()->getQuantidadeEstoque();
        $valor += $item->getQuantidade();
        $item->getItemRequisicao()->getMaterial()->setQuantidadeEstoque($valor);
        $this->itens->add($item);
        $this->atualizaStatusRequisicao($item);
    }

    function removerItem(ItemRecebimento $item) {
        if ($this->itens->contains($item)) {
            $this->itens->remove($item);
        }
    }

    private function atualizaStatusRequisicao(ItemRecebimento $item) {
        $requisicao = $item->getItemRequisicao()->getRequisicao();
        if ($requisicao->getStatus() == StatusRequisicaoMaterial::EMITIDA) {
            $requisicao->setStatus(StatusRequisicaoMaterial::CONCLUIDA_PARCIAL);
        }
       

        $itemConcluidos = array();
        foreach ($requisicao->getItens() as $itemRequisicao) {
            $quantidadeRecebida = 0;
            foreach ($itemRequisicao->getItensRecebimento() as $itemRecebimento) {
                $quantidadeRecebida += $itemRecebimento->getQuantidade();
            }
            if ($quantidadeRecebida >= $item->getItemRequisicao()->getQuantidade()) {
                $itemConcluidos[] = $itemRequisicao;
            }
        }

        if (count($itemConcluidos) >= $requisicao->getItens()->count()) {
            $requisicao->setStatus(StatusRequisicaoMaterial::CONCLUIDA_TOTAL);
        }
    }

}
