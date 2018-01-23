<?php
namespace Junengwan;

/**
 *
 * @author YangLong
 * Date: 2018-01-23
 */
class Junengwan
{

    private $cpId, $cpSecret, $opts = [];

    private $baseUrl = 'http://share.zrpic.com/jnwtv-livecartoon-api/cp/';

    public function setCpId($cpId)
    {
        $this->cpId = $cpId;
    }

    public function setCpSecret($cpSecret)
    {
        $this->cpSecret = $cpSecret;
    }

    public function setCurlOpt(array $opts)
    {
        $this->opts = $opts;
    }

    public function cartooninfolist()
    {
        $url = $this->getApiName(__METHOD__);
        return $this->doQuery($url);
    }

    public function chapterinfolist($plcId)
    {
        $url = $this->getApiName(__METHOD__);
        $data = [
            'plcId' => $plcId
        ];
        return $this->doQuery($url, $data);
    }

    public function pageinfolist($plcId, $lcId)
    {
        $url = $this->getApiName(__METHOD__);
        $data = [
            'plcId' => $plcId,
            'lcId' => $lcId
        ];
        return $this->doQuery($url, $data);
    }

    private function getApiName($method)
    {
        $method = explode('::', $method);
        return array_pop($method);
    }

    private function doQuery($url, $data = [])
    {
        if ($this->baseUrl) {
            $url = $this->baseUrl . $url;
        }
        $data = array_merge([
            'cpId' => $this->cpId,
            'cpSecret' => $this->cpSecret
        ], $data);
        $data['sign'] = $this->getSign($data);
        unset($data['cpSecret']);
        $url = $url . '?' . http_build_query($data);
        return $this->_doQuery($url);
    }

    public function getSign($data)
    {
        return md5(implode('', $data));
    }

    private function _doQuery($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        foreach ($this->opts as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        $json_data = curl_exec($ch);
        if (curl_error($ch) != "") {
            return curl_error($ch);
        }
        $result = json_decode($json_data);
        return $result;
    }
}
