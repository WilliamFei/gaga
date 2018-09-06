<?php
/**
 * Created by PhpStorm.
 * User: childeYin<尹少爷>
 * Date: 17/07/2018
 * Time: 10:34 AM
 */

class ZalyCurl
{
    protected $_curlObj = '';
    protected $_bodyContent = '';
    protected $timeOut = 3;///单位秒
    protected $wpf_Logger;

    public function __construct()
    {
        $this->wpf_Logger = new Wpf_Logger();
    }

    /**
     * @param $action
     * @param $requestBody
     * @param $url add &body_format=pb
     * @param $method
     * @return mixed
     * @throws Exception
     */
    public function requestWithActionByPb($action, $requestBody, $url, $method)
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        try {
            $anyBody = new \Google\Protobuf\Any();
            $anyBody->pack($requestBody);

            $transportData = new \Zaly\Proto\Core\TransportData();
            $transportData->setAction($action);
            $transportData->setBody($anyBody);
            $params = $transportData->serializeToString();

            $this->_curlObj = curl_init();
            $this->_getRequestParams($params);
//            $this->_setHeader($headers);
            $this->setRequestMethod($method);
            curl_setopt($this->_curlObj, CURLOPT_URL, $url);
            curl_setopt($this->_curlObj, CURLOPT_TIMEOUT, $this->timeOut);

            if (($resp = curl_exec($this->_curlObj)) === false) {
                $this->wpf_Logger->error('when run Router, unexpected error :' . curl_error($this->_curlObj));
                throw new Exception(curl_error($this->_curlObj));
            }
            curl_close($this->_curlObj);
            return $resp;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $this->wpf_Logger->error($tag, 'when run Router, unexpected error :' . $message);
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 发送curl请求
     *
     * @author 尹少爷 2017.12.22
     *
     * @param string method
     * @param string url
     * @param array params
     * @param array headers
     *
     * @return bool|mix
     * @throws Exception
     */
    public function request($method, $url, $params = [], $headers = [])
    {
        $tag = __CLASS__.'-'.__FUNCTION__;
        try {
            $this->_curlObj = curl_init();
            $this->_getRequestParams($params);
            $this->_setHeader($headers);
            $this->setRequestMethod($method);
            curl_setopt($this->_curlObj, CURLOPT_URL, $url);

            if (($resp = curl_exec($this->_curlObj)) === false) {
                $this->wpf_Logger->error($tag, 'when run Router, unexpected error :' . curl_error($this->_curlObj));
                throw new Exception(curl_error($this->_curlObj));
            }
            curl_close($this->_curlObj);
            return $resp;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $this->wpf_Logger->error($tag, 'when run Router, unexpected error :' . $message);
            throw new Exception($e->getMessage());
        }
    }

    public function requestAndReturnHeaders($method, $url, $params = [], $headers = [])
    {
        try {
            $urlParams = parse_url($url);
            $query = isset($urlParams['query']) ? $urlParams['query'] : [];
            $urlParams = $this->convertUrlQuery($query);

            $bodyFormat = isset($urlParams['body_format']) ? $urlParams['body_format'] : "";
            $action = isset($urlParams['action']) ? $urlParams['action'] : "";
            $body  = json_decode($params, true);

            if (isset($bodyFormat) && !isset($body['action'])) {
                switch ($bodyFormat) {
                    case 'json':
                        $body  = json_decode($params, true);
                        $params = [
                            "action"  => $action,
                            "body" => $body,
                            ];
                        $params = json_encode($params);
                        break;
                    case 'pb':
                        $anyBody = new \Google\Protobuf\Any();
                        $anyBody->pack($params);
                        $transportData = new \Zaly\Proto\Core\TransportData();
                        $transportData->setAction($action);
                        $transportData->setBody($anyBody);
                        $params = $transportData->serializeToString();
                        break;
                    case 'base64pb':
                        break;
                }
            }

            $this->_curlObj = curl_init();
            $this->_getRequestParams($params);
            $this->_setHeader($headers);
            $this->setRequestMethod($method);
            curl_setopt($this->_curlObj, CURLOPT_URL, $url);
            curl_setopt($this->_curlObj, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($this->_curlObj, CURLOPT_MAXREDIRS, 6);
            curl_setopt($this->_curlObj, CURLOPT_HEADER, true);

            if (($resp = curl_exec($this->_curlObj)) === false) {
                $this->wpf_Logger->error('when run Router, unexpected error :' , curl_error($this->_curlObj));
                throw new Exception(curl_error($this->_curlObj));
            }

            $curl_info = curl_getinfo($this->_curlObj);
            $httpCode = curl_getinfo($this->_curlObj, CURLINFO_HTTP_CODE);
            curl_close($this->_curlObj);

            $header_size = $curl_info['header_size'];
            $header = substr($resp, 0, $header_size);
            $body = substr($resp, $header_size);

            $headerRows = explode("\r\n", $header);

            $header = array();
            foreach ($headerRows as $val) {
                $row = explode(":", $val, 2);
                if (count($row) != 2) {
                    continue;
                }

                $headerKey = trim($row[0]);
                $headerValue = trim($row[1]);
                $header[$headerKey] = $headerValue;
            }

            $retValue = array(
                "body" => $body,
                "httpCode" => $httpCode,
                "header" => $header
            );
            return $retValue;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            error_log('when run Router, unexpected error :' . $message);
            throw new Exception($e->getMessage());
        }
    }

    private function convertUrlQuery($query)
    {
        if (empty($query)) {
            return [];
        }

        $queryParts = explode('&', $query);
        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }

    protected function setRequestMethod($method)
    {
        curl_setopt($this->_curlObj, CURLOPT_TIMEOUT, $this->timeOut);
        switch (strtoupper($method)) {
            case 'HEAD':
                curl_setopt($this->_curlObj, CURLOPT_NOBODY, true);
                break;
            case 'GET':
                //	TRUE to include the header in the output.
                curl_setopt($this->_curlObj, CURLOPT_HEADER, false);
                //TRUE to reset the HTTP request method to GET. Since GET is the default, this is only necessary if the request method has been changed.
                curl_setopt($this->_curlObj, CURLOPT_HTTPGET, true);
                //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it directly.
                curl_setopt($this->_curlObj, CURLOPT_RETURNTRANSFER, true);
                break;
            case 'POST':
                curl_setopt($this->_curlObj, CURLOPT_HEADER, false);
                curl_setopt($this->_curlObj, CURLOPT_NOBODY, false);
                curl_setopt($this->_curlObj, CURLOPT_POST, true);
                curl_setopt($this->_curlObj, CURLOPT_POSTFIELDS, $this->_bodyContent);
                curl_setopt($this->_curlObj, CURLOPT_RETURNTRANSFER, true);
                break;
            default:
                curl_setopt($this->_curlObj, CURLOPT_HEADER, false);
                curl_setopt($this->_curlObj, CURLOPT_HTTPGET, true);
                curl_setopt($this->_curlObj, CURLOPT_RETURNTRANSFER, true);
        }
    }

    protected function _getRequestParams($params)
    {
        if (empty($params)) {
            return '';
        }
        $this->_bodyContent = $params;
        if (is_array($params)) {
            $this->_bodyContent = http_build_query($params, '', '&');
        }
    }

    protected function _setHeader($baseHeaders)
    {
        $headers = array();
        if (!$baseHeaders) {
            curl_setopt($this->_curlObj, CURLOPT_HEADER, 0);
            return false;
        }
        foreach ($baseHeaders as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        curl_setopt($this->_curlObj, CURLOPT_HEADER, 1);
        curl_setopt($this->_curlObj, CURLOPT_HTTPHEADER, $headers);
    }
}
