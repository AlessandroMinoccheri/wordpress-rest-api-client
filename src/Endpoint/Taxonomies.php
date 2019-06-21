<?php

namespace Vnn\WpApiClient\Endpoint;

/**
 * Class Categories
 * @package Vnn\WpApiClient\Endpoint
 */
class Taxonomies extends AbstractWpEndpoint
{
    /**
     * {@inheritdoc}
     */
    protected function getEndpoint()
    {
        return "/wp-json/wp/v2";
    }
}
