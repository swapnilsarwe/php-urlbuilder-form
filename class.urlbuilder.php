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
        switch ($action)
        {
            case 'generateUrl':
                $this->getDefaultUrl();
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
            $this->arrUrlParams = parse_url($this->getDefaultUrl());
            $this->arrUrlParams['query'] = $this->getQueryParams();
        }
        return $this->arrUrlParams;
    }

    private function getQueryParams ()
    {
        if (is_null($this->queryParams))
        {
            $this->queryParams = array();
            if(isset($this->arrUrlParams['query']))
            {
                parse_str($this->arrUrlParams['query'], $this->queryParams);
            }
        }
        return $this->queryParams;
    }

    private function buildFields ($arrParams, $keyParent = FALSE)
    {
        $strForm = '<ul>';
        foreach ($arrParams as $key => $val)
        {
            $strForm .= '<li>';
            if (is_array($val))
            {
                if(count($val) > 0)
                {
                    $strForm .= $key . '<br />' . $this->buildFields($val, $key);
                }
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
        if (is_null($this->defaultUrl))
        {
            if (isset($_POST['btnBuildUrl']) && isset($_POST['txtUrlBuilder']) && count($_POST['txtUrlBuilder']) > 0)
            {
                foreach ($_POST['txtUrlBuilder'] as $k => $v)
                {
                    if ($k == 'query')
                    {
                        $v = http_build_query($v);
                    }
                    $this->arrUrlParams[$k] = $v;
                }
                $this->arrUrlParams = $this->arrUrlParams;
                $this->defaultUrl = http_build_url($_POST['txtUrlToParse'], $this->arrUrlParams);
                $this->arrUrlParams['query'] = $this->getQueryParams();
            }
            if (isset($_POST['btnSubmitUrl']) && isset($_POST['txtUrlToParse']) && trim($_POST['txtUrlToParse']) != '' && is_null($this->defaultUrl))
            {
                $this->defaultUrl = $_POST['txtUrlToParse'];
            }
        }
        return $this->defaultUrl;
    }

    private function getUrlBox ()
    {
        return '<ul>
                    <li>
                        <label for="txtUrlToParse">Enter Url: </label>
                        <input type="text" name="txtUrlToParse" id="txtUrlToParse" value="' .$this->getDefaultUrl() . '" />
                        <input type="submit" name="btnSubmitUrl" id="btnSubmitUrl" value="Submit Url" />
                    </li>
                </ul>
                <hr />
                <input type="hidden" name="action" value="generateUrl" />';
    }

    public function printForm ()
    {
        $strHTML = '';
        
        $strHTML .= $this->getUrlBox();
        if ($this->getDefaultUrl())
        {
            $arrParams = $this->getUrlParams();
            $strHTML .= '<h4>Edit the fields:</h4>';
            $strHTML .= $this->buildFields($arrParams);
            $strHTML .= '<input type="submit" name="btnBuildUrl" id="btnBuildUrl" value="Build Url" />';
        }
        
        return $strHTML;
    }
}

?>