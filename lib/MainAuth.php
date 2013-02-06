<?php
class MainAuth extends BasicAuth {
    function init(){
        parent::init();
        $this->setModel('User');
        $this->usePasswordEncryption('sha256/salt');
    }
}
