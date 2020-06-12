<?php
namespace Qs\TopButton\Export;

trait ExportExcelByXlsx{

    protected function exportExcelByXlsx(\Closure $genExcelList){
        $page = I('get.page');
        $rownum = I('get.rownum');

        $list = call_user_func($genExcelList, $page, $rownum);
        $this->ajaxReturn($list);
    }

    protected function genExportCols($col_options, $selected_cols){
        $res = collect($col_options)->map(function($option){
            if($option['required'] == true){
                return $option['key'];
            }
        })->filter()->all();

        $selected_cols = $selected_cols === "" ? [] : (array)$selected_cols;

        $res= array_merge($res, $selected_cols);
        $res = array_unique($res);

        return $res;
    }
}