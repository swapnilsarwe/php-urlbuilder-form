<?php

class UrlBuilder
{

    private static $instance;

    private $queryParams;

    private $arrUrlParams;

    private $defaultUrl;

    private $finalUrl;

    public function __construct ()
    {
    }

    private function __clone ()
    {
        // do nothing (this overwrites the special PHP method __clone())
    }

    public static function Create ()
    {
        if (! (self::$instance instanceof self))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function processRequest ($action = '')
    {
        print_r($action);
        switch ($action)
        {
            case 'generateUrl':
                $this->generateUrl();
                $this->loadView('page');
            case 'showform':
                $this->loadView('form');
            default:
                $this->loadView('page');
        }
    }

    private function loadView ($view)
    {
        require_once 'views/' . $view . '.php';
    }

    private function getUrlParams ()
    {
        if (is_null($this->arrUrlParams))
        {
            $this->arrUrlParams = parse_url($this->defaultUrl);
            $this->arrUrlParams['query'] = $this->getQueryParams();
        }
        return $this->arrUrlParams;
    }

    private function getQueryParams ()
    {
        if (is_null($this->queryParams))
        {
            parse_str($this->arrUrlParams['query'], $this->queryParams);
        }
        return $this->queryParams;
    }

    private function buildFields ($arrParams, $keyParent = FALSE)
    {
        $strForm = '<ul>';
        foreach ($arrParams as $key => $val)
        {
            $strForm .= '<li>';
            if (is_array($val) && count($val) > 0)
            {
                $strForm .= $key . '<br />' . $this->buildFields($val, $key);
            }
            else
            {
                if ($keyParent)
                {
                    $fieldName = 'txtUrlBuilder[' . $keyParent . '][' . $key . ']';
                }
                else
                {
                    $fieldName = 'txtUrlBuilder[' . $key . ']';
                }
                $strForm .= '<label for="txt' . $key . '">' . $key . ':</label> <input type="text" name="' . $fieldName .
                         '" id="txt' . $key . '" value="' . $val . '" />';
            }
            $strForm .= '</li>';
        }
        $strForm .= '</ul>';
        return $strForm;
    }

    private function getDefaultUrl ()
    {
        $this->defaultUrl = '';
        if (isset($_GET['txtUrlToParse']) && trim($_GET['txtUrlToParse']) != '')
        {
            $this->defaultUrl = $_GET['txtUrlToParse'];
        }
        return $this->defaultUrl;
    }

    private function getUrlBox ()
    {
        return '<input type="text" name="txtUrlToParse" id="txtUrlToParse" value="' . $this->getFinalUrl() . '" />
                <input type="hidden" name="action" value="generateUrl" />';
    }

    public function printForm ()
    {
        $strHTML = '';
        
        $strHTML .= $this->getUrlBox();
        if ($this->getDefaultUrl())
        {
            $arrParams = $this->getUrlParams();
            $strHTML .= $this->buildFields($arrParams);
        }
        
        return $strHTML;
    }

    public function generateUrl ()
    {
        if (is_null($this->finalUrl))
        {
            if (isset($_GET['txtUrlBuilder']) && count($_GET['txtUrlBuilder']) > 0)
            {
                foreach ($_GET['txtUrlBuilder'] as $k => $v)
                {
                    if ($k == 'query')
                    {
                        $v = http_build_query($v);
                    }
                    $this->arrUrlParams[$k] = $v;
                }
                $this->queryParams = $this->arrUrlParams['query'];
                $this->arrUrlParams = $this->arrUrlParams;
                $this->finalUrl = http_build_url($this->defaultUrl, $this->arrUrlParams);
            }
        }
    }

    public function getFinalUrl ()
    {
        if (is_null($this->finalUrl))
        {
            $this->generateUrl();
        }
        return $this->finalUrl;
    }
}

?>