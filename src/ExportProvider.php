<?php
namespace Qs\TopButton;

use Bootstrap\Provider;
use Bootstrap\RegisterContainer;
use Qs\TopButton\Export\Export;

class ExportProvider implements Provider{

    public function register(){
        RegisterContainer::registerListTopButton('export', Export::class);

        RegisterContainer::registerSymLink(WWW_DIR . '/Public/export-excel', __DIR__ . '/../asset/export-excel');
    }
}