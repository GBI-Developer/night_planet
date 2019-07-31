<?php
namespace App\Controller\Owner;

use Cake\ORM\Query;
use Cake\Event\Event;
use Token\Util\Token;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Mailer\MailerAwareTrait;
use Cake\Datasource\ConnectionManager;

/**
* Owners Controller
*
* @property \App\Model\Table\OwnersTable $Owners
*
* @method \App\Model\Entity\Owner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
*/
class OwnersController extends AppController
{
    use MailerAwareTrait;

    public function beforeFilter(Event $event) {
        // AppController.beforeFilterをコールバック
        parent::beforeFilter($event);
        // オーナー用テンプレート
        $this->viewBuilder()->layout('ownerDefault');
        // オーナーに関する情報をセット
        if(!is_null($user = $this->Auth->user())){
            $shop = $this->Shops->find('all')->where(['owner_id' => $user['id']])->first();
            $this->set('shopInfo', $this->Util->getShopInfo($shop));
        }
    }

    public function signup()
    {
        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);

        // 登録ボタン押下時
        if ($this->request->is('post')) {
            // バリデーションは新規登録用を使う。
            $owner = $this->Owners->newEntity( $this->request->getData(),['validate' => 'ownerRegistration']);

            if(!$owner->errors()) {

                $owner = $this->Owners->patchEntity($owner, $this->request->getData());

                if ($this->Owners->save($owner)) {

    /*                    $this->log('save','debug');
                    $this->log($this,'debug');
                    $email = new Email('default');
                    $email->from(['okiyoru1@gmail.com' => 'My Site'])
                        ->to('8---30@ezweb.ne.jp')
                        ->cc('8---30@ezweb.ne.jp')
                        ->subject('About')
                        ->send('My message');
                    $this->log($email,'debug');*/
                    $this->getMailer('Owner')->send('ownerRegistration', [$owner]);
                    $this->Flash->success('入力したアドレスにメールを送りました。URLをクリックし、認証を完了してください。今から１０分以内に完了しないと、やり直しになりますのでご注意ください。');
                    return $this->redirect(['action' => 'login']);
                }
            } else {

                foreach ($owner->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                    }
                }
            }
        }
        // エリア、ジャンルリスト生成
        $params1 = array("area");
        $params2 = array("genre");
        //条件文を作成
        $condition1 = array(
            'conditions' => array('master_codes.delete_flag is' => null,
                                  'master_codes.code_group in' => $params1),
                                  'keyField' => 'code',
                                  'valueField' => 'code_name',
            'order' => array('sort' => 'ASC'));
        $area = $this->MasterCodes->find('list',$condition1);
        //条件文を作成
        $condition2 = array(
            'conditions' => array('master_codes.delete_flag is' => null,
                                  'master_codes.code_group in' => $params2),
                                  'keyField' => 'code',
                                  'valueField' => 'code_name',
            'order' => array('sort' => 'ASC'));
        $genre = $this->MasterCodes->find('list',$condition2);
        $area = $area->toArray();
        $genre = $genre->toArray();

        $this->set(compact('owner','area','genre'));
        $this->render();
    }

    public function login()
    {
        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);

        if ($this->request->is('post')) {

            // バリデーションはログイン用を使う。
            $owner = $this->Owners->newEntity( $this->request->getData(),['validate' => 'ownerLogin']);

            if(!$owner->errors()) {

                $this->log($this->request->getData("remember_me"),"debug");
                // 現在リクエスト中のユーザーを識別する
                $owner = $this->Auth->identify();
                if ($owner) {
                  // セッションにユーザー情報を保存する
                  $this->Auth->setUser($owner);
                  return $this->redirect($this->Auth->redirectUrl());
                }

                $this->Flash->error(RESULT_M['FRAUD_INPUT_FAILED']);
            } else {
                debug($this->request->getData());
                foreach ($owner->errors() as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $this->Flash->error($value2);
                    }
                }
            }
        } else {
            $owner = $this->Owners->newEntity();
        }
        $this->set('owner', $owner);
    }

    public function logout()
    {
        // レイアウトを使用しない
        $this->viewBuilder()->autoLayout(false);

        // TODO: この自動ログインのコメントは削除予定。\node-link\cakephp-remember-meプラグインで対応できてる
        // // ※ $userにユーザー情報取得済み前提
        // // ユーザー自動ログイン管理テーブルからレコード削除
        // $entity = $this->Owners->get(['id' => $this->Auth->user('id')]);
        // $entity->remember_token = "";
        // if ($this->Owners->save($entity)) {
        //     // Cookie削除
        //     $this->response = $this->response->withExpiredCookie('AUTO_LOGIN');
        // }

        $this->Flash->success(COMMON_M['LOGGED_OUT']);
        return $this->redirect($this->Auth->logout());
    }

    public function verify($token)
    {
        $owner = $this->Owners->get(Token::getId($token));
        if (!$owner->tokenVerify($token)) {

            $this->Flash->success(RESULT_M['AUTH_FAILED']);
            return $this->redirect(['action' => 'signup']);
        }
        if ($owner->status == 0 ) {
            // 本登録をもってオーナー用のディレクトリを掘る
            $dir = WWW_ROOT.'img/'.$owner->area.DS.$owner->genre.DS;
            // TODO scandirは、リストがないと、falseだけじゃなく
            // warningも吐く。後で対応を考える。
            // 指定フォルダ配下にあればラストの連番に+1していく
            if (file_exists($dir)) {
                $dirArray = scandir($dir);
                for($i = 0; $i < count($dirArray); $i++) {
                    if(strpos($dirArray[$i],'.') !== false) {
                        unset($dirArray[$i]);
                    }
                }
                $nextDir = sprintf("%05d",count($dirArray) + 1);

            } else {
            // 指定フォルダが空なら00001連番から振る
                $nextDir = sprintf("%05d", 1);

            }
            // パスが存在しなければディレクトリを掘ってDB登録
            if (!realpath($dir.$nextDir)) {
                $connection = ConnectionManager::get('default');
                // トランザクション処理開始
                $connection->begin();
                $owner->dir = $nextDir;
                $owner->status = 1;
                $shop = $this->Shops->newEntity();
                $shop->area = $owner->area;
                $shop->genre = $owner->genre;
                $shop->dir = $owner->dir;
                $result = true;
                if(!$this->Owners->save($owner)) {
                    $this->Flash->error('オーナーテーブルの更新に失敗した。');
                    $result = false;
                }
                if(!$this->Shops->save($shop)) {
                    $this->Flash->error('ショップテーブルの登録に失敗した。');
                    $result = false;
                }
                if($result) {
                    // 成功: commit
                    $connection->commit();
                    // ショップテーブルが登録されて初めて、求人情報の空テーブル作成
                    $findShop = $this->Shops->find('all')->where(['owner_id' => $owner->id])->first();
                    $this->Jobs->findOrCreate(['shop_id' => $findShop->id]);
                    // commit出来たらディレクトリを掘る
                    $dir = new Folder($dir.$nextDir, true, 0755);
                    // ユーザーステータスを本登録にする。(statusカラムを本登録に更新する)
                    $this->Flash->success(RESULT_M['AUTH_SUCCESS']);
                    return $this->redirect(['action' => 'login']);
                } else {
                    // 失敗: rollback
                    $connection->rollback();
                $this->Flash->error(RESULT_M['AUTH_FAILED']);
                return $this->redirect(['action' => 'signup']);
                }
            } else {
                $this->Flash->error('既にディレクトリが存在します。');
                $this->Flash->error(RESULT_M['AUTH_FAILED']);
                return $this->redirect(['action' => 'signup']);
            }

        }
        $this->Flash->success(RESULT_M['REGISTERED_FAILED']);
        return $this->redirect(['action' => 'login']);
    }

    public function index()
    {
        $shops = $this->Shops->newEntity();
        // 認証されてる場合
        if(!is_null($user = $this->Auth->user())){
            // オーナーに所属する全ての店舗を取得する
            $shops = $this->Shops->find('all')->where(['owner_id' => $user['id']]);
        }
        $this->set('shops', $shops);
        $this->render();
    }

    public function view($id = null)
    {

        if(isset($this->request->query["targetEdit"])){
            $targetEdit = $this->request->getQuery("targetEdit");
            $shop = $this->Owners->find('all')->contain(['Shops']);

            if ($targetEdit == 'topImage') {
                $this->paginate = [
                    'contain' => ['Shops']
                ];

                $this->set(compact('shop'));
            }
        }
    }


}
