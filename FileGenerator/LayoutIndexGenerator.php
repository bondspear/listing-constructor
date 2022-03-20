<?php
namespace Bondspear\ListingConstructor\FileGenerator;

use Magento\Framework\Xml\Generator;
use Magento\Framework\Xml\Parser;

class LayoutIndexGenerator
{
    protected $generator;
    protected $parser;
    protected static $layoutFile;
    protected static $layoutFileTMP;
    protected static $layoutContentToCreate = [];

    const HEADER_PART = '<?xml version="1.0"?>';
    const CONTAINER1 = '<referenceContainer name="content">';
    const CONTAINER2 = '</page>';
    const CONTAINER3 = '</referenceContainer>';
    const CONTAINER4 = '</body>';
    const HEADER_PART_TWO = '<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">';
    const BODY_OPEN = '<body>';
    const BODY_CLOSED = '</body>';
    const PAGE_OPEN = '<page>';
    const PAGE_CLOSED = '</page>';

    public function __construct(Generator $generator, Parser $parser)
    {
        $this->parser = $parser;
        $this->generator = $generator;
    }

    public function generate($settings)
    {
        self::$layoutFileTMP = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/Bondspear/ListingConstructor/Tmp/layout.xml';
        $viewFolder = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/view";
        $viewAdminhtmlFolder = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/view/adminhtml";
        $viewAdminhtmlLayoutFolder = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/view/adminhtml/layout";
        self::$layoutFile = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/view/adminhtml/layout/' . strtolower($this->getVendorModelName($settings)) . '_' . $this->getSmallModelName($settings) . '_index.xml';
        self::$layoutContentToCreate = [
            "page" => [
                "_value" => [
                    "body" => [
                        "_value" => [
                            "referenceContainer" => [
                                "_value" => [
                                    "uiComponent" => [
                                        "_value" => [],
                                        "_attribute" => [
                                            "name" => strtolower($this->getVendorModelName($settings)) . "_" . strtolower($this->getModelName($settings)) . "_listing"
                                        ]
                                    ]
                                ],
                                "_attribute" => [
                                    "name" => "content"
                                ]
                            ]],
                        "_attribute" => []
                    ]
                ],
                    "_attribute" => [
                            "xmlns:xsi"  => "http://www.w3.org/2001/XMLSchema-instance",
                            "xsi:noNamespaceSchemaLocation" =>"urn:magento:framework:View/Layout/etc/page_configuration.xsd"
                        ]
                    ]
        ];

        if (!is_dir($viewFolder)) {
            mkdir($viewFolder, 0777);
            shell_exec("chmod -R 777 " . $viewFolder);
        }
        if (!is_dir($viewAdminhtmlFolder)) {
            mkdir($viewAdminhtmlFolder, 0777);
            shell_exec("chmod -R 777 " . $viewAdminhtmlFolder);
        }
        if (!is_dir($viewAdminhtmlLayoutFolder)) {
            mkdir($viewAdminhtmlLayoutFolder, 0777);
            shell_exec("chmod -R 777 " . $viewAdminhtmlLayoutFolder);
        }

        if ($this->layoutExist()) {
            $this->updateLayout();
        } else {
            $this->createLayout(self::$layoutFile);
        }
    }

    public function getVendorModelName($settings)
    {
        return $settings['listingModule'];
    }

    public function layoutExist()
    {
        if (is_file(self::$layoutFile)) {
            return true;
        }
        return false;
    }

    public function getModelName($settings)
    {
        return str_replace('\Model\\', '', $settings['listingModel']);
    }

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }

    public function updateLayout()
    {
        $this->createLayout(self::$layoutFileTMP);
        shell_exec("chmod -R 777 " . self::$layoutFileTMP);
        $insertContext = trim(str_replace([
                self::HEADER_PART_TWO,
                self::HEADER_PART,
                self::BODY_OPEN,
                self::BODY_CLOSED,
                self::PAGE_OPEN,
                self::PAGE_CLOSED,
                self::CONTAINER1,
                self::CONTAINER2,
                self::CONTAINER3,
                self::CONTAINER4
            ], '', file_get_contents(self::$layoutFileTMP)));
        if (!stristr(file_get_contents(self::$layoutFile), $insertContext)) {
            $content = str_replace('</referenceContainer>', $insertContext . '</referenceContainer>', file_get_contents(self::$layoutFile));
            file_put_contents(self::$layoutFile, $content);
        }
        shell_exec("rm " . self::$layoutFileTMP);
    }

    public function createLayout($path)
    {
        $this->generator->arrayToXml(self::$layoutContentToCreate)->save($path);
        shell_exec("chmod -R 777 " . self::$layoutFile);
    }
}
