<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class AdminControllerAddGenerator
{
    public function generate($settings)
    {
        $folders = [
            "controller" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Controller",
            "adminhtml" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Controller/Adminhtml",
            "index" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Controller/Adminhtml/".$this->getModelName($settings),
        ];

        foreach ($folders as $k => $path) {
            if (!is_dir($path)) {
                mkdir($path, 0777);
                shell_exec("chmod -R 777 " . $path);
            }
        }

        $file1 = $folders['index'] . '/Add.php';
        shell_exec("chmod -R 777 " . $folders['index']);
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Controller\Adminhtml\\'.$this->getModelName($settings).';' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\View\Result\PageFactory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action\Context;' . PHP_EOL);
        fwrite($f1, 'use Magento\Backend\App\Action;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class Add extends Action' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    protected $resultPageFactory;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function __construct(Context $context, PageFactory $resultPageFactory)' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        parent::__construct($context);' . PHP_EOL);
        fwrite($f1, '        $this->resultPageFactory = $resultPageFactory;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function execute()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        return $this->resultPageFactory->create();' . PHP_EOL);
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
}
