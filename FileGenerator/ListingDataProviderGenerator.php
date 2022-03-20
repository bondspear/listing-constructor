<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class ListingDataProviderGenerator
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
        $file2 = $folders['listing'] . '/ItemDataProvider.php';



        shell_exec("chmod -R 777 " . $folders['listing']. '/*');
        shell_exec("rm " . $file1);
        shell_exec("rm " . $file2);


        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Ui\DataProvider\Listing;' . PHP_EOL);
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

        $f2 = fopen($file2, 'a+');
        fwrite($f2, '<?php' . PHP_EOL);
        fwrite($f2, 'namespace ' . $this->getVendorModelName($settings) . '\Ui\DataProvider\Listing;' . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, 'use Magento\Framework\App\RequestInterface;' . PHP_EOL);
        fwrite($f2, 'use Magento\Ui\DataProvider\AbstractDataProvider;' . PHP_EOL);
        fwrite($f2, 'use ' . $this->getVendorModelName($settings) . $this->getCollectionName($settings) . 'Factory;' . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, 'class ItemDataProvider extends AbstractDataProvider' . PHP_EOL);
        fwrite($f2, '{' . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, 'protected $_request;' . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, '    public function __construct(' . PHP_EOL);
        fwrite($f2, '    RequestInterface $request,' . PHP_EOL);
        fwrite($f2, '    CollectionFactory $collectionFactory,' . PHP_EOL);
        fwrite($f2, '    string $name,' . PHP_EOL);
        fwrite($f2, '    string $primaryFieldName,' . PHP_EOL);
        fwrite($f2, '    string $requestFieldName,' . PHP_EOL);
        fwrite($f2, '    array $meta = [],' . PHP_EOL);
        fwrite($f2, '    array $data = []' . PHP_EOL);
        fwrite($f2, '    ) {' . PHP_EOL);
        fwrite($f2, '    parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);' . PHP_EOL);
        fwrite($f2, '    $this->collection = $collectionFactory->create();' . PHP_EOL);
        fwrite($f2, '    $this->_request = $request;' . PHP_EOL);
        fwrite($f2, '    }' . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, '    public function getData(){' . PHP_EOL);
        fwrite($f2, '    if (!$this->getCollection()->isLoaded()) {' . PHP_EOL);
        fwrite($f2, '        $this->getCollection()->load();' . PHP_EOL);
        fwrite($f2, '    }' . PHP_EOL);
        fwrite($f2, '    $result = [];' . PHP_EOL);
        fwrite($f2, '    $items = $this->collection->getItems();' . PHP_EOL);
        fwrite($f2, '     foreach ($items as $item) {' . PHP_EOL);
        fwrite($f2, '         $result[$item->getId()] = $item->getData();' . PHP_EOL);
        fwrite($f2, '     }' . PHP_EOL);
        fwrite($f2, '    return $result;' . PHP_EOL);
        fwrite($f2, '    }' . PHP_EOL);
        fwrite($f2, '}' . PHP_EOL);
        fclose($f2);

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
