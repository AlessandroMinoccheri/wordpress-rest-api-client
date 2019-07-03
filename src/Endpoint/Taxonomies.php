<?php

namespace Vnn\WpApiClient\Endpoint;

/**
 * Class Categories
 * @package Vnn\WpApiClient\Endpoint
 */
class Taxonomies extends AbstractWpEndpoint
{
    private $taxonomyName = null;

    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return !$this->taxonomyName ? "/wp-json/wp/v2" : "/wp-json/wp/v2/" . $this->taxonomyName;
    }

    public function setName($name)
    {
        $this->taxonomyName = $name;

        return $this;
    }
}
