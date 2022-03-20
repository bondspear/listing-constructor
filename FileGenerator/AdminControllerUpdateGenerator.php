<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class AdminControllerUpdateGenerator
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

        $file1 = $folders['index'] . '/Update.php';
        shell_exec("chmod -R 777 " . $folders['index'] . '/*');
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Controller\Adminhtml\\'.$this->getModelName($settings).';' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use ' . $this->getVendorModelName($settings) . '\Model\\' . $this->getModelName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\Controller\ResultFactory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\RequestInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action\Context;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class Update extends Action implements HttpPostActionInterface' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    protected $resultFactory;' . PHP_EOL);
        fwrite($f1, '    protected $' . $this->getSmallModelName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f1, '    protected $request;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    const MODEL = [' . PHP_EOL);
        foreach ($this->getColumns($settings) as $column) {
            fwrite($f1, '    "' . $column .'",'. PHP_EOL);
        }
        fwrite($f1, '];' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function __construct(Context $context, ResultFactory $resultFactory, '.$this->getModelName($settings).'Factory $' . $this->getSmallModelName($settings) . 'Factory, RequestInterface $request)' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '     parent::__construct($context);' . PHP_EOL);
        fwrite($f1, '     $this->request = $request;' . PHP_EOL);
        fwrite($f1, '     $this->resultFactory = $resultFactory;' . PHP_EOL);
        fwrite($f1, '     $this->' . $this->getSmallModelName($settings) . 'Factory = $' . $this->getSmallModelName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function execute()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '    switch ($this->getProgramByRequest()) {' . PHP_EOL);
        fwrite($f1, '    case "CREATE": $this->createEntity(); break;' . PHP_EOL);
        fwrite($f1, '    case "UPDATE": $this->updateEntityById($this->request->getParam(\'id\'));' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);' . PHP_EOL);
        fwrite($f1, '    $resultRedirect->setPath(\'*/*/index\');' . PHP_EOL);
        fwrite($f1, '    return $resultRedirect;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function getProgramByRequest()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        if (empty($this->request->getParam(\'id\'))) {' . PHP_EOL);
        fwrite($f1, '            return \'CREATE\';' . PHP_EOL);
        fwrite($f1, '        }' . PHP_EOL);
        fwrite($f1, '        return \'UPDATE\';' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function updateEntityById($entityId)' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $model = $this->' . $this->getSmallModelName($settings) . 'Factory->create();' . PHP_EOL);
        fwrite($f1, '        $model->load($entityId);' . PHP_EOL);
        fwrite($f1, '        $model->addData($this->request->getParams());' . PHP_EOL);
        fwrite($f1, '        $model->save();' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function createEntity()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $data = [];' . PHP_EOL);
        fwrite($f1, '        foreach (self::MODEL as $attribute) {' . PHP_EOL);
        fwrite($f1, '        $data[$attribute] = $this->request->getParam($attribute);' . PHP_EOL);
        fwrite($f1, '        }' . PHP_EOL);
        fwrite($f1, '        $model = $this->' . $this->getSmallModelName($settings) . 'Factory->create();' . PHP_EOL);
        fwrite($f1, '        $model->setData($data);' . PHP_EOL);
        fwrite($f1, '        $model->save();' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '}' . PHP_EOL);
        fclose($f1);
        shell_exec("chmod -R 777 " . $folders['index'] . '/*');
    }

    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getModelName($settings)
    {
        return str_replace('\\Model\\', '', $settings['listingModel']);
    }

    public function getColumns($settings)
    {
        return explode(',', $settings['listingColumns']);
    }

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }
}
