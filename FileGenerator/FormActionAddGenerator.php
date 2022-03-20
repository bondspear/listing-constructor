<?php
namespace Bondspear\ListingConstructor\FileGenerator;

use Magento\Framework\Xml\Generator;
use Magento\Framework\Xml\Parser;

class FormActionAddGenerator
{
    protected $generator;
    protected $parser;
    protected static $formFile;
    protected static $layoutContentToCreate = [];

    public function __construct(Generator $generator, Parser $parser)
    {
        $this->parser = $parser;
        $this->generator = $generator;
    }

    public function generate($settings)
    {
        $blockFolder =  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Block";
        $adminFolder =  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Block/Adminhtml";
        $buttonsFolder =  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Block/Adminhtml/Buttons";
        $uiFolder = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/view/adminhtml/ui_component";
        self::$formFile = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/view/adminhtml/ui_component/' . $this->getFileName($settings) . '_add.xml';
        self::$layoutContentToCreate = [
            "form" => [
                "_value" => [
                    "argument" => [
                        "_value" => [
                            [
                                "item" => [
                                    "_value" => [
                                        [
                                            "item" => [
                                                "_value" => $this->getFileName($settings) . '_add.' . $this->getFileName($settings) . '_add_data_source',
                                                "_attribute" => [
                                                    "name" => "provider",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ],
                                        [
                                            "item" => [
                                                "_value" => $this->getFileName($settings) . '_add.' . $this->getFileName($settings) . '_add_data_source',
                                                "_attribute" => [
                                                    "name" => "deps",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "_attribute" => [
                                        "name" => "js_config",
                                        "xsi:type" => "array"
                                    ]
                                ]
                            ],
                            [
                                "item" => [
                                    "_value" => "Information",
                                    "_attribute" => [
                                        "name" => "label",
                                        "xsi:type" => "string",
                                        "translate" => "true"
                                    ]
                                ]
                            ],
                            [
                                "item" => [
                                    "_value" => [
                                        [
                                            "item" => [
                                                "_value" => "data",
                                                "_attribute" => [
                                                    "name" => "dataScope",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ],
                                        [
                                            "item" => [
                                                "_value" => $this->getFileName($settings) . '_add',
                                                "_attribute" => [
                                                    "name" => "namespace",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "_attribute" => [
                                        "name" => "config",
                                        "xsi:type" => "array"
                                    ]
                                ]
                            ],
                            [
                                "item" => [
                                    "_value" => "templates/form/collapsible",
                                    "_attribute" => [
                                        "name" => "template",
                                        "xsi:type" => "string"
                                    ]
                                ]
                            ],
                            [
                                "item" => [
                                    "_value" => [
                                        [
                                            "item" => [
                                                "_value" => str_replace('_', '\\', $this->getVendorModelName($settings)) . '\\Block\\Adminhtml\\Buttons\\Back',
                                                "_attribute" => [
                                                    "name" => "back",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ],
                                        [
                                            "item" => [
                                                "_value" => str_replace('_', '\\', $this->getVendorModelName($settings)) . '\\Block\\Adminhtml\\Buttons\\Save',
                                                "_attribute" => [
                                                    "name" => "save",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "_attribute" => [
                                        "name" => "buttons",
                                        "xsi:type" => "array"
                                    ]
                                ]
                            ]
                        ],
                        "_attribute" => [
                            "name" => "data",
                            "xsi:type" => "array"
                        ]
                    ],
                    "dataSource" => [
                        "_value" => [
                            "argument" => [
                                "_value" => [
                                    "item" => [
                                        "_value" => [
                                            "item" => [
                                                "_value" => "Magento_Ui/js/form/provider",
                                                "_attribute" => [
                                                    "name" => "component",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ],
                                        "_attribute" => [
                                            "name" => "js_config",
                                            "xsi:type" => "array"
                                        ]
                                    ]
                                ],
                                "_attribute" => [
                                    "name" => "data",
                                    "xsi:type" => "array"
                                ]
                            ],
                            "settings" => [
                                "_value" => [
                                    "submitUrl" => [
                                        "_value" => [],
                                        "_attribute" => [
                                            "path" => $this->getActionName($settings)
                                        ]
                                    ]
                                ],
                                "_attribute" => []
                            ],
                            "dataProvider" => [
                                "_value" => [
                                    "settings" => [
                                        "_value" => [
                                            "requestFieldName" => [
                                                "_value" => $this->getId($settings),
                                                "_attribute" => []
                                            ],
                                            "primaryFieldName" => [
                                                "_value" => $this->getId($settings),
                                                "_attribute" => []
                                            ],
                                        ],
                                        "_attribute" => []
                                    ]
                                ],
                                "_attribute" => [
                                    "class" => str_replace('_', '\\', $settings['listingModule']) . "\Ui\DataProvider\Listing\ItemDataProvider",
                                    "name" => $this->getFileName($settings) . "_add_data_source"
                                ]
                            ]
                        ],
                        "_attribute" => [
                            "name" => $this->getFileName($settings) . "_add_data_source"
                        ]
                    ],
                    "fieldset" => [
                        "_value" => $this->getFieldSet($settings),
                        "_attribute" => [
                            "name" => $this->getFileName($settings) . "_add_fieldset",
                            "sortOrder" => "10"
                        ]
                    ]
                ],
                "_attribute" => [
                    "xmlns:xsi"  => "http://www.w3.org/2001/XMLSchema-instance",
                    "xsi:noNamespaceSchemaLocation" =>"urn:magento:module:Magento_Ui:etc/ui_configuration.xsd"
                ]
            ]
        ];

        if (!is_dir($uiFolder)) {
            mkdir($uiFolder, 0777);
            shell_exec("chmod -R 777 " . $uiFolder);
        }
        if (!is_dir($blockFolder)) {
            mkdir($blockFolder, 0777);
            shell_exec("chmod -R 777 " . $blockFolder);
        }
        if (!is_dir($adminFolder)) {
            mkdir($adminFolder, 0777);
            shell_exec("chmod -R 777 " . $adminFolder);
        }
        if (!is_dir($buttonsFolder)) {
            mkdir($buttonsFolder, 0777);
            shell_exec("chmod -R 777 " . $buttonsFolder);
        }

        if ($this->formExist()) {
            $this->updateForm();
        } else {
            $this->createForm(self::$formFile);
        }
    }

    public function getFieldSet($settings)
    {
        $data = [];
        $data[] = [
            "settings" => [
                "_value" => [
                    "collapsible" => [
                        "_value" => "false",
                        "_attribute" => []
                    ],
                    "label" => [
                        "_value" => "FieldSet",
                        "_attribute" => [
                            "translate" => "true"
                        ]
                    ]
                ],
                "_attribute" => []
            ]
        ];

        foreach ($this->getColumns($settings) as $field) {
            $data[] = [
                "field" => [
                    "_value" => [
                        "argument" => [
                            "_value" => [
                                "item" => [
                                    "_value" => [
                                        "item" => [
                                            "_value" => $field,
                                            "_attribute" => [
                                                "name" => "source",
                                                "xsi:type" => "string"
                                            ]
                                        ]
                                    ],
                                    "_attribute" => [
                                        "name" =>"config",
                                        "xsi:type" => "array"
                                    ]
                                ]
                            ],
                            "_attribute" => [
                                "name" => "data",
                                "xsi:type" => "array"
                            ]
                        ],
                        "settings" => [
                            "_value" => [
                                "required" => [
                                    "_value" => "true",
                                    "_attribute" => []
                                ],
                                "validation" => [
                                    "_value" => [
                                        "rule" => [
                                            "_value" => "true",
                                            "_attribute" => [
                                                "name" => "required-entry",
                                                "xsi:type" => "boolean"
                                            ]
                                        ]
                                    ],
                                    "_attribute" => []
                                ],
                                "dataType" => [
                                    "_value" => "string",
                                    "_attribute" => []
                                ],
                                "label" => [
                                    "_value" => $field,
                                    "_attribute" => [
                                        "translate" => "true"
                                    ]
                                ]
                            ],
                            "_attribute" => []
                        ]
                    ],
                    "_attribute" => [
                        "name" => $field,
                        "sortOrder" => "10",
                        "formElement" => "input"
                    ]
                ]
            ];
        }

        return $data;
    }

    public function getVendorModelName($settings)
    {
        return $settings['listingModule'];
    }

    public function formExist()
    {
        if (is_file(self::$formFile)) {
            return true;
        }
        return false;
    }

    public function getModelName($settings)
    {
        return str_replace('\Model\\', '', $settings['listingModel']);
    }

    public function updateForm()
    {
        if (file_exists(self::$formFile)) {
            shell_exec("chmod -R 777 " . self::$formFile);
            shell_exec("rm " . self::$formFile);
            $this->createForm(self::$formFile);
        }
    }

    public function createForm($path)
    {
        $this->generator->arrayToXml(self::$layoutContentToCreate)->save($path);
        shell_exec("chmod -R 777 " . self::$formFile);
    }

    public function getFileName($settings)
    {
        return strtolower($settings['listingModule']) . '_' . strtolower($this->getModelName($settings));
    }

    public function getActionName($settings)
    {
        return strtolower($settings['listingModule']) . '/' . $this->getSmallModelName($settings) . '/update';
    }

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }

    public function getId($settings)
    {
        $parts = explode('@', $settings['listingDb']);
        return $parts[1];
    }

    public function getColumns($settings)
    {
        $parts =  explode(',', $settings['listingColumns']);
        foreach ($parts as $k => $name) {
            if ($name == $this->getId($settings)) {
                unset($parts[$k]);
            }
        }
        return $parts;
    }
}
