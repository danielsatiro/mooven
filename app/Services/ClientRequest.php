<?php

/**
 * Sends data via cURL
 * @author Daniel Satiro <danielsatiro2003@yahoo.com.br>
 */

namespace App\Services;

abstract class ClientRequest
{
    protected $url;
    protected $credentials;
    protected $credentialType = 'Basic';
    protected $ip;
    protected $headerHttp;
    protected $timeout = 30;
    protected $connectTimeout = 30;
    protected $version = '';

    /**
     * Get URL
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url . $this->version;
    }

    /**
     * Get credential
     * @return null|string
     */
    public function getCredentials()
    {
        if (isset($this->credentials)) {
            return $this->credentialType == 'Basic' ? base64_encode($this->credentials) : $this->credentials;
        }
        return null;
    }

    /**
     * Get credential type
     * @return string
     */
    public function getCredentialType() : string
    {
        return $this->credentialType;
    }

    /**
     * Get time out
     * @return int
     */
    public function getTimeout() : int
    {
        return $this->timeout;
    }

    /**
     * Get connection time out
     * @return int
     */
    public function getConnectTimeout() : int
    {
        return $this->connectTimeout;
    }

    /**
     * Get header HTTP
     * @return array|null
     */
    public function getHeaderHttp()
    {
        if (isset($this->headerHttp)) {
            return $this->headerHttp;
        }
        return null;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array|string $data
     * @return array
     */
    protected static function dispatchRequest(string $method, string $url, $data = null) : array
    {
        $instance = new static;
        $ch = curl_init($instance->getUrl() . $url);

        $header = [];
        if ($instance->getCredentials() != null) {
            $header[] = "Authorization: {$instance->getCredentialType()} {$instance->getCredentials()}";
            curl_setopt($ch, CURLOPT_USERPWD, $instance->getCredentials());
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $instance->getConnectTimeout());
        curl_setopt($ch, CURLOPT_TIMEOUT, $instance->getTimeout());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if ($method == 'HEAD') {
            curl_setopt($ch, CURLOPT_NOBODY, true);
        }

        if (!is_null($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // TODO testar metodo de geracao de array do header
        if ($instance->getHeaderHttp() != null && is_array($instance->getHeaderHttp())) {
            foreach ($instance->getHeaderHttp() as $k => $h) {
                $header[] = $h;
            }
        }
        // TODO testar envio sem esse if
        if (count($header) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        $exec = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        $response = json_decode($exec, true);

        if (empty($response) || is_scalar($response)) {
            $response = [
                'text' => $response,
                'exec' => $exec
            ];
        }
        $response['info'] = $info;
        return $response;
    }

    /**
     * Make a request of verb DELETE
     * @param string $url
     * @param array|string $data
     * @return array
     */
    public static function delete(string $url, $data = null) : array
    {
        return self::dispatchRequest('DELETE', $url, $data);
    }

    /**
     * Make a request of verb HEAD
     * @param string $url
     * @return array
     */
    public static function head(string $url) : array
    {
        return self::dispatchRequest('HEAD', $url);
    }

    /**
     * Make a request of verb GET
     * @param string $url
     * @param array $params
     * @return array
     */
    public static function get(string$url, array $params = []) : array
    {
        $url = $url . (!empty($params) ? '?' . http_build_query($params, null, '&') : '');
        return self::dispatchRequest('GET', $url);
    }

    /**
     * Make a request of verb POST
     * @param string $url
     * @param array|string $data
     * @return array
     */
    public static function post(string $url, $data) : array
    {
        return self::dispatchRequest('POST', $url, $data);
    }

    /**
     * Make a request of verb PUT
     * @param string $url
     * @param array|string $data
     * @return array
     */
    public static function put(string $url, $data) : array
    {
        return self::dispatchRequest('PUT', $url, $data);
    }

    /**
     * Description
     * @param string $method
     * @param string $urls
     * @param type|null $data
     * @return type
     */
    public static function multiDispatchRequest($method, $urls, $data = null) : array
    {
        $mh = curl_multi_init();
        $instance = new static;
        $ch = [];
        foreach ($urls as $key => $url) {
            $ch[$key] = curl_init($instance->getUrl() . $url);

            $header = [];
            if ($instance->getCredentials() != null) {
                $header[] = "Authorization: {$instance->getCredentialType()} {$instance->getCredentials()}";
            }

            curl_setopt($ch[$key], CURLOPT_CONNECTTIMEOUT, $instance->getConnectTimeout());
            curl_setopt($ch[$key], CURLOPT_TIMEOUT, $instance->getTimeout());
            curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch[$key], CURLOPT_CUSTOMREQUEST, $method);

            if ($method == 'HEAD') {
                curl_setopt($ch[$key], CURLOPT_NOBODY, true);
            }

            if (!is_null($data)) {
                curl_setopt($ch[$key], CURLOPT_POSTFIELDS, $data);
            }
            // TODO testar metodo de geracao de array do header
            if ($instance->getHeaderHttp() != null && is_array($instance->getHeaderHttp())) {
                foreach ($instance->getHeaderHttp() as $k => $h) {
                    $header[] = $h;
                }
            }
            // TODO testar envio sem esse if
            if (count($header) > 0) {
                curl_setopt($ch[$key], CURLOPT_HTTPHEADER, $header);
            }
            curl_multi_add_handle($mh, $ch[$key]);
        }

        $active = null;
        //execute the handles
        do {
            curl_multi_exec($mh, $active);
        } while ($active > 0);

        $response = [];
        foreach ($ch as $key => $c) {
            $response[$key] = [
                'content' => json_decode(curl_multi_getcontent($c), true),
                'info' => curl_getinfo($c)
            ];
        }
        curl_multi_close($mh);

        return $response;
    }

    /**
     * Make a multi request of verb GET
     * @param array $urls
     * @param array $params
     * @return array
     */
    public static function multiGet(array $urls, array $params = []) : array
    {
        foreach ($urls as $key => $url) {
            $urls[$key] = $url . (!empty($params) ? '?' . http_build_query($params, null, '&') : '');
        }
        return self::multiDispatchRequest('GET', $urls);
    }
}
