<?php
/**                                                                                       
*
*  ██████  ██  ██████  ██████  ██████   ██████  ██   ██ 
*  ██   ██ ██ ██    ██ ██   ██ ██   ██ ██    ██  ██ ██  
*  ██████  ██ ██    ██ ██████  ██████  ██    ██   ███   
*  ██   ██ ██ ██    ██ ██      ██   ██ ██    ██  ██ ██  
*  ██████  ██  ██████  ██      ██   ██  ██████  ██   ██ 
*
*
*
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    BIOPROX <juanfer@bioprox.es>
*  @copyright 2022 BIOPROX LABORATORIOS S.C.A.
*  @license   See above
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Bpxleydecookies extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        //configuracion del modulo
        $this->name = 'bpxleydecookies';
        $this->tab = 'front_office_features';//categoria en el gestor/instalador de modulos del backoffice: Diseño y Navegación
        $this->version = '1.0.0';
        $this->author = 'juanfer@bioprox.es';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('BPX Ley de Cookies');
        $this->description = $this->l('Cumplimiento con la nueva Ley de Cookies Europea, informando al usuario y permitiéndole configurar las cookies usadas en la navegacion.');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        // Preset configuration values
        Configuration::updateValue('BPXLEYDECOOKIES_LIVE_MODE', false);
        Configuration::updateValue('BPXLEYDECOOKIES_TITULO', 'GESTIÓN DE LAS COOKIES');
        Configuration::updateValue('BPXLEYDECOOKIES_MENSAJE', 'Bioprox sólo utiliza las cookies propias estrictamente necesarias para el correcto funcionamiento del sitio web por lo que son necesarias para seguir navegando.  No usamos ningunas cookies de terceros con fines publicitarios.');
        Configuration::updateValue('BPXLEYDECOOKIES_IMAGEN', 0);
        Configuration::updateValue('BPXLEYDECOOKIES_COLOR', '#F9B41E');
       

        // Install tab
		$this->createTabs();

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayFooter');
    }

    public function uninstall()
    {
        // Delete configuration values
        Configuration::deleteByName('BPXLEYDECOOKIES_LIVE_MODE');
        Configuration::deleteByName('BPXLEYDECOOKIES_MENSAJE');
        Configuration::deleteByName('BPXLEYDECOOKIES_TITULO');
        Configuration::deleteByName('BPXLEYDECOOKIES_IMAGEN');
        Configuration::deleteByName('BPXLEYDECOOKIES_COLOR');

        // Delete tab
		$this->deleteTabs();

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitBpxleydecookiesModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBpxleydecookiesModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Configurar Ley de Cookies'),
                'icon' => 'icon-food',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Mostrar Ley de Cookies?'),
                        'name' => 'BPXLEYDECOOKIES_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Mensaje visible en la web.'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('SI')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('NO')
                            )
                        ),
                    ),
                    array(
                        'col' => 8,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-bullhorn"></i>',
                        'desc' => $this->l('Título del mensaje'),
                        'name' => 'BPXLEYDECOOKIES_TITULO',
                        'label' => $this->l('Título'),
                    ),
                    array(
                        'col' => 8,
                        'type' => 'text',
                        'prefix' => '<i class="icon icon-comment-alt"></i>',
                        'desc' => $this->l('Texto del mensaje'),
                        'name' => 'BPXLEYDECOOKIES_MENSAJE',
                        'label' => $this->l('Mensaje'),
                    ),
                    array(
                        'col' => 8,
                        'type' => 'radio',
                        'desc' => $this->l('Mostrar logo de la cookie junto al título'),
                        'name' => 'BPXLEYDECOOKIES_IMAGEN',
                        'label' => $this->l('Imagen'),
                        'values'    => array(    
                            array(
                            'id'    => 'cookie0',                           // The content of the 'id' attribute of the <input> tag, and of the 'for' attribute for the <label> tag.
                            'value' => 0,                                     // The content of the 'value' attribute of the <input> tag.	
                            'label' =>'sin imagen'                    // The <label> for this radio button.
                            ),                             // $values contains the data itself.
                            array(
                            'id'    => 'cookie1',                           // The content of the 'id' attribute of the <input> tag, and of the 'for' attribute for the <label> tag.
                            'value' => 1,                                     // The content of the 'value' attribute of the <input> tag.	
                            'label' =>'<img src="../modules/bpxleydecookies/views/img/cookie1.png" width="40">'                    // The <label> for this radio button.
                            ),
                            array(
                            'id'    => 'cookie2',
                            'value' => 2,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie2.png" width="40">' 
                            ),
                            array(
                            'id'    => 'cookie3',
                            'value' => 3,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie3.png" width="40">' 
                            ),
                            array(
                            'id'    => 'cookie4',
                            'value' => 4,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie4.png" width="40">' 
                            ),
                            array(
                            'id'    => 'cookie5',
                            'value' => 5,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie5.png" width="40">' 
                            ),
                            array(
                            'id'    => 'cookie6',
                            'value' => 6,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie6.png" width="40">' 
                            ),
                            array(
                            'id'    => 'cookie7',
                            'value' => 7,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie7.png" width="40">' 
                            ),
                            array(
                            'id'    => 'cookie8',
                            'value' => 8,
                            'label' => '<img src="../modules/bpxleydecookies/views/img/cookie8.png" width="40">' 
                            ),
                        ),
                    ),
                    array(
                        'col' => 8,
                        'type' => 'color',
                        'desc' => $this->l('Color del tema'),
                        'name' => 'BPXLEYDECOOKIES_COLOR',
                        'value' => '#F9B41E',
                        'id'    => 'color',
                        'label' => $this->l('Color'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Guardar'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'BPXLEYDECOOKIES_LIVE_MODE' => Configuration::get('BPXLEYDECOOKIES_LIVE_MODE', true),
            'BPXLEYDECOOKIES_TITULO' => Configuration::get('BPXLEYDECOOKIES_TITULO', 'TITULO'),
            'BPXLEYDECOOKIES_MENSAJE' => Configuration::get('BPXLEYDECOOKIES_MENSAJE', 'Mensaje.'),
            'BPXLEYDECOOKIES_IMAGEN' => Configuration::get('BPXLEYDECOOKIES_IMAGEN', 0),
            'BPXLEYDECOOKIES_COLOR' => Configuration::get('BPXLEYDECOOKIES_COLOR', '#F9B41E'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    //-----------------------------------------------------
    // HookDisplayFooter: FrontOffice View
    //-----------------------------------------------------
    /**
	 * Hook para enganchar el mensaje de ley de cookies
	 *
	 * @param array $params All existing resources from the core
	 * @return array New resources
	 */
	public function hookDisplayFooter($params)
	{	//comprobamos si en la configuracion del modulo activamos mostrar aviso cookies
		$show_mensaje = Configuration::get('BPXLEYDECOOKIES_LIVE_MODE');
		if($show_mensaje == false){
		 	return;
		}else{//$show_mensaje == true
			//Comprobamos si el susario ya las acepto
			if(!isset($_COOKIE['bpxleydecookies']) OR $_COOKIE['bpxleydecookies']!=true){
				$this->setMensajeLeyCookies();
				return $this->display(__FILE__, 'displayFooter.tpl');
			}/*else{
				//no mostrar mensaje ya esta aceptada la politica de cookies
			}*/
		}

		//dump($params);
		//dump($this->context);
	} 

    public function setMensajeLeyCookies()
	{
		$header = Configuration::get('BPXLEYDECOOKIES_TITULO');
		$mensaje = Configuration::get('BPXLEYDECOOKIES_MENSAJE');
        $imagen = Configuration::get('BPXLEYDECOOKIES_IMAGEN');
        $color = Configuration::get('BPXLEYDECOOKIES_COLOR');

		$this->context->smarty->assign('header', $header);
		$this->context->smarty->assign('mensaje', $mensaje);
        $this->context->smarty->assign('imagen', $imagen);
        $this->context->smarty->assign('color', $color);
	}


    //-------------------------------------------------------
    // TAB: Adding module links in the back-office side menu
    //-------------------------------------------------------
	 /**
     * Create Tabs
     */
    public function createTabs()
	{
		// Tab
        $idTab= Tab::getIdFromClassName('AdminBpxLeyDeCookies');// --> /controllers/admin/AdminBpxLeyDeCookies.php

        if ($idTab) {
            $tab = new Tab($idTab);
            $tab->delete();
        }


		// Tab Menu
        if (!Tab::getIdFromClassName('AdminBPXLABS')) {
            $parent_tab = new Tab();
            $parent_tab->name = array();
            foreach (Language::getLanguages(true) as $lang)
                $parent_tab->name[$lang['id_lang']] = $this->l('BPXLABS');

            $parent_tab->class_name = 'AdminBPXLABS';
            $parent_tab->id_parent = 0;
            $parent_tab->module = $this->name;
            $parent_tab->add();

            $id_full_parent = $parent_tab->id;
        } else {
            $id_full_parent = Tab::getIdFromClassName('AdminBPXLABS');
        }
        
		// Tab Principal Comision Cupon
        $parent = new Tab();
        $parent->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $parent->name[$lang['id_lang']] = $this->l('Ley de Cookies');

        $parent->class_name = 'AdminBpxLeyDeCookies';
        $parent->id_parent = $id_full_parent;
        $parent->module = $this->name;
        $parent->icon = 'cake';
        $parent->add();
	}

	/**
     * Delete Tabs
     */
    public function deleteTabs()
    {
        // Tab
        $idTab= Tab::getIdFromClassName('AdminBpxLeyDeCookies');

        if ($idTab) {
            $tab = new Tab($idTab);
            $tab->delete();
        }
    }
}
