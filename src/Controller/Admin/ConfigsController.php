<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Core\Configure;

// use Cake\I18n\I18n;
// use Cake\Datasource\ConnectionManager;
use Cake\Http\Client;
use Symfony\Component\DomCrawler\Crawler;
// for Crawler you nedd to install bellow libraries
// composer require symfony/css-selector
// composer require symfony/dom-crawler

class ConfigsController extends AppController
{
    public function index( )
    {
        if ($this->request->is('post')) {

            $this->autoRender = false;

            $conditions = [ ];

            // Filters and Search
            $_from = !empty($_GET['from']) ? $_GET['from'] : '';
            $_to = !empty($_GET['to']) ? $_GET['to'] : '';

            $_method = !empty($_GET['method']) ? $_GET['method'] : '';
            $_col = !empty($_GET['col']) ? $_GET['col'] : 'id';
            $_k = (isset($_GET['k']) && strlen($_GET['k'])>0) ? $_GET['k'] : false;
            $_dir = !empty($_GET['direction']) ? $_GET['direction'] : 'DESC';
    
            
            if( !empty($_from) ){ $conditions['Configs.stat_updated > '] = $_from; }
            if( !empty($_to) ){ $conditions['Configs.stat_updated < '] = $_to; }
            if($_k !== false){
                $_method == 'like' ?  $conditions[$_col.' LIKE '] = '%'.$_k.'%' : $conditions['Configs.'.$_col] = $_k;
            }
            
            $data=[];
            $_id = $this->request->getQuery('id');
            $_list = $this->request->getQuery('list');

            // ONE RECORD
            if(!empty($_id)){
                $data = $this->Configs->get( $_id )->toArray();
                $data = $this->Do->convertJson($data);
                echo json_encode( [ "status"=>"SUCCESS",  "data"=>$data],  JSON_UNESCAPED_UNICODE); die();
            }

            // LIST
            if(!empty($_list)){ 
                $data = $this->paginate($this->Configs, [
                    "order"=>[ $_col => $_dir ],
                    "conditions"=>$conditions,
                ]);
                $data = $this->Do->convertJson($data);
            }

            echo json_encode( 
                [ "status"=>"SUCCESS",  "data"=>$data, "paging"=>$this->Paginator->getPagingParams()["Configs"]], 
                JSON_UNESCAPED_UNICODE); die();
        }
    }

    public function save($id = -1) 
    {
        
        $dt = json_decode( file_get_contents('php://input'), true);

        // edit mode
        if ($this->request->is(['patch', 'put'])) {
            $rec = $this->Configs->get($dt['id']);
        }

        // add mode
        if ($this->request->is(['post'])) {
            $rec = $this->Configs->newEmptyEntity();
            $dt['id'] = null;
        }

        if ($this->request->is(['post', 'patch', 'put'])) {
            
            $this->autoRender  = false;
            
            $dt['stat_updated'] = date('Y-m-d H:i:s');
            $rec = $this->Configs->patchEntity($rec, $dt);
            
            if ($newRec = $this->Configs->save($rec)) {
                echo json_encode(["status"=>"SUCCESS", "data"=>$newRec]); die();
            }

            echo json_encode(["status"=>"FAIL", "data"=>$rec->getErrors()]); die();
        }
    }

    public function refresher()
    {
        $this->autoRender = false;
        Configure::write('Session', [
            'defaults' => 'php',
            'Session.timeout' => 0
        ]);
        echo json_encode([ "status"=>"SUCCESS", "data"=>['date'=>date('Y-m-d H:i:s')]]);die();
    }

    public function switchRole($role=null)
    {
        if($role){
            $_SESSION['Auth']['User']['user_original_role'] = true;
            $_SESSION['Auth']['User']['user_role'] = $role;
            $this->authUser = $_SESSION['Auth']['User'];
            echo json_encode([ "status"=>"SUCCESS", "data"=>[], "redirect"=>$this->app_folder."/admin"]); die();
        }
        echo json_encode([ "status"=>"FAIL", "data"=>[], "msg"=>__('no_role_slected')]); die();
    }

    
    private function trans()
    {

        $data = [
            // 'form_params' => [
                'source=tr',
                'target=ar',
                'q=Metrekare Alanı0 - 0 m2',
                'q=Teslim TarihiEylül 2024',
                'q=Satış Durumu% 0,00 Satıldı'
            // ]
        ];

        $client = new Client([ 
            'headers'=>[
                'Accept-Encoding' => 'application/gzip',
                'X-RapidAPI-Host' => 'google-translate1.p.rapidapi.com',
                'X-RapidAPI-Key' => '629335600dmshbd5a0384413dfa8p1d4fdfjsn9c738648b3c5',
                'content-type' => 'application/x-www-form-urlencoded'
            ] 
        ]);

        $request = $client->post(
            'https://google-translate1.p.rapidapi.com/language/translate/v2', 
            implode('&', $data)
        );

        return $request->getJson(); 
    }

    public function collector($tar = '', $url = 'https://www.guncelprojebilgileri.com/istanbul-avrupa-konut-projeleri/rams-garden')
    {

        ini_set('max_execution_time', '600'); // 0 for infinite time of execution 

        $this->autoRender = false;
        $ip = $this->Do->getIP();

        if ($tar == 'ip_test') {
            $this->Do->sendEmail(['osama.qassar@gmail.com'], $tar . '_cronjob_report', ['IP' => $ip], 'report_tm');
            echo $ip;
            die();
        }

        if (!in_array($ip, [
            '46.2.218.65', // my laptop
            '170.10.163.120', // my server
            // '127.0.0.1' // localhost
            '212.156.14.178', // pt work laptop
        ])) {
            $this->Do->sendEmail(['osama.qassar@gmail.com'], 'wrong_IP_cronjob_report', ['IP' => $ip], 'report_tm');
            echo __('wrong_ip') . ' ' . $ip;
            die();
        }
        
        $client = new Client();

        $response = $client->get($url);

        $body = $response->getBody()->getContents('.block-wrap');

        $crawler = new Crawler($body);

        // get specific selector
        $filter = $crawler->filter('.block-wrap'); // we have 7 blocks with this class ".block-wrap"
        // get ALL items under specific selectorS 
        // $data = $filter->each(function ($node, $i) {
        // 	echo $i.'==========='.var_dump( $node->text() ).'<br/ >';
        // });

        $data = $filter->each(function ($node, $i) {

            $hdr = $node->filter('.block-title');
            echo '<b>' . $hdr->text() . '</b><br/>';

            $filter2 = $node->filter('li');
            $filter2->each(function ($li, $i2) {
                echo $i2 . '===========' . ($li->text()) . '<br/>';
            });
            echo '<hr/>';
        });
        
        // var_dump($lis);
        // $tags = trim(strip_tags($filter));
        // $tagLines = explode("\n", $tags);
        // $tagLines = array_filter($tagLines);
        // foreach($tagLines as $line)
        // {
        // 	echo $line."<br/>";
        // }

        echo json_encode(["status" => "SUCCESS", "data" => $data]);
        die();
    }

    function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        if( isset( $this->authUser['user_original_role']) ){
            if ($this->request->is(['post', 'patch', 'put', 'delete'])) {
                if(!$this->_isAuthorized(true, 'read')){
                    echo json_encode(["status" => "FAIL", "redirect" => $this->app_folder.'/admin/properties']); die();
                }
            }
        }
        $this->Auth->allow(['collector', 'trans']);
    }
}
