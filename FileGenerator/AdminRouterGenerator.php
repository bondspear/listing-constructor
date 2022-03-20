<?php

namespace Bondspear\ListingConstructor\FileGenerator;

use Magento\Framework\Xml\Generator;

class AdminRouterGenerator
{
    protected $generator;
    protected static $layoutContentToCreate = [];

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    public function generate($settings)
    {
        $etc =  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/etc';
        $adminhtml =  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/etc/adminhtml';
        self::$layoutContentToCreate = [
               "config" => [
                   "_value" => [
                       "router" => [
                           "_value" => [
                               "route" => [
                                   "_value" => [
                                       "module" => [
                                           "_value" => [],
                                           "_attribute" => [
                                               "name" => $this->getVendorModelName($settings)
                                           ]
                                       ]
                                   ],
                                   "_attribute" => [
                                       "id" => $this->getSmallVendorModelName($settings),
                                       "frontName" => $this->getSmallVendorModelName($settings)
                                   ]
                               ]
                           ],
                           "_attribute" => [
                               "id" => "admin"
                           ]
                       ]
                   ],
                   "_attribute" => [
                       "xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance",
                       "xsi:noNamespaceSchemaLocation" => "urn:magento:framework:App/etc/routes.xsd"
                   ]
               ]
        ];

        if (!is_dir($etc)) {
            mkdir($etc, 0777);
        }
        if (!is_dir($adminhtml)) {
            mkdir($adminhtml, 0777);
        }

        $this->createRouter($adminhtml . '/routes.xml');
    }

    public function createRouter($path)
    {
        shell_exec("rm ". $path);
        $this->generator->arrayToXml(self::$layoutContentToCreate)->save($path);
        shell_exec("chmod -R 777 " . $path);
    }

    public function getVendorModelName($settings)
    {
        return $settings['listingModule'];
    }

    public function getSmallVendorModelName($settings)
    {
        return strtolower($settings['listingModule']);
    }

}
