<?php
namespace Bondspear\ListingConstructor\FileGenerator;

use Magento\Framework\Xml\Generator;
use Magento\Framework\Xml\Parser;

class ListingIndexGenerator
{
    protected $generator;
    protected $parser;
    protected static $listingFile;
    protected static $layoutContentToCreate = [];

    public function __construct(Generator $generator, Parser $parser)
    {
        $this->parser = $parser;
        $this->generator = $generator;
    }

    public function generate($settings)
    {
        self::$listingFile = str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . '/view/adminhtml/ui_component/' . $this->getFileName($settings) . '_listing.xml';
        self::$layoutContentToCreate = [
            "listing" => [
                "_value" => [
                    "argument" => [
                        "_value" => [
                            [
                                "item" => [
                                    "_value" => [
                                        [
                                            "item" => [
                                                "_value" => $this->getFileName($settings) . '_listing.' . $this->getFileName($settings) . '_listing_data_source',
                                                "_attribute" => [
                                                    "name" => "provider",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ],
                                        [
                                            "item" => [
                                                "_value" => $this->getFileName($settings) . '_listing.' . $this->getFileName($settings) . '_listing_data_source',
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
                                    "_value" => $this->getFileName($settings) . '_columns',
                                    "_attribute" => [
                                        "name" => "spinner",
                                        "xsi:type" => "string"
                                    ]
                                ]
                            ],
                            [
                                "item" => [
                                    "_value" => [
                                        "item" => [
                                            "_value" => str_replace('_','\\',$this->getVendorModelName($settings)) . '\Block\Adminhtml\Buttons\Add',
                                            "_attribute" => [
                                                "name" => "add",
                                                "xsi:type" => "string"
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
                            "settings" => [
                                "_value" => [
                                    "storageConfig" => [
                                        "_value" => [
                                            "param" => [
                                                "_value" => $this->getId($settings),
                                                "_attribute" => [
                                                    "name" =>"indexField",
                                                    "xsi:type" => "string"
                                                ]
                                            ]
                                        ],
                                        "_attribute" => []
                                    ],
                                    "updateUrl" => [
                                        "_value" => [],
                                        "_attribute" => [
                                            "path" => "mui/index/render"
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
                                    "class" => str_replace('_', '\\', $settings['listingModule']) . "\Ui\DataProvider\Listing\CollectionDataProvider",
                                    "name" => $this->getFileName($settings) . "_listing_data_source"
                                ]
                            ]
                        ],
                        "_attribute" => [
                            "component" => "Magento_Ui/js/grid/provider",
                            "name" => $this->getFileName($settings) . "_listing_data_source"
                        ]
                    ],
                    "listingToolbar" => [
                        "_value" => [
                            "settings" => [
                                "_value" => [
                                    "sticky" => [
                                        "_value" => "true",
                                        "_attribute" => []
                                    ]
                                ],
                                "_attribute" => []
                            ],
                            "columnsControls" => [
                                "_value" => [],
                                "_attribute" => [
                                    "name" => "columns_controls"
                                ]
                            ],
                            "paging" => [
                                "_value" => [],
                                "_attribute" => [
                                    "name" => "listing_paging"
                                ]
                            ],
                            "filters" => [
                                "_value" => [
                                    "filterSelect" => [
                                        "_value" => [
                                            "settings" => [
                                                "_value" => [
                                                    "options" => [
                                                        "_value" => [],
                                                        "_attribute" => [
                                                            "class" => "Magento\Store\Ui\Component\Listing\Column\Store\Options"
                                                        ]
                                                    ],
                                                    "caption" => [
                                                        "_value" => "All Store Views",
                                                        "_attribute" => [
                                                            "translate" => "true"
                                                        ]
                                                    ],
                                                    "label" => [
                                                        "_value" => "Store View",
                                                        "_attribute" => [
                                                            "translate" => "true"
                                                        ]
                                                    ],
                                                    "dataScope" => [
                                                        "_value" => "store_id",
                                                        "_attribute" => []
                                                    ]
                                                ],
                                                "_attribute" => []
                                            ]
                                        ],
                                        "_attribute" => [
                                            "name" => "store_id",
                                            "provider" => '${ $.parentName }'
                                        ]
                                    ]
                                ],
                                "_attribute" => [
                                    "name" => "listing_filters"
                                ]
                            ],
                            "massaction" => [
                                "_value" => [
                                    "action" => [
                                        "_value" => [
                                            "settings" => [
                                                "_value" => [
                                                    "confirm" => [
                                                        "_value" => [
                                                            "message" => [
                                                                "_value" => "Delete selected items?",
                                                                "_attribute" => [
                                                                    "translate" => "true"
                                                                ]
                                                            ],
                                                            "title" => [
                                                                "_value" => "Delete items",
                                                                "_attribute" => [
                                                                    "translate" => "true"
                                                                ]
                                                            ]
                                                        ],
                                                        "_attribute" => []
                                                    ],
                                                    "url" => [
                                                        "_value" => [],
                                                        "_attribute" => [
                                                            "path" => $this->getMassDeleteActionName($settings)
                                                        ]
                                                    ],
                                                    "type" => [
                                                        "_value" => "delete",
                                                        "_attribute" => []
                                                    ],
                                                    "label" => [
                                                        "_value" => "Delete",
                                                        "_attribute" => [
                                                            "translate" => "true"
                                                        ]
                                                    ]
                                                ],
                                                "_attribute" => []
                                            ]
                                        ],
                                        "_attribute" => [
                                            "name" => "delete"
                                        ]
                                    ]
                                ],
                                "_attribute" => [
                                    "name" => "listing_massaction",
                                    "component" => "Magento_Ui/js/grid/tree-massactions",
                                    "class" => "\\" . str_replace('_', '\\', $this->getVendorModelName($settings)) . "\Ui\Component\\".$this->getModelName($settings)."\MassAction"
                                ]
                            ],
                        ],
                        "_attribute" => [
                            "name" => $this->getFileName($settings) . "_top"
                        ]
                    ],
                    "columns" => [
                        "_value" => $this->getColumns($settings),
                        "_attribute" => [
                            "name" => $this->getFileName($settings) . "_columns"
                        ]
                    ],
                ],
                "_attribute" => [
                    "xmlns:xsi"  => "http://www.w3.org/2001/XMLSchema-instance",
                    "xsi:noNamespaceSchemaLocation" =>"urn:magento:module:Magento_Ui:etc/ui_configuration.xsd"
                ]
            ]
        ];

        if ($this->formExist()) {
            $this->updateForm();
        } else {
            $this->createForm(self::$listingFile);
        }
    }

    public function getVendorModelName($settings)
    {
        return $settings['listingModule'];
    }

    public function formExist()
    {
        if (is_file(self::$listingFile)) {
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
        if (file_exists(self::$listingFile)) {
            shell_exec("chmod -R 777 " . self::$listingFile);
            shell_exec("rm " . self::$listingFile);
            $this->createForm(self::$listingFile);
        }
    }

    public function createForm($path)
    {
        $this->generator->arrayToXml(self::$layoutContentToCreate)->save($path);
        shell_exec("chmod -R 777 " . self::$listingFile);
    }

    public function getFileName($settings)
    {
        return strtolower($settings['listingModule']) . '_' . strtolower($this->getModelName($settings));
    }

    public function getActionName($settings)
    {
        return strtolower($settings['listingModule']) . '/'.$this->getSmallModelName($settings).'/edit';
    }

    public function getAddActionName($settings)
    {
        return strtolower($settings['listingModule']) . '/'.$this->getSmallModelName($settings).'/add';
    }

    public function getMassDeleteActionName($settings)
    {
        return strtolower($settings['listingModule']) . '/'.$this->getSmallModelName($settings).'/massdelete';
    }

    public function getId($settings)
    {
        $parts = explode('@', $settings['listingDb']);
        return $parts[1];
    }

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }

    public function getColumns($settings)
    {
        $parts = explode(',', $settings['listingColumns']);

        foreach ($parts as $part) {
            $i  = 0;
            if ($this->getId($settings) == $part) {
                unset($parts[$i]);
            }

            $i++;
        }

        $result = [];

        $result["columns"][] = ["selectionsColumn" => [
            "_value" => [
                "settings" => [
                    "_value" => [
                        "indexField" => [
                            "_value" => $this->getId($settings),
                            "_attribute" => []
                        ]
                    ],
                    "_attribute" => []
                ]
            ],
            "_attribute" => [
                "name" => "ids",
                "sortOrder" => "0"
            ]
        ]];
        $result["columns"][] = [
            "column" => [
                "_value" => [
                    "settings" => [
                        "_value" => [
                            "filter" => [
                                "_value" => "textRange",
                                "_attribute" => []
                            ],
                            "label" => [
                                "_value" => $this->getId($settings),
                                "_attribute" => [
                                    "translate" => "true"
                                ]
                            ],
                            "resizeDefaultWidth" => [
                                "_value" => 25,
                                "_attribute" => []
                            ]
                        ],
                        "_attribute" => []
                    ]
                ],
                "_attribute" => [
                    "name" => $this->getId($settings)
                ]
            ]
        ];

        foreach ($parts as $column) {
            $result["columns"][] = [
                "column" => [
                    "_value" => [
                        "settings" => [
                            "_value" => [
                                "filter" => [
                                    "_value" => "text",
                                    "_attribute" => []
                                ],
                                "bodyTmpl" => [
                                    "_value" => "ui/grid/cells/text",
                                    "_attribute" => []
                                ],
                                "label" => [
                                    "_value" => $column,
                                    "_attribute" => [
                                        "translate" => "true"
                                    ]
                                ]
                            ],
                            "_attribute" => []
                        ]
                    ],
                    "_attribute" => [
                        "name" => $column
                    ]
                ]
            ];
        }

        $result["columns"][] = ["actionsColumn" => [
            "_value" => [
                [
                    "argument" => [
                        "_value" => [
                            "item" => [
                                "_value" => [
                                    [
                                        "item" => [
                                            "_value" => "false",
                                            "_attribute" => [
                                                "name" => "resizeEnabled",
                                                "xsi:type" => "boolean"
                                            ]
                                        ]
                                    ],
                                    [
                                        "item" => [
                                            "_value" => "107",
                                            "_attribute" => [
                                                "name" => "resizeDefaultWidth",
                                                "xsi:type" =>"string"
                                            ]
                                        ]
                                    ],
                                    [
                                        "item" => [
                                            "_value" => "entity_id",
                                            "_attribute" => [
                                                "name" => "indexField",
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
                        "_attribute" => [
                            "name" => "data",
                            "xsi:type" => "array"
                        ]
                    ]
                ],
                [
                    "argument" => [
                        "_value" => "catalog/category/view",
                        "_attribute" => [
                            "name" => "viewUrl",
                            "xsi:type" => "string"
                        ]
                    ]
                ]
            ],
            "_attribute" => [
                "name" => "actions",
                "class" => str_replace('_', '\\', $this->getVendorModelName($settings)) . "\Ui\Component\\".$this->getModelName($settings)."\Listing\Column\Actions",
                "sortOrder" => "200"
            ]
        ]];
        return $result["columns"];
    }
}
