<?php
namespace App\Controller;

use App\Controller\AppController;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['ArticleUsers']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {  
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }

    public function initialize()
    {    
    parent::initialize();
    // Add logout to the allowed actions list.
    $this->Auth->allow(['payAmount','index','logout', 'add','initializePaypal','checkout']);
    }

    public function logout()
    {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

    public function initializePaypal() {
        $paypal = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                        'AfewFEwaKB_iY1XDPiSGg5DyA_JPcxwh_zIo82oiXcZfvfwnH-Num8E6T7Cm96CVPHZWjy6OQ1iIAcKG',
                        'EL4cOI6TQikhDATAxzs-4jCwm0JSpdmBQ3f1eeJ2mG8g8FK8YdiVNgdONh8P2eJVebjgh6xYCQrGHSiy'
                    )
            );

        $paypal->setConfig([
               'mode'=>'sandbox',
               'http.ConnectionTimeOut'=> 50,
               'log.LogEnabled'=> false,
               'log.FileName' => '',
               'log.LogLevel' =>'FINE',
               'validation.level' =>'log'
           ]);

        return $paypal;
    }

    public function checkout() {
        $product = $this->request->data['product'];        
        $price = $this->request->data['price'];

        $paypal = $this->initializePaypal();
        // debug($paypal);die();
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $shipping = 1.00;
        $tax = 1.00;
        $total = $price + $shipping + $tax;

        // item
        $item = new Item();
        $item->setName($product)
            ->setCurrency("USD")
            ->setQuantity(1)
            ->setPrice($price);

        // item list
        $itemList = new ItemList();
        $itemList->setItems([$item]);

        // details
        $details = new Details();
        $details->setShipping($shipping)
            ->setTax($tax)
            ->setSubtotal($price);

        // amount
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($total)
            ->setDetails($details);

        // transactions
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Paypal Payment")
            ->setInvoiceNumber(uniqid());

        // redirect url
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(BASE_URL.'Users/payAmount?success=true')
            ->setCancelUrl(BASE_URL.'Users/payAmount?success=false');

        // payment
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($paypal);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }

        $approvalUrl = $payment->getApprovalLink();
        return $this->redirect($approvalUrl);
    }

    public function payAmount()
    {
        if(isset($_GET['success']) && isset($_GET['paymentId']) && isset($_GET['PayerID'])){
            if($_GET['success'] == true) {

                $paypal = $this->initializePaypal();
                $paymentId = $_GET['paymentId'];
                $payerID = $_GET['PayerID'];

                $payment = Payment::get($paymentId,$paypal);
                $execute = new PaymentExecution();
                $execute->setPayerId($payerID);

                try {
                    $result = $payment->execute($execute,$paypal);
                } 
                catch (\PayPal\Exception\PayPalConnectionException $ex) {
                    $data = $ex->getData();
                    debug($data);
                    die($ex);
                }
                catch (Exception $e) {
                    $data = $e->getData();
                    debug($data);
                    die($e);
                }
            } else {
            }
        } else {
            
                debug("something went wrong");
                die();
        }
    }
}
