<?php
/**
 * This file contains Card widget of amazing Theme
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
namespace koolreport\amazing;

use \koolreport\core\Utility;
use \koolreport\core\Widget;


// <?php
// SimpleCard::create(array(
//     "value"=>2000,
//     "title"=>"income",
//     "format"=>array(
//         "value"=>array(
//             "prefix"=>"$"
//         )
//     ),
//     "cssClass"=>array(
//         "card"=>"test-card",
//         "value"=>"test-value",
//         "icon"=>"test-icon",
//         "title"=>"test-title"
//     ),
//     "cssStyle"=>array(
//         "card"=>"test:1",
//         "value"=>"test:1",
//         "icon"=>"test:1",
//         "title"=>"test:1"
//     ),
// ));


/**
 * This file contains Card widget of amazing Theme
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class SimpleCard extends \koolreport\core\Widget
{
    protected $title;
    protected $value;
    protected $valueFormat;
    protected $cssClass;
    protected $cssStyle;
    protected $preset;
    protected $href;


    /**
     * OnInit
     *
     * @return null
     */
    protected function onInit()
    {
        $this->useAutoName("amzcard");
        $this->value = Utility::get($this->params, "value");
        $this->value = $this->processScalar($this->value);
        
        $title = Utility::get($this->params, "title");
        if (is_callable($title) && gettype($title)!="string") {
            $this->title = $title($this->value);
        } else {
            $this->title = $title;
        }
        
        $format = Utility::get($this->params, "format", array());
        $this->valueFormat = Utility::get($format, "value", array());

        $this->cssStyle = Utility::get($this->params, "cssStyle", array());
        $this->cssClass = Utility::get($this->params, "cssClass", array());
        $this->preset = Utility::get($this->params, "preset");
        if ($this->preset && !in_array($this->preset, array("primary","info","warning","danger","success"))) {
            $this->preset = null;
        }

        $this->href = Utility::get($this->params, "href");
    }
    /**
     * Format value
     *
     * @param mixed $value  The value need to format
     * @param array $format Format will be applied
     *
     * @return string Formatted value
     */
    protected function formatValue($value, $format)
    {
        if (is_callable($format)) {
            return $format($value);
        } else {
            $format["type"] = "number";
            return Utility::format($value, $format);
        }
    }

    /**
     * Return the background color of preset
     * 
     * @return string Background color
     */
    protected function getPresetBackgroundColor($preset=null)
    {
        if (!$preset) {
            $preset = $this->preset;
        }

        $map = array(
            "primary"=>"#36a9e1",
            "info"=>"#67c2ef",
            "warning"=>"#fabb3d",
            "success"=>"#bdea74",
            "danger"=>"#ff5454",
        );
        return isset($map[$preset])?$map[$preset]:"#fff";
    }

    /**
     * Return scalar value from object like query
     * 
     * @param mixed $value The value which may be type of float or datastore, datasource, process object.
     * 
     * @return float The value in float
     */
    protected function processScalar($value)
    {
        if (gettype($value)=="object") {
            $store = $this->standardizeDataSource($value, array());
            if ($store->count()>0) {
                $row = $store->get(0);
                $keys = array_keys($row);
                if (count($keys)>0) {
                    return $row[$keys[0]];
                }
                return 0;
            }
        }
        return $value;
    }

    /**
     * Return the formatted href
     * 
     * @return string Formatted href
     */
    protected function getHref()
    {
        if ($this->href) {
            $href = trim($this->href);
            if (strpos($href, "function") === 0) {
                return 'onclick="javascript: var __cardclick='.$href.';__cardclick();" ';
            } else {
                return 'onclick="window.location.href=\''.$href.'\';" ';
            }
        }
        return null;
    }
}