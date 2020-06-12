## xlsx导出excel
由后端完成excel导出操作会极大占用服务器资源，同时数据太多时往往会需要处理很长时间，页面长时间处于卡死状态用户体验也极差，因此采用前端分批导出excel数据才是更合理的做法。

+ 安装
```php
composer require quansitech/qscmf-topbutton-export
```

+ 使用样例
```php
.
.
.

class PostController extends GyListController{
    //继承ExportExcelByXlsx
    use ExportExcelByXlsx;
.
.
.
    
        $builder = new \Common\Builder\ListBuilder();
        //第一个参数指定export类型，第二个参数是指定需要覆盖的html组件属性
        //title为按钮名称，默认导出excel
        //data-url为点击导出按钮后ajax请求的地址,必填
        //data-filename 为生成的excel文件名,默认为浏览器的默认生成文件名
        //data-streamrownum 为每次请求获取的数据数
        $builder->addTopButton('export', array('title' => '样例导出', 'data-url' => U('/admin/post/export'), 'data-filename' => '文章列表', 'data-streamrownum' => '10'));
    
.
.
.
    //导出excel请求的action
    public function export(){
    
        //exportExcelByXlsx为 Qscmf\Builder\ExportExcelByXlsx trait提供的方法
        //参数为一个闭包函数，接收两个参数， page为请求的页数， rownnum为请求的数据行数
        $this->exportExcelByXlsx(function($page, $rownum){
             //闭包函数必须返回如下数据格式
             //[
             //    [  'excel表头1' =>  行1数据1, 'excel表头2' => 行1数据2 ..... ]
             //    [  'excel表头1' =>  行2数据1, 'excel表头2' => 行2数据2 ..... ]
             //    ...
             //]
            return [
                 [  '姓名' =>  'tt', '性别' => 'male', '年龄' => 23 ]
                 [  '姓名' =>  'ff', '性别' => 'female', '年龄' => 19 ]
            ];
        });

    }

```

筛选导出列
```php
//列配置，default为true表示默认选中状态, required为true表示必选
$cols_options = [
    [
        'key' => 'name',
        'title' => '商家名称',
        'default' => true,
        'required' => true
    ],
    [
        'key' => 'account',
        'title' => '账号',
        'default' => true
    ],
    [
        'key' => 'address',
        'title' => '商家地址'
    ],
    [
        'key' => 'num',
        'title' => '核销次数'
    ],
    [
        'key' => 'status',
        'title' => '状态'
    ],
    [
        'key' => 'explain',
        'title' => '优惠券使用说明'
    ]
];

//将列配置复制给第二个参数的键值 export_cols
//控件会将选择的列数据post至url,可通过I('post.exportCol')获取，再进行数据筛选逻辑处理。
$builder->addTopButton('export', array('export_cols' => $cols_options, 'title' => '样例导出', 'data-url' => U('/admin/post/export'), 'data-filename' => '文章列表', 'data-streamrownum' => '10'));


```


导出数据为多张工作表  
```php
 $export_arr = [
    ['sheetName' => 'Sheet1', 'url' => U('/admin/post/export'), 'rownum' => '15'],
    ['sheetName' => 'Sheet2', 'url' => U('/admin/post/export'), 'rownum' => '15'],
 ];
 
 $builder->addTopButton('export', ['data-url' => json_encode($export_arr), 'data-filename' => '导出列表', 'data-streamrownum' => intval($export_arr[0]['rownum'])]);
```

业务层错误提示
```php
可在导出数据处理的action位置进行错误验证，使用$this->errro("test")
插件可自动获取错误信息并alert提示用户
```

+ 辅助方法

```php
1. genExportCols($col_options, $selected_cols)  
   col_options  导出设置
   selected_cols  I('post.exportCol')从前端获取的导出列数据
```