<?php
namespace Bondspear\ListingConstructor\FileGenerator;

class FormButtonsGenerator
{
    public function generate($settings)
    {
        $folders = [
            "block" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Block",
            "adminhtml" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Block/Adminhtml",
            "buttons" => str_replace('pub', '', $_SERVER['DOCUMENT_ROOT']) . 'app/code/' . str_replace('_', '/', $settings['listingModule']) . "/Block/Adminhtml/Buttons",
        ];

        foreach ($folders as $k => $path) {
            if (!is_dir($path)) {
                mkdir($path, 0777);
                shell_exec("chmod -R 777 " . $path);
            }
        }

        $file0 = $folders['buttons'] . '/Add.php';
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');
        shell_exec("rm " . $file0);

        $f0 = fopen($file0, 'a+');
        fwrite($f0, '<?php' . PHP_EOL);
        fwrite($f0, 'namespace ' . $this->getVendorModelName($settings) . '\Block\Adminhtml\Buttons;' . PHP_EOL);
        fwrite($f0, '' . PHP_EOL);
        fwrite($f0, 'class Add extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic' . PHP_EOL);
        fwrite($f0, '{' . PHP_EOL);
        fwrite($f0, '    public function getButtonData()' . PHP_EOL);
        fwrite($f0, '    {' . PHP_EOL);
        fwrite($f0, '        return [' . PHP_EOL);
        fwrite($f0, '             \'label\' => __(\'Add New Item\'),' . PHP_EOL);
        fwrite($f0, '             \'on_click\' => sprintf("location.href = \'%s\';", $this->getAddUrl()),' . PHP_EOL);
        fwrite($f0, '             \'class\' => \'primary\',' . PHP_EOL);
        fwrite($f0, '             \'sort_order\' => 10' . PHP_EOL);
        fwrite($f0, '         ];' . PHP_EOL);
        fwrite($f0, '    }' . PHP_EOL);
        fwrite($f0, '' . PHP_EOL);
        fwrite($f0, '    public function getAddUrl()' . PHP_EOL);
        fwrite($f0, '    {' . PHP_EOL);
        fwrite($f0, '        return $this->getUrl(\'*/*/add\');' . PHP_EOL);
        fwrite($f0, '    }' . PHP_EOL);
        fwrite($f0, '}' . PHP_EOL);
        fclose($f0);
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');


        $file1 = $folders['buttons'] . '/Back.php';
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');
        shell_exec("rm " . $file1);

        $f1 = fopen($file1, 'a+');
        fwrite($f1, '<?php' . PHP_EOL);
        fwrite($f1, 'namespace ' . $this->getVendorModelName($settings) . '\Block\Adminhtml\Buttons;' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, 'class Back extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic' . PHP_EOL);
        fwrite($f1, '{' . PHP_EOL);
        fwrite($f1, '    public function getButtonData()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        return [' . PHP_EOL);
        fwrite($f1, '             \'label\' => __(\'Back\'),' . PHP_EOL);
        fwrite($f1, '             \'on_click\' => sprintf("location.href = \'%s\';", $this->getBackUrl()),' . PHP_EOL);
        fwrite($f1, '             \'class\' => \'back\',' . PHP_EOL);
        fwrite($f1, '             \'sort_order\' => 10' . PHP_EOL);
        fwrite($f1, '         ];' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '' . PHP_EOL);
        fwrite($f1, '    public function getBackUrl()' . PHP_EOL);
        fwrite($f1, '    {' . PHP_EOL);
        fwrite($f1, '        return $this->getUrl(\'*/*/\');' . PHP_EOL);
        fwrite($f1, '    }' . PHP_EOL);
        fwrite($f1, '}' . PHP_EOL);
        fclose($f1);
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');

        $file2 = $folders['buttons'] . '/Delete.php';
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');
        shell_exec("rm " . $file2);

        $f2 = fopen($file2, 'a+');
        fwrite($f2, '<?php' . PHP_EOL);
        fwrite($f2, 'namespace ' . $this->getVendorModelName($settings) . '\Block\Adminhtml\Buttons;' . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, 'class Delete extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic' . PHP_EOL);
        fwrite($f2, '{' . PHP_EOL);
        fwrite($f2, '    public function getButtonData()' . PHP_EOL);
        fwrite($f2, '    {' . PHP_EOL);
        fwrite($f2, '        $data = [];' . PHP_EOL);
        fwrite($f2, ' $deleteConfirmMsg =  __(\'Are you sure you want to do this?\');' . PHP_EOL);
        fwrite($f2, '        if ($this->context->getRequestParam("' . $this->getPrimaryKey($settings) . '")) {' . PHP_EOL);
        fwrite($f2, '             $data = [' . PHP_EOL);
        fwrite($f2, '                 \'label\' => __(\'Delete\'),' . PHP_EOL);
        fwrite($f2, '                  \'class\' => \'delete\',' . PHP_EOL);
        fwrite($f2, '\'on_click\' => \'deleteConfirm("\' . $deleteConfirmMsg . \'", "\' . $this->getDeleteUrl() . \'")\',' . PHP_EOL);
        fwrite($f2, "                     'sort_order' => 20," . PHP_EOL);
        fwrite($f2, "                ];" . PHP_EOL);
        fwrite($f2, "         }" . PHP_EOL);
        fwrite($f2, '         return $data;' . PHP_EOL);
        fwrite($f2, "    }" . PHP_EOL);
        fwrite($f2, '' . PHP_EOL);
        fwrite($f2, '    public function getDeleteUrl()' . PHP_EOL);
        fwrite($f2, '    {' . PHP_EOL);
        fwrite($f2, '        return $this->getUrl(\'*/*/delete\', [\'id\' => $this->context->getRequestParam(\'id\')]);' . PHP_EOL);
        fwrite($f2, '    }' . PHP_EOL);
        fwrite($f2, '}' . PHP_EOL);
        fclose($f2);
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');

        $file3 = $folders['buttons'] . '/Save.php';
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');
        shell_exec("rm " . $file3);

        $f3 = fopen($file3, 'a+');
        fwrite($f3, '<?php' . PHP_EOL);
        fwrite($f3, 'namespace ' . $this->getVendorModelName($settings) . '\Block\Adminhtml\Buttons;' . PHP_EOL);
        fwrite($f3, '' . PHP_EOL);
        fwrite($f3, 'use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;' . PHP_EOL);
        fwrite($f3, 'use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;' . PHP_EOL);
        fwrite($f3, '' . PHP_EOL);
        fwrite($f3, 'class Save extends Generic implements ButtonProviderInterface' . PHP_EOL);
        fwrite($f3, '{' . PHP_EOL);
        fwrite($f3, '    public function getButtonData()' . PHP_EOL);
        fwrite($f3, '    {' . PHP_EOL);
        fwrite($f3, '             return [' . PHP_EOL);
        fwrite($f3, '                 \'label\' => __(\'Save\'),' . PHP_EOL);
        fwrite($f3, '                  \'class\' => \'save primary\',' . PHP_EOL);
        fwrite($f3, '                  \'data_attribute\' => [' . PHP_EOL);
        fwrite($f3, '                      \'mage-init\' => [\'button\' => [\'event\' => \'save\']],' . PHP_EOL);
        fwrite($f3, '                       \'form-role\' => \'save\',' . PHP_EOL);
        fwrite($f3, '                   ],' . PHP_EOL);
        fwrite($f3, "                     'sort_order' => 30," . PHP_EOL);
        fwrite($f3, "                ];" . PHP_EOL);
        fwrite($f3, "         }" . PHP_EOL);
        fwrite($f3, '}' . PHP_EOL);
        fclose($f3);
        shell_exec("chmod -R 777 " . $folders['buttons'] . '/*');
    }

    public function getVendorModelName($settings)
    {
        return str_replace('_', '\\', $settings['listingModule']);
    }

    public function getModelName($settings)
    {
        return str_replace('\\Model\\', '', $settings['listingModel']);
    }

    public function getPrimaryKey($settings)
    {
        $parts = explode('@', $settings['listingDb']);
        return $parts[1];
    }
}
