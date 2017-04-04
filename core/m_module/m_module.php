<?php
namespace core\m_module;

class m_module {
    public $tmp_header;
    public $tmp_footer;
    public $module_name;

    public function __construct($name)
    {
        $this->module_name = $name;
    }
}