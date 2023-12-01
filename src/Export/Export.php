<?php
namespace Qs\TopButton\Export;

use Illuminate\Support\Str;
use Qscmf\Builder\ButtonType\ButtonType;
use Qscmf\Builder\ListBuilder;
use Think\View;

class Export extends ButtonType{

    public function build(array &$option, ListBuilder $listBuilder){
        $my_attribute['type'] = 'export';
        $my_attribute['title'] = '导出excel';
        $my_attribute['target-form'] = 'ids';
        $my_attribute['class'] = 'btn btn-primary export_excel';

        if ($option['attribute'] && is_array($option['attribute'])) {
            $option['attribute'] = array_merge($my_attribute, $option['attribute']);
        }

        $gid = Str::uuid()->getHex();
        $option['attribute']['id'] = $gid;

        $view = new View();
        $view->assign('gid', $gid);
        $view->assign('button', $option['attribute']);
        $content = $view->fetch(__DIR__ . '/export.html');

        return $content;
    }
}