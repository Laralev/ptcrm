<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Core\Configure;

// use Cake\Datasource\ConnectionManager;

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ConfigsController extends AppController
{
    

    public function refresher()
    {
        $this->autoRender = false;
        Configure::write('Session', [
            'defaults' => 'php',
            'Session.timeout' => 0
        ]);
        echo json_encode([ "status"=>"SUCCESS", "data"=>['date'=>date('Y-m-d H:i:s')]]);die();
    }

    public function setcurrency($val)
    {
        $this->Do->CookiesHandler(['currency'=>$val], 'write');
        echo json_encode([ "status"=>"SUCCESS", "data"=>[$val] ]); die();
    }
    

    function beforeFilter(EventInterface $event) 
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'refresher'
        ]);
    }

}
