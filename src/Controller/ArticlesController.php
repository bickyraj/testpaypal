<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain'=>['Users'],
        'conditions'=>['Users.id'=>$this->Auth->user('id')]
        ];
        
        $articles = $this->paginate($this->Articles);
        
        $this->set(compact('articles'));
        $this->set('_serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $article = $this->Articles->get($id, [
        //     'contain' => ['ArticleUsers']
        // ]);

        $festival = $this->Articles->find('list')
            ->select(['id', 'title'])
            ->where(['Articles.title not LIKE'  => '%tihar%'])
            ->orWhere(['Articles.title LIKE'  => '%dashain%','Articles.title not LIKE'  => '%tihar%']);

            debug($festival->toArray());die();
        $this->set('article', $article);
        $this->set('_serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            $article->user_id = $this->Auth->user('id');
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editArticle()
    {
        $article = $this->Articles->findById($id)->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $this->set('article',$article);
        //$this->set('_serialize', ['article']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user){
        if($this->request->action === 'add'){
            return true;
        }

        if(in_array($this->request->action, ['editArticle','delete'])){
            $articleId = (int)$this->request->params['pass'][0];
            if(!$this->Articles->isOwnedBy($articleId,$user['id'])){
                return false;
            }
        }

        return parent::isAuthorized($user);
    }

    public function test(){
       $data = [
            (int) 1 => [
                'title' => '25483_106728809362869_5795827_n.jpg',
                'status' => '2'
            ],
            (int) 3 => [
                'title' => '44569_193398817463220_816845208_n.jpg',
                'status' => '1'
            ]
        ];
        $entities = $this->Articles->newEntities($data);
        $this->set(compact('article'));

        if($this->Articles->saveMany($entities)) {

        }
    }
}
