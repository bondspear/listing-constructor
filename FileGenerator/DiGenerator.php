<?php
namespace Bondspear\ListingConstructor\FileGenerator;

use Magento\Framework\Xml\Generator;
use Magento\Framework\Xml\Parser;

class DiGenerator
{
    protected $generator;
    protected $parser;
    protected static $diFile;
    protected static $diFileTMP;
    protected static $diContentToCreate = [];

    const HEADER_PART = '<?xml version="1.0"?>';
    const HEADER_PART_TWO = '<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">';

    public function __construct(Generator $generator, Parser $parser)
    {
        $this->parser = $parser;
        $this->generator = $generator;
    }

    public function generate($settings)
    {
        self::$diFile = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/etc/di.xml';
        self::$diFileTMP = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/Bondspear/ListingConstructor/Tmp/di.xml';
        self::$diContentToCreate = [
            "config" => [
                "_value" => [
                    [
                        "virtualType" => [
                                "_value" => [
                                    "arguments" => [
                                        "_value" => [
                                            ["argument" => [
                                                "_value" => $this->getTableName($settings),
                                                "_attribute" => [
                                                    "name" => "mainTable",
                                                    "xsi:type" => "string"
                                                ]
                                            ]],
                                            ["argument" => [
                                                "_value" => $this->getVendorModelName($settings) . $settings['listingCollection'],
                                                "_attribute" => [
                                                    "name" => "resourceModel",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                            ]],
                                        "_attribute" => []
                                    ]
                                ],
                                "_attribute" => [
                                    "name" => $this->getModelName($settings) . "Collection",
                                    "type" => "Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult"
                                ]
                        ]
                    ],
                    [
                        "type" => [
                                "_value" => [
                                    "arguments" => [
                                        "_value" => [
                                            [
                                                "argument" => [
                                                    "_value" => [
                                                        "item" => [
                                                            "_value" => $this->getModelName($settings) . "Collection",
                                                            "_attribute" => [
                                                                "name" => $this->getFileName($settings) . "_listing_data_source",
                                                                "xsi:type" => "string"
                                                            ]
                                                        ]
                                                    ],
                                                    "_attribute" => [
                                                        "name" => "collections",
                                                        "xsi:type" => "array"
                                                    ]
                                                ]
                                            ]
                                        ],
                                        "_attribute" => []
                                    ]
                                ],
                                "_attribute" => [
                                    "name" => "Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory"
                                ]
                        ]
                    ]
                ],
                "_attribute" => [
                    "xmlns:xsi"  => "http://www.w3.org/2001/XMLSchema-instance",
                    "xsi:noNamespaceSchemaLocation" =>"urn:magento:framework:ObjectManager/etc/config.xsd"
                ]
            ]
        ];

        if ($this->diExist()) {
            $this->updateDi();
        } else {
            $this->createDi(self::$diFile);
        }
    }

    public function updateDi()
    {
        $this->createDi(self::$diFileTMP);
        shell_exec("chmod -R 777 " . self::$diFileTMP);
        $insertContext = trim(str_replace([self::HEADER_PART_TWO,self::HEADER_PART], '', file_get_contents(self::$diFileTMP)));
        if (!stristr(file_get_contents(self::$diFile), $insertContext)) {
            $content = str_replace('</config>', $insertContext, file_get_contents(self::$diFile));
            file_put_contents(self::$diFile, $content);
        }
        shell_exec("rm " . self::$diFileTMP);
    }

    public function createDi($path)
    {
        $this->generator->arrayToXml(self::$diContentToCreate)->save($path);
        shell_exec("chmod -R 777 " . self::$diFile);
    }

    public function diExist()
    {
        if (is_file(self::$diFile)) {
            return true;
        }
        return false;
    }

    public function getTableName($settings)
    {
        $parts = explode('@', $settings['listingDb']);
        return $parts[0];
    }

    public function getModelName($settings)
    {
        return str_replace('\Model\\', '', $settings['listingModel']);
    }

    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getFileName($settings)
    {
        return strtolower($settings['listingModule']) . '_' . strtolower($this->getModelName($settings));
    }
}
