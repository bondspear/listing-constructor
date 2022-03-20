<?php
namespace Bondspear\ListingConstructor\Block\Frontend;

use Magento\Framework\App\DeploymentConfig\Reader as ConfigReader;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Data extends Template
{
    protected $request;
    protected $configReader;

    public function __construct(ConfigReader $configReader, RequestInterface $request, Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->configReader = $configReader;
        $this->request = $request;
    }

    public function validationRules()
    {
        /**
         * validation rules /lib/web/mage/validation.js
         */

        return json_encode([
                "Bondspear_ListingConstructor/js/modelExistRule" => [
                    "url" => $this->request->getDistroBaseUrl() . "bondspear_listingconstructor/validator/fileexistrule"
                ],
                "Bondspear_ListingConstructor/js/collectionExistRule" => [
                    "url" => $this->request->getDistroBaseUrl() . "bondspear_listingconstructor/validator/fileexistrule"
                ],
                "Bondspear_ListingConstructor/js/tableExistRule" => [
                    "url" => $this->request->getDistroBaseUrl() . "bondspear_listingconstructor/validator/tableexistrule"
                ],
                "validation" => [
                    "rules" => [
                        "listing_model" => [
                            "validate-no-empty" => true,
                            "modelExistRule" => true
                        ],
                        "listing_collection" => [
                            "validate-no-empty" => true,
                            "collectionExistRule" => true
                        ],
                        "listing_db" => [
                            "validate-no-empty" => true,
                            "tableExistRule" => true
                        ]
                    ],
                    "messages" => [
                        "listing_model" => [
                            "validate-no-empty" => "Это поле обязательно для заполнения*"
                        ],
                        "listing_collection" => [
                            "validate-no-empty" => "Это поле обязательно для заполнения*"
                        ],
                        "listing_db" => [
                            "validate-no-empty" => "Это поле обязательно для заполнения*"
                        ]
                    ]
                ]
            ]);
    }

    public function listModules()
    {
        $modules = $this->configReader->load(ConfigFilePool::APP_CONFIG);
        $result = [];
        foreach ($modules['modules'] as $moduleName => $moduleStatus) {
            $parts = explode('_', $moduleName);

            if ($parts[0] != 'Magento' and $moduleStatus == 1) {
                $result[] = $moduleName;
            }
        }

        return $result;
    }

    public function actionUrl()
    {
        return $this->request->getDistroBaseUrl() . "index.php/bondspear_listingconstructor/index/save";
    }
}


