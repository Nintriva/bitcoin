<?php
/**
 * Bitcoin.php
 *
 * @author: sirin k <sirinibin2006@gmail.com>
 * Date: 16/dec/2013
 * Time: 9.08pm(IST)
 */
class Bitcoin extends CApplicationComponent
{
    public $API_KEY;
    public $CLIENT_SECRET;
    public $CLIENT_ID;
    
    public $CALLBACK_URL;
    public $CANCEL_URL;
    public $SUCCESS_URL;
    
    public $access_token=null;
    
    public $_oauthObject;
    
    public $useOauth;
    
    
    
    public $API_BASE = 'https://coinbase.com/api/v1/';
   
    public function init(){
	
	
        //set return and cancel urls
        $this->CALLBACK_URL = Yii::app()->createAbsoluteUrl($this->CALLBACK_URL);
        $this->CANCEL_URL = Yii::app()->createAbsoluteUrl($this->CANCEL_URL);
        $this->SUCCESS_URL = Yii::app()->createAbsoluteUrl($this->SUCCESS_URL);
       
    }
    public function __construct()
    {
        if($this->access_token==null)
        {
          $this->useOauth=false;
        }
        else
        {
          $this->useOauth=true;
        }
    }
    public function setAccessToken($access_token)
    {
      $this->useOauth=true;
      $this->access_token=$access_token;
    }
    public function askPermission($scope)
    { 
      $url="https://coinbase.com/oauth/authorize";
      
       $params = array(
						'response_type' => urlencode("code"),
						'client_id' => urlencode($this->CLIENT_ID),
						'redirect_uri' => urlencode($this->CALLBACK_URL),
						'scope'=>urlencode($scope)
						
				);

         $fields_string=http_build_query($params);
  
         header("location:".$url."?".$fields_string);
       
       
    }
    
    public function getAccessToken($code)
    {
      
         $url="https://coinbase.com/oauth/token";
        
         $params = array(
						'grant_type' => urlencode("authorization_code"),
						'code' => urlencode($code),
						'redirect_uri' => urlencode($this->CALLBACK_URL),
						'client_id'=>urlencode($this->CLIENT_ID),
						'client_secret'=>urlencode($this->CLIENT_SECRET),
						
				);
				
         $response=$this->sendRequest($url,"POST",$params);
         
         $this->_oauthObject=$response;
        
         $this->access_token=$response['access_token'];
         
         if(!empty($this->access_token))
          {
            $this->useOauth=true;
          }
         
         return($response);
    }
   
    /* List all changes to your account. */
    public function getAccountChanges()
    {
        $url=$this->API_BASE."account_changes";
       
       $response=$this->sendRequest($url,"GET",array());

       return($response);
    
    }
    
     /*----------------------------------------- Account --------------------------------------------------------------------------------*/
    /* 	Get the user's account balance in BTC.*/
    public function getBalance()
    {
       $url=$this->API_BASE."account/balance";
       
       $response=$this->sendRequest($url,"GET",array());

       return($response);
    }
     /* Get the user's current bitcoin receive address.*/
     public function getReceiveAddress()
    {
        $url=$this->API_BASE."account/receive_address";
       
        $response=$this->sendRequest($url,"GET",array());

        return($response);
    
    }
    
     /* Generates a new bitcoin receive address for the user. */
     public function generateReceiveAddress()
    {
        $url=$this->API_BASE."account/generate_receive_address";
       
        $response=$this->sendRequest($url,"POST",array());

        return($response);
    
    }
    
     /*----------------------------------------- end Account --------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Addresses --------------------------------------------------------------------------------*/
      /* List bitcoin addresses associated with this account. */
    
    public function getAllAddresses($query=null, $page=0, $limit=null)
    {
        $params = array();
        if ($query !== null) {
            $params['query'] = $query;
        }
        if ($limit !== null) {
            $params['limit'] = $limit;
        }
        return $this->getPaginatedResource("addresses", "addresses", "address", $page, $params);
    }
    
    /*----------------------------------------- end Addresses --------------------------------------------------------------------------------*/
    
    
    /*----------------------------------------- BUTTON--------------------------------------------------------------------------------*/
    
     /*	Create a new payment button, page, or iFrame. */
     	
    public function createButton($name, $price, $currency, $custom=null, $options=array())
    {

        $params = array(
            "name" => $name,
            "price_string" => $price,
            "price_currency_iso" => $currency
        );
        if($custom !== null) {
            $params['custom'] = $custom;
        }
        foreach($options as $option => $value) {
            $params[$option] = $value;
        }

        return $this->createButtonWithOptions($params);
    }

    public function createButtonWithOptions($options=array())
    {        
        $url=$this->API_BASE."buttons";
        
        $response= $this->sendRequest($url,"POST",array( "button" => $options ));

        if(!$response->success) {
            return $response;
        }

        $returnValue = new stdClass();
        $returnValue->button = $response->button;
        $returnValue->embedHtml = "<div class=\"coinbase-button\" data-code=\"" . $response->button->code . "\"></div><script src=\"https://coinbase.com/assets/button.js\" type=\"text/javascript\"></script>";
        $returnValue->success = true;
        return $returnValue;
    }
    
     /* Create an order for this button. */
    
    public function createButtonOrder($code)
    {
        $url=$this->API_BASE."buttons/".$code."/create_order";
       
        $response=$this->sendRequest($url,"POST",array(
        ));

        return($response);
    }
    
    /*----------------------------------------- end BUTTON--------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Buys--------------------------------------------------------------------------------*/
    
     /* 	Purchase bitcoin by debiting your U.S. bank account.*/
     public function buy($amount, $agreeBtcAmountVaries=false)
    {
        
        $url=$this->API_BASE."buys";
        
        return $this->sendRequest($url,"POST",  array(
            "qty" => $amount,
            "agree_btc_amount_varies " => $agreeBtcAmountVaries,
        )); 
    }
    
    /*----------------------------------------- end Buys--------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Contacts --------------------------------------------------------------------------------*/
    /* List emails the user has previously used for autocompletion. */
    public function getContacts($query=null, $page=0, $limit=null)
    {
        $params = array(
            "page" => $page,
        );
        if ($query !== null) {
            $params['query'] = $query;
        }
        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        $url=$this->API_BASE."contacts";
        
        $result= $this->sendRequest($url,"GET",$params);
        
        $contacts = array();
        foreach($result->contacts as $contact) {
            if(trim($contact->contact->email) != false) { // Check string not empty
                $contacts[] = $contact->contact->email;
            }
        }

        $returnValue = new stdClass();
        $returnValue->total_count = $result->total_count;
        $returnValue->num_pages = $result->num_pages;
        $returnValue->current_page = $result->current_page;
        $returnValue->contacts = $contacts;
        return $returnValue;
    }
    /*----------------------------------------- end Contacts --------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Currencies -------------------------------------------------------------------------------*/
     
     /*Show currencies supported by Coinbase.*/
     public function getCurrencies()
    {
        
        $url=$this->API_BASE."currencies";
        
        $response= $this->sendRequest($url,"GET",array());
        
        $result = array();
        foreach ($response as $currency) {
            $currency_class = new stdClass();
            $currency_class->name = $currency[0];
            $currency_class->iso = $currency[1];
            $result[] = $currency_class;
        }
        return $result;
    }
    /*Show exchange rates between BTC and other currencies.*/
    public function getExchangeRate($from=null, $to=null)
    {
         $url=$this->API_BASE."currencies/exchange_rates";
        
         $response= $this->sendRequest($url,"GET",array());

        if ($from !== null && $to !== null) {
            return $response->{"{$from}_to_{$to}"};
        } else {
            return $response;
        }
    }
    
    /*----------------------------------------- end Currencies --------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Orders --------------------------------------------------------------------------------*/
    
     /* List merchant orders received. */
    public function getOrders($page=0)
    {
        return $this->getPaginatedResource("orders", "orders", "order", $page);
    }
    
    /* Show an individual merchant order. */
    public function getOrder($id)
    {   
        $url=$this->API_BASE."orders/".$id;
        
        return $this->sendRequest($url,"GET",array())->order;
    }
    
    /*----------------------------------------- end Orders --------------------------------------------------------------------------------*/
    
    /*----------------------------------------- PRICES--------------------------------------------------------------------------------*/
    
     /*Get the total buy price for some bitcoin amount.*/
    public function getBuyPrice($qty=1)
    {
         
         $url=$this->API_BASE."prices/buy";
        
         return $this->sendRequest($url,"GET",array( "qty" => $qty ))->amount;
    }
     /*Get the total sell price for some bitcoin amount.*/
    public function getSellPrice($qty=1)
    {   
         $url=$this->API_BASE."prices/sell";
        
        return $this->sendRequest($url,"GET",array( "qty" => $qty ))->amount;
    }
    
    /* 	Get the spot price of bitcoin..*/
     public function getSpotPrice($currency=null)
    {
        $url=$this->API_BASE."prices/spot_rate";
       
        $response=$this->sendRequest($url,"GET",array(
        'currency'=>$currency
        ));

        return($response);
    
    }
    
    /*----------------------------------------- end PRICES--------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Recurring Payments -------------------------------------------------------------------*/
    
     /* 	List your recurring payment  */
     public function getRecurringPayments()
    {
        $url=$this->API_BASE."recurring_payments";
       
        $response=$this->sendRequest($url,"GET",array());

        return($response);
    
    }
     /* 	Show an individual recurring payment.  */
     public function getRecurringPayment($id)
    {
        $url=$this->API_BASE."recurring_payments/".$id;
       
        $response=$this->sendRequest($url,"GET",array());

        return($response);
    
    }
    /*----------------------------------------- end Recurring Payments -------------------------------------------------------------------*/
    
    /*----------------------------------------- Sells -------------------------------------------------------------------*/
     
     /* 	Sell bitcoin and receive a credit to your U.S. bank account..  */
     public function sell($amount)
    {
        $url=$this->API_BASE."sells";
        
        return $this->sendRequest($url,"POST",  array(
         'qty'=>$amount
           
        )); 
    }
    
    /*-----------------------------------------end Sells -------------------------------------------------------------------*/
    
    
    /*-----------------------------------------Subscribers  -------------------------------------------------------------------*/
     /* 	List customer subscriptions.  */
     public function getSubscribers()
    {
        $url=$this->API_BASE."subscribers";
        
        return $this->sendRequest($url,"POST",  array(
           
        )); 
    }
     /* 	Show an individual customer subscription.  */
     public function getSubscriber($id)
    {
        $url=$this->API_BASE."subscribers/".$id;
        
        return $this->sendRequest($url,"POST",  array(
          
        )); 
    }
   
     
     /*-----------------------------------------end Subscribers  -------------------------------------------------------------------*/
     
     
     /*-----------------------------------------Tokens  -------------------------------------------------------------------*/
     
       /*  Create a token which can be redeemed for bitcoin.  */
     public function createToken()
    {
        $url=$this->API_BASE."tokens";
        
        return $this->sendRequest($url,"POST",  array(
          
        )); 
    }
      /* 	Redeem a token, claiming its address and all its bitcoins.  */
     public function redeemToken($token_id)
    {
        $url=$this->API_BASE."tokens/redeem";
        
        return $this->sendRequest($url,"POST",  array(
          "token_id"=>$token_id
        )); 
    }
     
     /*-----------------------------------------end Tokens  -------------------------------------------------------------------*/
     
     
    
    
    /*----------------------------------------- Transactions --------------------------------------------------------------------------------*/
    
    /* 	List a user's recent transactions. */
    public function getTransactions()
    {
        $url=$this->API_BASE."transactions";
        
        return $this->sendRequest($url,"GET",  array(
         
        )); 
    }
    
    /* Show details for an individual transaction. */
    public function getTransaction($id)
    {
        $url=$this->API_BASE."transactions/".$id;   
        return $this->sendRequest($url,"GET",array())->transaction;    
    }
    
    /*Send bitcoins to an email address or bitcoin address.*/
    public function sendMoney($to, $amount, $notes=null, $userFee=null, $amountCurrency=null)
    {
        $url=$this->API_BASE."transactions/send_money";
        
        $params = array( "transaction[to]" => $to );

        if($amountCurrency !== null) {
            $params["transaction[amount_string]"] = $amount;
            $params["transaction[amount_currency_iso]"] = $amountCurrency;
        } else {
            $params["transaction[amount]"] = $amount;
        }

        if($notes !== null) {
            $params["transaction[notes]"] = $notes;
        }

        if($userFee !== null) {
            $params["transaction[user_fee]"] = $userFee;
        }

    
        return $this->sendRequest($url,"POST",$params);
    }
    
    /* Send an invoice/money request to an email address. */
    public function requestMoney($from, $amount, $notes=null, $amountCurrency=null)
    {
        $url=$this->API_BASE."transactions/request_money";
       
        $params = array( "transaction[from]" => $from );

        if($amountCurrency !== null) {
            $params["transaction[amount_string]"] = $amount;
            $params["transaction[amount_currency_iso]"] = $amountCurrency;
        } else {
            $params["transaction[amount]"] = $amount;
        }

        if($notes !== null) {
            $params["transaction[notes]"] = $notes;
        }

        return $this->sendRequest($url,"POST",$params);
    }
     /* Resend emails for a money request. */
    public function resendRequest($id)
    {   
        $url=$this->API_BASE."transactions/".$id."/resend_request";
        return $this->sendRequest($url,"PUT",array());
    }
     /* Cancel a money request. */
    public function cancelRequest($id)
    {
        $url=$this->API_BASE."transactions/".$id."/cancel_request";
        return $this->sendRequest($url,"DELETE",array());
         
    }
     /* Complete a money request. */
    public function completeRequest($id)
    {
        $url=$this->API_BASE."transactions/".$id."/complete_request";
        return $this->sendRequest($url,"PUT",array());
    }
    
    /*----------------------------------------- end Transactions --------------------------------------------------------------------------------*/
     
  
    /*----------------------------------------- end Transfers --------------------------------------------------------------------------------*/
    
    /*----------------------------------------- Users--------------------------------------------------------------------------------*/
    /*Create or signup a new user.*/
    public function createUser($email, $password)
    {
        $url=$this->API_BASE."users";
        
        return $this->sendRequest($url,"POST", array(
            "user[email]" => $email,
            "user[password]" => $password,
        )); 
    }
    /*Show current user with account settings.*/
    public function getUserAccountSettings($email, $password)
    {
        $url=$this->API_BASE."users";
        
        return $this->sendRequest($url,"GET", array(
         
        )); 
    }
    /*Update account settings for current user.*/
    public function updateUserAccountSettings($id,$user_details)
    {
        $url=$this->API_BASE."users/".$id;
        
        return $this->sendRequest($url,"PUT", array(
            "user"=>$user_details
        )); 
    }/*
     eg:
     
     "user": {
    "id": "512db383f8182bd24d000001",
    "name": "User One",
    "email": "bad email",
    "time_zone": "Pacific Time (US & Canada)",
    "native_currency": "USD",
    "buy_level": 1,
    "sell_level": 1,
    "balance": {
      "amount": "49.76000000",
      "currency": "BTC"
    },
    "buy_limit": {
      "amount": "10.00000000",
      "currency": "BTC"
    },
    "sell_limit": {
      "amount": "100.00000000",
      "currency": "BTC"
    }
  }
    */
  
   /*----------------------------------------- end Users--------------------------------------------------------------------------------*/  
     
    
   
    private function getPaginatedResource($resource, $listElement, $unwrapElement, $page=0, $params=array())
    {
        $url=$this->API_BASE."".$resource;
        
        $result = $this->sendRequest($url,"GET", array_merge(array( "page" => $page ), $params));
        
        //echo $result;
        
       // exit;
        
        $elements = array();
        foreach($result->{$listElement} as $element) {
            $elements[] = $element->{$unwrapElement}; // Remove one layer of nesting
        }

        $returnValue = new stdClass();
        $returnValue->total_count = $result->total_count;
        $returnValue->num_pages = $result->num_pages;
        $returnValue->current_page = $result->current_page;
        $returnValue->{$listElement} = $elements;
        return $returnValue;
    }
    
  
   

   
    public function sendRequest($url,$type,$params)
    {

        
         $params['api_key']=$this->API_KEY;
         $fields_string = http_build_query($params);
         
      
         // Headers
        $headers = array('User-Agent: CoinbasePHP/v1');
         
        if($this->useOauth)
         {
            if($this->_oauthObject !== null)
            {
            // Use OAuth
             if(time() > $this->_oauthObject["expire_time"]) {
                 throw new CHttpException(404,"The OAuth tokens are expired. Use refreshTokens to refresh them");  
              }   
            }
      
          $headers[] = 'Authorization: Bearer ' . $this->access_token;
           
            
         }
         
      

       
        $ch = curl_init();
       
        curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
       
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch,CURLOPT_CAINFO,dirname(__FILE__) . '/ca-coinbase.crt');

         
       if($type=="GET")
       {
         curl_setopt($ch,CURLOPT_URL, $url."?".$fields_string);
       }
       else if($type=="POST")
       {  
        // curl_setopt($ch,CURLOPT_POST, count($params));
         curl_setopt($ch,CURLOPT_POST, 1);
         curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
         curl_setopt($ch,CURLOPT_URL, $url);
        
       }
       else if($type=="PUT")
       {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch,CURLOPT_URL, $url);
       }
       else if($type=="DELETE")
       {
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
         curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
         curl_setopt($ch,CURLOPT_URL, $url);
       }
      

      $response = curl_exec($ch);
      
      //echo $response;
      //exit;
       
        if($response === false) {
            $error = curl_errno($ch);
            $message = curl_error($ch);
            curl_close($ch);
            throw new CHttpException(404,"Network error " . $message . " (" . $error . ")");
            
        }
        
        // Check status code
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($statusCode != 200) {
            throw new CHttpException($statusCode,$response);
        }

      return(json_decode($response));
    
    }
    
}
