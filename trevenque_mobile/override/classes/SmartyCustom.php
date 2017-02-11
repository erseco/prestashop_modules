<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class SmartyCustom extends SmartyCustomCore
{
    public  $is_mobile=false;
    public  $is_tablet=false;
    public  $is_desktop = true;

    public $template_class = "Trevenque_Smarty_Internal_Template";
    public function __construct()
    {

        parent::__construct();
        $context= Context::getContext();
        $this->is_mobile = $context->isMobile();
        $this->is_tablet = $context->isTablet();

        if (isset($_GET["mobile"]))
            $this->is_mobile = true;
        //$this->is_mobile = true;

        $this->is_desktop =  !$this->is_mobile && !$this->is_tablet;

    }



}

/**
 * Trevenque_Smarty_Internal_Template
 *  Extends mobile functionality in an easier way 
 *
 * @package trevenque_mobile
 * @author 
 **/
class Trevenque_Smarty_Internal_Template extends Smarty_Internal_Template
{


    public function getSubTemplate($template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $parent_scope)
    {

        if($this->smarty->is_desktop) /*si desktop comportamiento normal*/
            return parent::getSubTemplate($template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $parent_scope);

        $mobile_template= str_replace(_PS_THEME_DIR_, _PS_THEME_MOBILE_DIR_,$template);
        if (!strpos($template, "mobile") && is_file( $mobile_template) )
            return parent::getSubTemplate($mobile_template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $parent_scope);

        return parent::getSubTemplate($template, $cache_id, $compile_id, $caching, $cache_lifetime, $data, $parent_scope);
    }


}

