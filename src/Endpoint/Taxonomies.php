<?php

namespace Vnn\WpApiClient\Endpoint;

/**
 * Class Categories
 * @package Vnn\WpApiClient\Endpoint
 */
class Taxonomies extends AbstractWpEndpoint
{
    private $taxonmyName = null;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return !$this->taxonmyName ? "/wp-json/wp/v2" : "/wp-json/wp/v2/".$this->taxonmyName;
    }

    public function setName($name)
    {
        $this->taxonmyName = $name;

        return $this;
    }
}
