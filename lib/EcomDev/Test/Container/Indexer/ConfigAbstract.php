<?php

namespace EcomDev\Test\Container\Indexer;

/**
 * Abstract configuration indexer
 *
 * @method \SimpleXmlElement getSource()
 */
abstract class ConfigAbstract extends IndexerAbstract
{
    /**
     * Set source property
     *
     * @param \SimpleXMLElement $source
     * @return ConfigAbstract
     * @throws \InvalidArgumentException
     */
    public function setSource($source)
    {
        if (!$source instanceof \SimpleXMLElement) {
            throw new \InvalidArgumentException('$source should be an instance of SimpleXmlElement class');
        }
        return parent::setSource($source);
    }
}