<?php


namespace OTP;

if (defined("\101\102\x53\120\x41\x54\x48")) {
    goto Cx;
}
die;
Cx:
final class SplClassLoader
{
    private $_fileExtension = "\x2e\160\150\160";
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = "\x5c";
    public function __construct($IN = null, $My = null)
    {
        $this->_namespace = $IN;
        $this->_includePath = $My;
    }
    public function register()
    {
        spl_autoload_register(array($this, "\x6c\x6f\141\x64\103\154\x61\163\163"));
    }
    public function unregister()
    {
        spl_autoload_unregister(array($this, "\154\157\141\x64\x43\x6c\x61\163\x73"));
    }
    public function loadClass($e_)
    {
        if (!(null === $this->_namespace || $this->isSameNamespace($e_))) {
            goto OY;
        }
        $C7 = '';
        $TE = '';
        if (!(false !== ($kB = strripos($e_, $this->_namespaceSeparator)))) {
            goto Ho;
        }
        $TE = strtolower(substr($e_, 0, $kB));
        $e_ = substr($e_, $kB + 1);
        $C7 = str_replace($this->_namespaceSeparator, DIRECTORY_SEPARATOR, $TE) . DIRECTORY_SEPARATOR;
        Ho:
        $C7 .= str_replace("\x5f", DIRECTORY_SEPARATOR, $e_) . $this->_fileExtension;
        $C7 = str_replace("\157\x74\x70", MOV_NAME, $C7);
        require ($this->_includePath !== null ? $this->_includePath . DIRECTORY_SEPARATOR : '') . $C7;
        OY:
    }
    private function isSameNamespace($e_)
    {
        return $this->_namespace . $this->_namespaceSeparator === substr($e_, 0, strlen($this->_namespace . $this->_namespaceSeparator));
    }
}
