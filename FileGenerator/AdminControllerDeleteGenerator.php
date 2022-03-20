<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class AdminControllerDeleteGenerator
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

        $file1 = $folders['index'] . '/Delete.php';
        shell_exec("chmod -R 777 " . $folders['index'] . '/*');
        shell_exec("rm " . $file1);


        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Controller\Adminhtml\\'.$this->getModelName($settings).';' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use ' . $this->getVendorModelName($settings) . '\Model\\' . $this->getModelName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\Controller\ResultFactory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\RequestInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action\Context;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class Delete extends Action' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    protected $resultFactory;' . PHP_EOL);
        fwrite($f1, '    protected $' . strtolower($this->getModelName($settings)) . 'Factory;' . PHP_EOL);
        fwrite($f1, '    protected $request;' . PHP_EOL);
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
        fwrite($f1, '        $resultRedirect->setPath(\'*/*/index\');' . PHP_EOL);
        fwrite($f1, '        return $resultRedirect;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function deleteEntityById()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $entityId = $this->getIdFromUrl();' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '        if ($entityId) {' . PHP_EOL);
        fwrite($f1, '            $model = $this->' . strtolower($this->getModelName($settings)) . 'Factory->create();' . PHP_EOL);
        fwrite($f1, '            $model->load($entityId);' . PHP_EOL);
        fwrite($f1, '            $model->delete();' . PHP_EOL);
        fwrite($f1, '        }' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function getIdFromUrl()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $parts = explode(\'/\', $this->request->getPathInfo());' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '        if (!empty($parts[5]) and $parts[5] == \'id\') {' . PHP_EOL);
        fwrite($f1, '            if (!empty($parts[7]) and $parts[7] == \'key\') {' . PHP_EOL);
        fwrite($f1, '                if (!empty($parts[6])) {' . PHP_EOL);
        fwrite($f1, '                    return intval($parts[6]);' . PHP_EOL);
        fwrite($f1, '                }' . PHP_EOL);
        fwrite($f1, '           }' . PHP_EOL);
        fwrite($f1, '        }' . PHP_EOL);
        fwrite($f1, '        return false;' . PHP_EOL);
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

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }
}



