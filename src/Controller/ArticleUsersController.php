<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ArticleUsers Controller
 *
 * @property \App\Model\Table\ArticleUsersTable $ArticleUsers
 */
class ArticleUsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users','Articles']
        ];
        $articleUsers = $this->paginate($this->ArticleUsers);

        $this->set(compact('articleUsers'));
        $this->set('_serialize', ['articleUsers']);
    }

    /**
     * View method
     *
     * @param string|null $id Article User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articleUser = $this->ArticleUsers->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('articleUser', $articleUser);
        $this->set('_serialize', ['articleUser']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $articleUser = $this->ArticleUsers->newEntity();
        if ($this->request->is('post')) {
            $articleUser = $this->ArticleUsers->patchEntity($articleUser, $this->request->data);
            $articleUser->user_id = $this->Auth->user('id');
            if(!$this->ArticleUsers->exists(['article_id'=>$articleUser->article_id,'user_id'=>$articleUser->user_id])){
                if ($this->ArticleUsers->save($articleUser)) {
                    $this->Flash->success(__('The article has been posted to public.'));
                    return $this->redirect($this->referer());
                } else {
                    $this->Flash->error(__('The article user could not be saved. Please, try again.'));
                }
            } else {
                    $this->Flash->error(__('The article has been already posted.'));
            }
        }
        $users = $this->ArticleUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('articleUser', 'users'));
        $this->set('_serialize', ['articleUser']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $articleUser = $this->ArticleUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articleUser = $this->ArticleUsers->patchEntity($articleUser, $this->request->data);
            if ($this->ArticleUsers->save($articleUser)) {
                $this->Flash->success(__('The article user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The article user could not be saved. Please, try again.'));
            }
        }
        $users = $this->ArticleUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('articleUser', 'users'));
        $this->set('_serialize', ['articleUser']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articleUser = $this->ArticleUsers->get($id);
        if ($this->ArticleUsers->delete($articleUser)) {
            $this->Flash->success(__('The article user has been deleted.'));
        } else {
            $this->Flash->error(__('The article user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow("index");
    }

    public function test(){
        $result = $this->ArticleUsers->test();
        // $where = array();
        // $where['status'] = 1; 
        // $query = $this->ArticleUsers->find()->where([$where]);
        // $result = $this->paginate($query);
        // if(empty($result->items)){
        //     debug("emp");
        // }
        //debug($result);die();
    }
}
