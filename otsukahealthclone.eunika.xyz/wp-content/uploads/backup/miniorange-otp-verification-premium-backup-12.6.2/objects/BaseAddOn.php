<?php


namespace OTP\Objects;

abstract class BaseAddOn implements AddOnInterface
{
    function __construct()
    {
        $this->initializeHelpers();
        $this->initializeHandlers();
        add_action("\x6d\157\x5f\157\x74\x70\137\x76\145\x72\x69\146\151\x63\x61\x74\x69\157\156\137\141\144\144\x5f\x6f\156\x5f\143\157\156\164\162\157\154\154\145\x72", array($this, "\163\x68\157\x77\137\x61\144\x64\157\x6e\137\x73\145\x74\x74\151\x6e\147\x73\x5f\160\141\x67\145"), 1, 1);
    }
}
