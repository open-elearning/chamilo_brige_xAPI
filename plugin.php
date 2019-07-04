<?php

/**
 * This script is a configuration file for the add_this plugin.
 * These settings will be used in the administration interface for plugins
 * (Chamilo configuration settings->Plugins)
 * @package chamilo.plugin chamilo_brige_xAPI
 * @author Damien Renou <renou.damien@live.fr>
*/
 
/* Plugin config */

require_once __DIR__.'/../../main/inc/global.inc.php';

$varUrl = __DIR__.'/chamilo_brige_xAPI.php';

require_once($varUrl);
$plugin_info = chamilo_brige_xAPI::create()->get_info();

require_once("inc/fonctions.php");

// The plugin title
$plugin_info['title'] = 'chamilo_brige_xAPI';
// The comments that go with the plugin
$plugin_info['comment'] = "chamilo_brige_xAPI (content top)";
// The plugin version
$plugin_info['version'] = '1.0';
// The plugin author
$plugin_info['author'] = 'Damien Renou';

// The plugin configuration
$form = new FormValidator('form');

$defaults = array();

$aid = api_get_current_access_url_id();
$defaults['urlinterface'] = api_get_plugin_chamilo_bridge_access_url('chamilo_brige_xAPI', 'urlinterface',$aid);

$form->addElement('header',"Conditions d'affichage");
$options = array('tile' => 'tile');

$autocomplete2 = $form->addElement('text', 'urlinterface'.$aid, 'Url du site :');
$autocomplete2->setValue($defaults['urlinterface']);

//Save
$form->addButtonSave(get_lang('Save'));

// Get default value for form
$plugin_info['settings_form'] = $form;

//set the templates that are going to be used
$plugin_info['templates'] = array('inc/template.tpl');
