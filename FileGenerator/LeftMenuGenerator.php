<?php
namespace Bondspear\ListingConstructor\FileGenerator;

use Magento\Framework\Xml\Generator;
use Magento\Framework\Xml\Parser;

class LeftMenuGenerator
{
    protected $generator;
    protected $parser;
    protected static $menuFile;
    protected static $menuFileTMP;
    protected static $menuContentToCreate = [];

    const HEADER_PART = '<?xml version="1.0"?>';
    const HEADER_PART_TWO = '<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Backend:etc/menu.xsd">';
    const MENU_OPEN = '<menu>';
    const MENU_CLOSED = '</menu>';
    const CONFIG_CLOSED = '</config>';

    public function __construct(Generator $generator, Parser $parser)
    {
        $this->parser = $parser;
        $this->generator = $generator;
    }

    public function generate($settings)
    {
        $adminFolder = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/etc/adminhtml";
        self::$menuFile = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/etc/adminhtml/menu.xml';
        self::$menuFileTMP = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/Bondspear/ListingConstructor/Tmp/menu.xml';
        self::$menuContentToCreate = [
            "config" => [
                "_value" => [
                    "menu" => [
                        "_value" => [
                            ["add" => [
                                "_value" => [],
                                "_attribute" => [
                                    "id" => $this->getVendorModelName($settings) . "LeftMenu",
                                    "title" => $this->getModuleName($settings),
                                    "module"  => $this->getVendorModelName($settings),
                                    "sortOrder" =>"20",
                                    "resource" => "Magento_Backend::system"
                                ]
                            ]],
                            ["add" => [
                                "_value" => [],
                                "_attribute" => [
                                    "id" => $this->getVendorModelName($settings) . "LeftMenuListing",
                                    "title" => "LeftMenuListing",
                                    "module"  => $this->getVendorModelName($settings),
                                    "sortOrder" =>"20",
                                    "resource" => "Magento_Backend::system",
                                    "parent" => $this->getVendorModelName($settings) . "LeftMenu",
                                    "action" => strtolower($this->getVendorModelName($settings)) . "/".$this->getModelName($settings)."/index"
                                ]
                            ]
                            ]],
                        "_attribute" => []
                    ]
                ],
                "_attribute" => [
                    "xmlns:xsi"  => "http://www.w3.org/2001/XMLSchema-instance",
                    "xsi:noNamespaceSchemaLocation" =>"urn:magento:module:Magento_Backend:etc/menu.xsd"
                ]
            ]
        ];

        if (!is_dir($adminFolder)) {
            mkdir($adminFolder, 0777);
            shell_exec("chmod -R 777 " . $adminFolder);
        }

        if ($this->menuExist()) {
            $this->updateMenu();
        } else {
            $this->createMenu(self::$menuFile);
        }
    }

    public function getVendorModelName($settings)
    {
        return $settings['listingModule'];
    }

    public function getModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }

    public function menuExist()
    {
        if (is_file(self::$menuFile)) {
            return true;
        }
        return false;
    }

    public function updateMenu()
    {
        $this->createMenu(self::$menuFileTMP);
        shell_exec("chmod -R 777 " . self::$menuFileTMP);
        $insertContext = trim(str_replace([self::HEADER_PART_TWO,self::HEADER_PART,self::MENU_OPEN,self::MENU_CLOSED,self::CONFIG_CLOSED], '', file_get_contents(self::$menuFileTMP))) . '</menu></config>';
        if (!stristr(file_get_contents(self::$menuFile), $insertContext)) {
            $content = str_replace('</menu></config>', $insertContext, file_get_contents(self::$menuFile));
            file_put_contents(self::$menuFile, $content);
        }
        shell_exec("rm " . self::$menuFileTMP);
    }

    public function createMenu($path)
    {
        $this->generator->arrayToXml(self::$menuContentToCreate)->save($path);
        shell_exec("chmod -R 777 " . self::$menuFile);
    }

    public function getModuleName($settings)
    {
        $parts = explode('_', $settings['listingModule']);
        return $parts[1];
    }
}
