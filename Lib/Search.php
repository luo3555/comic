<?php
namespace Lib;

class Search extends \Lib\Object
{
    /**
     * GET FROM config.php
     */
    const SEARCH_URL = '';

    protected $_response;

    public function setFields($field)
    {
        if ($this->hasData('fields')) {
            $fields = $this->getFields();
            if (is_array($field)) {
                foreach ($field as $idx => $val) {
                    $fields[] = sprintf('fl=%s', $val);
                }
            } else {
                $fields[] = sprintf('fl=%s', $field);
            }
            $this->setData('fields', $fields);
        } else {
            $fields = [];
            if (is_array($field)) {
                foreach ($field as $idx => $val) {
                    $fields[] = sprintf('fl=%s', $val);
                }
            } else {
                $fields[] = sprintf('fl=%s', $field);
            }
            $this->setData('fields', $fields);
        }
        return $this;
    }

    public function setFilter($field, $value)
    {
        $filter = sprintf('fq=%s:%s', $field, $value);
        if ($this->hasData('filter')) {
            $_filter = $this->getFilter();
            $_filter[] = $filter;
            $this->setData('filter', $_filter);
        } else {
            $this->setData('filter',[$filter]);
        }
        return $this;
    }

    public function execute()
    {
        $conditions = [];
        // Fields
        if (!empty($this->getFields())) {
            $conditions[] = implode('&', $this->getFields());
        }
        // Where
        if (!empty($this->getFilter())) {
            $conditions[] = implode('&', $this->getFilter());
        }
        // rows
        if (!empty($this->getRows())) {
            $conditions[] = 'rows:' . $this->getRows();
        }
        // start
        if (!empty($this->getStart())) {
            $conditions[] = 'start:' . $this->getStart();
        }
        // q
        if (!empty($this->getQ())) {
            $conditions[] = sprintf('q=%s', $this->getQ());
        } else {
            $conditions[] = 'q=*:*';
        }

        $requestUrl = SEARCH_URL;

        if (!empty($conditions)) {
            $requestUrl .= implode('&', $conditions);
        }

        $this->_curl($requestUrl);
    }

    public function getResponse($key=null)
    {
        if (!is_null($key)) {
            return $this->_response[$key];
        }
        return $this->_response;
    }

    protected function _curl($requestUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
        if ($status['http_code']==200) {
            $response = json_decode($response, true);
            $this->_response = $response['response'];
        }
        return $this;
    }
}