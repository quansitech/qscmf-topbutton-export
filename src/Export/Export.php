<?php
namespace Qs\TopButton\Export;

use Illuminate\Support\Str;
use Qscmf\Builder\ButtonType\ButtonType;
use Think\View;

class Export extends ButtonType{

    public function build(array &$option){
        $my_attribute['type'] = 'export';
        $my_attribute['title'] = '导出excel';
        $my_attribute['target-form'] = 'ids';
        $my_attribute['class'] = 'btn btn-primary export_excel';

        if ($option['attribute'] && is_array($option['attribute'])) {
            $option['attribute'] = array_merge($my_attribute, $option['attribute']);
        }

        $gid = Str::uuid();
        $gid = str_repeat('-', '', $gid);
        $option['attribute']['id'] = 'modal-' . $gid;

        $view = new View();
        $view->assign('gid', $gid);
        $view->assign('button', $option['attribute']);
        $content = $view->fetch(__DIR__ . '/export.html');

        return $content;
    }
}