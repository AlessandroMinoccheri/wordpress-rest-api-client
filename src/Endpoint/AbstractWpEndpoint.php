<?php

namespace Vnn\WpApiClient\Endpoint;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use RuntimeException;
use Vnn\WpApiClient\WpClient;

/**
 * Class AbstractWpEndpoint
 * @package Vnn\WpApiClient\Endpoint
 */
abstract class AbstractWpEndpoint
{
    /**
     * @var WpClient
     */
    private $client;

    /**
     * @var Response
     */
    private $response;

    /**
     * Users constructor.
     * @param WpClient $client
     */
    public function __construct(WpClient $client)
    {
        $this->client = $client;
    }

    abstract protected function getEndpoint();

    /**
     * @param int $id
     * @param array $params - parameters that can be passed to GET
     *        e.g. for tags: https://developer.wordpress.org/rest-api/reference/tags/#arguments
     * @return array
     */
    public function get($id = null, array $params = null)
    {
        $uri = $this->getEndpoint();
        $uri .= (is_null($id)?'': '/' . $id);
        $uri .= (is_null($params)?'': '?' . http_build_query($params));

        $request = new Request('GET', $uri);
        $this->response = $this->client->send($request);

        if ($this->response->hasHeader('Content-Type')
            && substr($this->response->getHeader('Content-Type')[0], 0, 16) === 'application/json') {

            return json_decode($this->response->getBody()->getContents(),true);
        }

        throw new RuntimeException('Unexpected response');
    }

    public function lastResponseHeaders()
    {
        return $this->response->getHeaders() ?? null;
    }

    /**
     * @param array $data
     * @return array
     */
    public function save(array $data)
    {
        $url = $this->getEndpoint();

        if (isset($data['id'])) {
            $url .= '/' . $data['id'];
            unset($data['id']);
        }

        $request = new Request('POST', $url, ['Content-Type' => 'application/json'], json_encode($data));
        $this->response = $this->client->send($request);

        if ($this->response->hasHeader('Content-Type')
            && substr($this->response->getHeader('Content-Type')[0], 0, 16) === 'application/json') {
            return json_decode($this->response->getBody()->getContents(), true);
        }

        throw new RuntimeException('Unexpected response');
    }

    /**
     * @param int $id
     * @return array
     */
    public function delete($id = null)
    {
        $uri = $this->getEndpoint();
        $uri .= (is_null($id)?'': '/' . $id);

        return $this->deleteRequest($uri);
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteWithForce($id = null)
    {
        $uri = $this->getEndpoint();
        $uri .= (is_null($id)?'': '/' . $id);
        $uri .= '?force=true';

        return $this->deleteRequest($uri);
    }

    private function deleteRequest(string $uri)
    {
        $request = new Request('DELETE', $uri);
        $response = $this->client->send($request);
        if ($response->hasHeader('Content-Type')
            && substr($response->getHeader('Content-Type')[0], 0, 16) === 'application/json') {
            return json_decode($response->getBody()->getContents(), true);
        }

        throw new RuntimeException('Unexpected response');
    }
}
