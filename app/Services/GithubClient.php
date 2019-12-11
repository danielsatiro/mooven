<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Log;

/**
 * Description of GithubClient
 *
 * @author root
 */
class GithubClient {
    private $http;

    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => config('app.github.api_url'),
            'timeout' => config('app.github.api_timeout'),
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    public function search($q)
    {
        $endpoint = "/search/repositories";
        $data = [
            'q' => $q,
        ];
        try {
            $response = $this->http->get($endpoint, ['query' => $data]);

            return json_decode($response->getBody());
        } catch (RequestException $ex) {
            $response = '';
            if ($ex->hasResponse()) {
                $response = $ex->getResponse()->getBody()->getContents();
            }
            Log::error(sprintf('Endpoint: %s|Data: %s|Message: %s|Response: %s',
                $endpoint, json_encode($data), $ex->getMessage(), $response));
            return [];
        }
    }

    public function userRepos($user)
    {
        $endpoint = sprintf('/users/%s/repos', $user);

        try {
            $response = $this->http->get($endpoint);

            return json_decode($response->getBody());
        } catch (RequestException $ex) {
            $response = '';
            if ($ex->hasResponse()) {
                $response = $ex->getResponse()->getBody()->getContents();
            }
            Log::error(sprintf('Endpoint: %s|Message: %s|Response: %s',
                $endpoint, $ex->getMessage(), $response));
            return [];
        }
    }
}
