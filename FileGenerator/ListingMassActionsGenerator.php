<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class ListingMassActionsGenerator
{
    public function generate($settings)
    {
        $folders = [
            "ui" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui",
            "component" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/Component",
            "model" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Ui/Component/" . $this->getModelName($settings),
        ];

        foreach ($folders as $k => $path) {
            if (!is_dir($path)) {
                mkdir($path, 0777);
                shell_exec("chmod -R 777 " . $path);
            }
        }

        $file1 = $folders['model'] . '/MassAction.php';
        shell_exec("chmod -R 777 " . $folders['model'] . '/*');
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Ui\Component\\'.$this->getModelName($settings).';' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\View\Element\UiComponentInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Framework\View\Element\UiComponent\ContextInterface;' . PHP_EOL);
        fwrite($f1, 'use Magento\Ui\Component\AbstractComponent;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class MassAction extends AbstractComponent' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '    const NAME = \'massaction\';' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function __construct(' . PHP_EOL);
        fwrite($f1, '        ContextInterface $context,' . PHP_EOL);
        fwrite($f1, '        array $components = [],' . PHP_EOL);
        fwrite($f1, '         array $data = []' . PHP_EOL);
        fwrite($f1, '      ) {' . PHP_EOL);
        fwrite($f1, '      parent::__construct($context, $components, $data);' . PHP_EOL);
        fwrite($f1, '     }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function prepare() : void' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        $config = $this->getConfiguration();' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '        foreach ($this->getChildComponents() as $actionComponent) {' . PHP_EOL);
        fwrite($f1, '             $config[\'actions\'][] = array_merge($actionComponent->getConfiguration(), [\'__disableTmpl\' => true]);' . PHP_EOL);
        fwrite($f1, '        }' . PHP_EOL);
        fwrite($f1, '        $origConfig = $this->getConfiguration();' . PHP_EOL);
        fwrite($f1, '        if ($origConfig !== $config) {' . PHP_EOL);
        fwrite($f1, '            $config = array_replace_recursive($config, $origConfig);' . PHP_EOL);
        fwrite($f1, '        }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '        $this->setData(\'config\', $config);' . PHP_EOL);
        fwrite($f1, '        $this->components = [];' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '        parent::prepare();' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function getComponentName() : string' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        return static::NAME;' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '}' . PHP_EOL);
        fclose($f1);
        shell_exec("chmod -R 777 " . $folders['model'] . '/*');
    }

    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getSmallVendorModelName($settings)
    {
        return strtolower($settings['listingModule']);
    }

    public function getModelName($settings)
    {
        return str_replace('\\Model\\', '', $settings['listingModel']);
    }
}

