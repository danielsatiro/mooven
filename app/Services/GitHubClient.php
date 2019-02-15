<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class GitHubClient extends ClientRequest
{
    protected $url;
    protected $timeout = 15;
    protected $connectTimeout = 15;
    protected $headerHttp = [
        'Content-Type: application/json',
        'User-Agent: Awesome-Octocat-App'
    ];
    const RESOURCE = '/users';

    protected function __construct()
    {
        $this->url = config('app.apiGitHUbUrl');
    }

    public static function getUserProfile(string $username) : array
    {
        $requestResult = self::get(self::RESOURCE . "/{$username}");

        $data = [
            'data' => $requestResult, 
            'httpCode' => $requestResult['info']['http_code']
        ];
        if ($requestResult['info']['http_code'] == 200) {
            $data['data'] = [
                'id' => $requestResult['id'],
                'login' => $requestResult['login'],
                'name' => $requestResult['name'],
                'avatar_url' => $requestResult['avatar_url'],
                'html_url' => $requestResult['html_url']
            ];
        }

        unset($data['data']['info']);
        return $data;
    }

    public static function getUserRepos(string $username) : array
    {
        $requestResult = self::get(self::RESOURCE . "/{$username}/repos");

        $data = [
            'data' => $requestResult, 
            'httpCode' => $requestResult['info']['http_code']
        ];
        if ($requestResult['info']['http_code'] == 200) {
            unset($requestResult['info']);
            $data['data'] = [];
            foreach ($requestResult as $key => $value) {
                $data['data'][] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'description' => $value['description'],
                'html_url' => $value['html_url']
            ];
            }            
        }

        unset($data['data']['info']);
        return $data;
    }
}
