<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Core\Configure;

class CrowleyComponent extends Component
{
    protected $_defaultConfig = [];
    
    private $dom;
    private $class;
    private $platforms;

    public  $xpath;
    public  $link;
    public  $html;

    public function initialize(array $config)
    {
    	parent::initialize($config);
    }

    public function __setup($html) {
        $this->html = $html;

        $this->dom = new \DOMDocument();

        libxml_use_internal_errors(true);
        $this->dom->loadHTML($this->html);
        libxml_use_internal_errors(false);

        $this->xpath = new \DOMXPath($this->dom);
    }

    public function getGenericAttribute($attr_name, $tmp_xpath, $format = '', $first = true) {
        $attribute = "";
        
        if(!empty($attr_name)) {
            $tmp_attr = $tmp_xpath->query($this->makeQuery($attr_name));


            if(!$first) {
                $attribute = $tmp_attr;
            }else {
                if(!empty($tmp_attr[0]->nodeValue))
                    $attribute = $this->cleanString($tmp_attr[0]->nodeValue);
            }

            $attribute = empty($format) ? $attribute : $this->class->$format($attribute);
        }

        return $attribute;

    }

    private function makeQuery($attr_name) {
        $attr_name = preg_replace('/\s+/', '', $attr_name);
        $query = "//";

        $inceptions = explode(">", $attr_name);
        foreach ($inceptions as $key => $inception) {   
            $selector = $this->selector($inception);
            
            if(!empty($selector)) {
                $info = explode($selector['identifier'], $inception);
                $selector = "[contains(@{$selector['type']}, \"{$info[1]}\")]";
            }else {
                $info[0] = $inception;
                $selector = "";
            }

            if($key > 0) 
                $query .= "/descendant::";
            
            $query .= "{$info[0]}{$selector}";
        }

        return $query;
    }

    private function selector($attr_name = ".") {

        $selector = [];

        if(strpos($attr_name, "#") !== false)
            $selector = [ 'type' => 'id', 'identifier' => '#' ];

        if(strpos($attr_name, "%") !== false)
            $selector = [ 'type' => 'itemprop', 'identifier' => '%' ];

        if(strpos($attr_name, ".") !== false)
            $selector = [ 'type' => 'class', 'identifier' => '.' ];

        return $selector;
    }

    private function cleanString($string) {
        return preg_replace('/\t+/', '', preg_replace( "/\r|\n/", "", strip_tags(trim($string))));
    }


   
    
}