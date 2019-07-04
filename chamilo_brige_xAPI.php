<?php
/* For licensing terms, see /license.txt */

class chamilo_brige_xAPI extends Plugin
{
    protected function __construct()
    {
        parent::__construct(
            '1.0',
            'Damien Renou',
            array(
                'enable_plugin_chamilo_brige_xAPI' => 'boolean'
            )
        );
    }
	
    // @return chamilo_brige_xAPI |null
    public static function create()
    {
        static $result = null;
        return $result ? $result : $result = new self();
    }
	
    public function install()
	{

    }
	
    public function uninstall()
    {

    }
}
