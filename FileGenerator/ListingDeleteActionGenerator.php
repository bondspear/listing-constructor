<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class ListingDeleteActionGenerator
{
    public function generate($settings)
    {
        $folders = [
            "ui" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui",
            "dataProvider" =>  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/DataProvider",
            "listing" =>  str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/DataProvider/Listing"
        ];

        foreach ($folders as $k => $path) {
            if (!is_dir($path)) {
                mkdir($path, 0777);
                shell_exec("chmod -R 777 " . $path);
            }
        }

        $file1 = $folders['listing'] . '/CollectionDataProvider.php';


        shell_exec("chmod -R 777 " . $folders['listing']. '/*');
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Controller\Adminhtml\ControllerName' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\App\RequestInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Ui\DataProvider\AbstractDataProvider;' . PHP_EOL);
        fwrite($f1, 'use ' . $this->getVendorModelName($settings) . $this->getCollectionName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class CollectionDataProvider extends AbstractDataProvider' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'protected $_request;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function __construct(' . PHP_EOL);
        fwrite($f1, '    RequestInterface $request,' . PHP_EOL);
        fwrite($f1, '    CollectionFactory $collectionFactory,' . PHP_EOL);
        fwrite($f1, '    string $name,' . PHP_EOL);
        fwrite($f1, '    string $primaryFieldName,' . PHP_EOL);
        fwrite($f1, '    string $requestFieldName,' . PHP_EOL);
        fwrite($f1, '    array $meta = [],' . PHP_EOL);
        fwrite($f1, '    array $data = []' . PHP_EOL);
        fwrite($f1, '    ) {' . PHP_EOL);
        fwrite($f1, '    parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);' . PHP_EOL);
        fwrite($f1, '    $this->collection = $collectionFactory->create();' . PHP_EOL);
        fwrite($f1, '    $this->_request = $request;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function getData()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '    if (!$this->getCollection()->isLoaded()) {' . PHP_EOL);
        fwrite($f1, '    $this->getCollection()->load();' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '    return $this->getCollection()->toArray();' . PHP_EOL);
        fwrite($f1, '     }' . PHP_EOL);
        fwrite($f1, '}' . PHP_EOL);
        fclose($f1);

        shell_exec("chmod -R 777 " . $folders['listing'] . '/*');
    }
    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getCollectionName($settings)
    {
        return $settings['listingCollection'];
    }
}
