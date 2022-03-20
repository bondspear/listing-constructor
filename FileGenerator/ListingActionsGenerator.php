<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class ListingActionsGenerator
{
    public function generate($settings)
    {
        $folders = [
            "ui" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui",
            "component" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/Component",
            "model" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/Component/" . $this->getModelName($settings),
            "listing" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/Component/" . $this->getModelName($settings) .'/Listing',
            "column" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/Component/" . $this->getModelName($settings) .'/Listing/Column',
        ];

        foreach ($folders as $k => $path) {
            if (!is_dir($path)) {
                mkdir($path, 0777);
                shell_exec("chmod -R 777 " . $path);
            }
        }

        $file1 = $folders['column'] . '/Actions.php';
        shell_exec("chmod -R 777 " . $folders['column'] . '/*');
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Ui\Component\\'.$this->getModelName($settings).'\Listing\Column;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\View\Element\UiComponentFactory;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\View\Element\UiComponent\ContextInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\UrlInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Ui\Component\Listing\Columns\Column;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class Actions extends Column' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, "    const EDIT_LISTING_ITEM = '".$this->getSmallVendorModelName($settings) . "/" . $this->getSmallModelName($settings) . "/edit';" . PHP_EOL);
        fwrite($f1, '    protected $_urlBuilder;' . PHP_EOL);
        fwrite($f1, '    protected $_viewUrl;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function __construct(' . PHP_EOL);
        fwrite($f1, '        ContextInterface $context,' . PHP_EOL);
        fwrite($f1, '        UiComponentFactory $uiComponentFactory,' . PHP_EOL);
        fwrite($f1, '        UrlInterface $urlBuilder,' . PHP_EOL);
        fwrite($f1, '        $viewUrl = \'\',' . PHP_EOL);
        fwrite($f1, '        array $components = [],' . PHP_EOL);
        fwrite($f1, '         array $data = []' . PHP_EOL);
        fwrite($f1, '    ) {' . PHP_EOL);
        fwrite($f1, '        $this->_urlBuilder = $urlBuilder;' . PHP_EOL);
        fwrite($f1, '        $this->_viewUrl    = $viewUrl;' . PHP_EOL);
        fwrite($f1, '        parent::__construct($context, $uiComponentFactory, $components, $data);' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function prepareDataSource(array $dataSource)' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        if (isset($dataSource[\'data\'][\'items\'])) {' . PHP_EOL);
        fwrite($f1, '            foreach ($dataSource[\'data\'][\'items\'] as &$item) {' . PHP_EOL);
        fwrite($f1, '                $item[$this->getData(\'name\')][\'edit\'] = [' . PHP_EOL);
        fwrite($f1, '                    \'href\' => $this->_urlBuilder->getUrl(self::EDIT_LISTING_ITEM, [' . PHP_EOL);
        fwrite($f1, '                         \'id\' => $item[\'id\'],' . PHP_EOL);
        fwrite($f1, '                     ]),' . PHP_EOL);
        fwrite($f1, '                     \'label\' => __(\'Edit\'),' . PHP_EOL);
        fwrite($f1, '                      \'hidden\' => false,' . PHP_EOL);
        fwrite($f1, '                   ];' . PHP_EOL);
        fwrite($f1, '             }' . PHP_EOL);
        fwrite($f1, '         }' . PHP_EOL);
        fwrite($f1, '     return $dataSource;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '}' . PHP_EOL);
        fclose($f1);
        shell_exec("chmod -R 777 " . $folders['column'] . '/*');
    }

    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getSmallVendorModelName($settings)
    {
        return strtolower($settings['listingModule']);
    }

    public function getSmallModelName($settings)
    {
        return strtolower(str_replace('\\Model\\', '', $settings['listingModel']));
    }

    public function getModelName($settings)
    {
        return str_replace('\\Model\\', '', $settings['listingModel']);
    }
}

