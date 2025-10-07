<?php


namespace OTP\Objects;

interface MoITemplate
{
    public function build($iL, $xH, $yS, $b6, $Y9);
    public function parse($iL, $yS, $b6, $Y9);
    public function getDefaults($ie);
    public function showPreview();
    public function savePopup();
    public static function instance();
    public function getTemplateKey();
    public function getTemplateEditorId();
}
