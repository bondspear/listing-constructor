<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class AdminControllerMassDeleteGenerator
{
    public function generate($settings)
    {
        $folders = [
            "controller" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Controller",
            "adminhtml" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Controller/Adminhtml",
            "index" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Controller/Adminhtml/" . $this->getModelName($settings),
        ];

        foreach ($folders as $k => $path) {
            if (!is_dir($path)) {
                mkdir($path, 0777);
                shell_exec("chmod -R 777 " . $path);
            }
        }

        $file1 = $folders['index'] . '/MassDelete.php';
        shell_exec("chmod -R 777 " . $folders['index']);
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Controller\Adminhtml\\' . $this->getModelName($settings) . ';' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use ' . $this->getVendorModelName($settings) . '\Model\\' . $this->getModelName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\Controller\ResultFactory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\RequestInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action\Context;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class MassDelete extends Action implements HttpPostActionInterface' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    protected $resultFactory;' . PHP_EOL);
        fwrite($f1, '    protected $' . strtolower($this->getModelName($settings)) . 'Factory;' . PHP_EOL);
        fwrite($f1, '    protected $request;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function __construct(Context $context, ResultFactory $resultFactory, ' . $this->getModelName($settings) . 'Factory $' . strtolower($this->getModelName($settings)) . 'Factory, RequestInterface $request)' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        parent::__construct($context);' . PHP_EOL);
        fwrite($f1, '        $this->request = $request;' . PHP_EOL);
        fwrite($f1, '        $this->resultFactory = $resultFactory;' . PHP_EOL);
        fwrite($f1, '        $this->' . strtolower($this->getModelName($settings)) . 'Factory = $'.$this->getSmallModelName($settings).'Factory;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function execute()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $this->deleteEntityById();' . PHP_EOL);
        fwrite($f1, '        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);' . PHP_EOL);
        fwrite($f1, '        $resultRedirect->setUrl($this->_redirect->getRefererUrl());' . PHP_EOL);
        fwrite($f1, '        return $resultRedirect;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function deleteEntityById()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $model = $this->' . strtolower($this->getModelName($settings)) . 'Factory->create();' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '        if (!empty($this->request->getParam(\'selected\'))) {' . PHP_EOL);
        fwrite($f1, '             foreach ($this->request->getParam(\'selected\') as $k => $entityId) {' . PHP_EOL);
        fwrite($f1, '                 $model->load($entityId);' . PHP_EOL);
        fwrite($f1, '                 $model->delete();' . PHP_EOL);
        fwrite($f1, '             }' . PHP_EOL);
        fwrite($f1, '           } else {' . PHP_EOL);
        fwrite($f1, '          foreach ($model->getCollection()->getitems() as $item) {' . PHP_EOL);
        fwrite($f1, '              foreach($this->request->getParam(\'excluded\') as $k => $excludeId){' . PHP_EOL);
        fwrite($f1, '                  if($item->getId() != $excludeId){' . PHP_EOL);
        fwrite($f1, '                       $model->load($item->getData(\'id\'));' . PHP_EOL);
        fwrite($f1, '                        $model->delete();' . PHP_EOL);
        fwrite($f1, '                   }' . PHP_EOL);
        fwrite($f1, '               }' . PHP_EOL);
        fwrite($f1, '             }' . PHP_EOL);
        fwrite($f1, '         }' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '}' . PHP_EOL);
        fclose($f1);
        shell_exec("chmod -R 777 " . $folders['index']. '/*');
    }

    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getModelName($settings)
    {
        return str_replace('\\Model\\', '', $settings['listingModel']);
    }

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }
}
