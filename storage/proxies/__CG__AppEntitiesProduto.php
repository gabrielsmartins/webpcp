<?php

namespace DoctrineProxies\__CG__\App\Entities;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Produto extends \App\Entities\Produto implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'App\\Entities\\Produto' . "\0" . 'itens', '' . "\0" . 'App\\Entities\\Produto' . "\0" . 'roteiros', 'id', 'codigoInterno', 'descricao', 'situacao', 'unidadeMedida', 'valorUnitario', 'leadTime', 'quantidadeEstoque', 'quantidadeMinima', 'peso', 'comprimento', 'largura', 'altura'];
        }

        return ['__isInitialized__', '' . "\0" . 'App\\Entities\\Produto' . "\0" . 'itens', '' . "\0" . 'App\\Entities\\Produto' . "\0" . 'roteiros', 'id', 'codigoInterno', 'descricao', 'situacao', 'unidadeMedida', 'valorUnitario', 'leadTime', 'quantidadeEstoque', 'quantidadeMinima', 'peso', 'comprimento', 'largura', 'altura'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Produto $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function adicionarComponente(\App\Entities\ItemEstrutura $itemEstrutura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'adicionarComponente', [$itemEstrutura]);

        return parent::adicionarComponente($itemEstrutura);
    }

    /**
     * {@inheritDoc}
     */
    public function removerComponente($key)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removerComponente', [$key]);

        return parent::removerComponente($key);
    }

    /**
     * {@inheritDoc}
     */
    public function adicionarRoteiro(\App\Entities\Roteiro $roteiro)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'adicionarRoteiro', [$roteiro]);

        return parent::adicionarRoteiro($roteiro);
    }

    /**
     * {@inheritDoc}
     */
    public function removerRoteiro(\App\Entities\Roteiro $roteiro)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removerRoteiro', [$roteiro]);

        return parent::removerRoteiro($roteiro);
    }

    /**
     * {@inheritDoc}
     */
    public function getItens()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getItens', []);

        return parent::getItens();
    }

    /**
     * {@inheritDoc}
     */
    public function getRoteiros()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRoteiros', []);

        return parent::getRoteiros();
    }

    /**
     * {@inheritDoc}
     */
    public function setItens($estrutura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setItens', [$estrutura]);

        return parent::setItens($estrutura);
    }

    /**
     * {@inheritDoc}
     */
    public function setRoteiros($roteiros)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRoteiros', [$roteiros]);

        return parent::setRoteiros($roteiros);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'jsonSerialize', []);

        return parent::jsonSerialize();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getCodigoInterno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCodigoInterno', []);

        return parent::getCodigoInterno();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescricao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescricao', []);

        return parent::getDescricao();
    }

    /**
     * {@inheritDoc}
     */
    public function getSituacao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSituacao', []);

        return parent::getSituacao();
    }

    /**
     * {@inheritDoc}
     */
    public function getUnidadeMedida()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUnidadeMedida', []);

        return parent::getUnidadeMedida();
    }

    /**
     * {@inheritDoc}
     */
    public function getValorUnitario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValorUnitario', []);

        return parent::getValorUnitario();
    }

    /**
     * {@inheritDoc}
     */
    public function getLeadTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLeadTime', []);

        return parent::getLeadTime();
    }

    /**
     * {@inheritDoc}
     */
    public function getQuantidadeEstoque()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuantidadeEstoque', []);

        return parent::getQuantidadeEstoque();
    }

    /**
     * {@inheritDoc}
     */
    public function getQuantidadeMinima()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQuantidadeMinima', []);

        return parent::getQuantidadeMinima();
    }

    /**
     * {@inheritDoc}
     */
    public function getPeso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPeso', []);

        return parent::getPeso();
    }

    /**
     * {@inheritDoc}
     */
    public function getComprimento()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComprimento', []);

        return parent::getComprimento();
    }

    /**
     * {@inheritDoc}
     */
    public function getLargura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLargura', []);

        return parent::getLargura();
    }

    /**
     * {@inheritDoc}
     */
    public function getAltura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAltura', []);

        return parent::getAltura();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setCodigoInterno($codigoInterno)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCodigoInterno', [$codigoInterno]);

        return parent::setCodigoInterno($codigoInterno);
    }

    /**
     * {@inheritDoc}
     */
    public function setDescricao($descricao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescricao', [$descricao]);

        return parent::setDescricao($descricao);
    }

    /**
     * {@inheritDoc}
     */
    public function setSituacao($situacao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSituacao', [$situacao]);

        return parent::setSituacao($situacao);
    }

    /**
     * {@inheritDoc}
     */
    public function setUnidadeMedida($unidadeMedida)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUnidadeMedida', [$unidadeMedida]);

        return parent::setUnidadeMedida($unidadeMedida);
    }

    /**
     * {@inheritDoc}
     */
    public function setValorUnitario($valorUnitario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setValorUnitario', [$valorUnitario]);

        return parent::setValorUnitario($valorUnitario);
    }

    /**
     * {@inheritDoc}
     */
    public function setLeadTime($leadTime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLeadTime', [$leadTime]);

        return parent::setLeadTime($leadTime);
    }

    /**
     * {@inheritDoc}
     */
    public function setQuantidadeEstoque($quantidadeEstoque)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuantidadeEstoque', [$quantidadeEstoque]);

        return parent::setQuantidadeEstoque($quantidadeEstoque);
    }

    /**
     * {@inheritDoc}
     */
    public function setQuantidadeMinima($quantidadeMinima)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQuantidadeMinima', [$quantidadeMinima]);

        return parent::setQuantidadeMinima($quantidadeMinima);
    }

    /**
     * {@inheritDoc}
     */
    public function setPeso($peso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPeso', [$peso]);

        return parent::setPeso($peso);
    }

    /**
     * {@inheritDoc}
     */
    public function setComprimento($comprimento)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComprimento', [$comprimento]);

        return parent::setComprimento($comprimento);
    }

    /**
     * {@inheritDoc}
     */
    public function setLargura($largura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLargura', [$largura]);

        return parent::setLargura($largura);
    }

    /**
     * {@inheritDoc}
     */
    public function setAltura($altura)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAltura', [$altura]);

        return parent::setAltura($altura);
    }

}
