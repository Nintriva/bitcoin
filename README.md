Bitcoin
===========
Bitcoin extension incorporates Bitcoin API (Coinbase) into your Yii application.

USAGE:

1.Download the package and extract into your components folder.


2.update components section in config.php

                   'bitcoin' => array(
                                      'class'=>'application.components.bitcoin.Bitcoin',
                                      
                                      'API_KEY' => '',
                                      'CLIENT_SECRET' => '',
                                      'CLIENT_ID' => '', 
                                     
                                      'CALLBACK_URL'=>'site/bitcoinCallback',
                                      
                                      'CANCEL_URL'=>'site/bitcoinCancel',
                                      
                                      'SUCCESS_URL'=>'site/bitcoinSuccess',
 
                                      ),
                          
-----you are done.

Documentation for using this bitcoin component in Yii framework

1.Account Change

    1.1.stdClass Object function getAccountChanges()
        
        purpose:List all changes to your account
  

Usage:

    
    
   $response=Yii::app()->bitcoin->getAccountChanges();

   Response:
    stdClass Object
      (
	  [current_user] => stdClass Object
	      (
		  [id] => 52150505ae4151c1e700002f
		  [email] => sirinibin2006@gmail.com
		  [name] => Sirin k
	      )

	  [balance] => stdClass Object
	      (
		  [amount] => 0.00000000
		  [currency] => BTC
	      )

	  [account_changes] => Array
	      (
	      )

	  [total_count] => 0
	  [num_pages] => 0
	  [current_page] => 1
      )
   
  

2.Account

    2.1.stdClass Object function getBalance()
        
        purpose:Get the user's account balance in BTC.
  

Usage:

    
    
  $response=Yii::app()->bitcoin->getBalance()

   Response:
    stdClass Object
      (
	  [amount] => 0.00000000
	  [currency] => BTC
      )
          
   
  

    2.2.stdClass Object function getReceiveAddress()
        
        purpose:Get the user's current bitcoin receive address
  

Usage:

    
    
      $response=Yii::app()->bitcoin->getReceiveAddress();

   Response:
     stdClass Object
      (
	  [success] => 1
	  [address] => 1H1jPMvyY7Xk6RZGtj4taqWxZYhsEH8ebX
	  [callback_url] => 
      )
       
   
  

    2.3.stdClass Object function generateReceiveAddress()
        
        purpose:Generates a new bitcoin receive address for the user
  

Usage:

    
    
     $response=Yii::app()->bitcoin->generateReceiveAddress();

   Response:
   
        stdClass Object
      (
[success]=> true,
[address]=> muVu2JZo8PbewBHRp6bpqFvVD87qvqEHWA,
[callback_url]=> null
}
    
            
   
  

3.Addresses

    3.1.stdClass Object function getAllAddresses($query=null, $page=0, $limit=null)
        
        purpose:List bitcoin addresses associated with this account
  

Usage:

    
    
  $response=Yii::app()->bitcoin->getAllAddresses();

   Response:
   
      stdClass Object
	(
	    [total_count] => 1
	    [num_pages] => 1
	    [current_page] => 1
	    [addresses] => Array
		(
		    [0] => stdClass Object
			(
			    [address] => 1H1jPMvyY7Xk6RZGtj4taqWxZYhsEH8ebX
			    [callback_url] => 
			    [label] => 
			    [created_at] => 2013-12-16T07:22:45+05:30
			)

		)

	) 
  

4.Button

    4.1.stdClass Object function  createButton($name, $price, $currency, $custom=null, $options=array())
        
        purpose:Create a new payment button, page, or iFrame
  

Usage:

    
    
       $response=Yii::app()->bitcoin->createButton("Buy now", "50", "USD", null, array());

   Response:
         stdClass Object
(
    [button] => stdClass Object
        (
            [code] => 4e277b6f17669860d1417e0cc0b8e432
            [type] => buy_now
            [style] => buy_now_large
            [text] => Pay With Bitcoin
            [name] => Buy now
            [description] => 
            [custom] => 
            [callback_url] => 
            [success_url] => 
            [cancel_url] => 
            [info_url] => 
            [price] => stdClass Object
                (
                    [cents] => 5000
                    [currency_iso] => USD
                )

            [variable_price] => 
            [choose_price] => 
            [include_address] => 
            [include_email] => 
        )

    [embedHtml] => 
    [success] => 1
)
              
  

    4.2.stdClass Object function createButtonOrder($code)
        
        purpose:Create an order for this button
  

Usage:

    
    
  $response=Yii::app()->bitcoin->createButtonOrder("4e277b6f17669860d1417e0cc0b8e432");

   Response:
     stdClass Object
	(
	    [success] => 1
	    [order] => stdClass Object
		(
		    [id] => MI2IHCCZ
		    [created_at] => 2013-12-16T16:47:37+05:30
		    [status] => new
		    [total_btc] => stdClass Object
			(
			    [cents] => 6125000
			    [currency_iso] => BTC
			)

		    [total_native] => stdClass Object
			(
			    [cents] => 5000
			    [currency_iso] => USD
			)

		    [custom] => 
		    [receive_address] => 14PkDvMBsyjeKGoYeRm5A8WgNv3cw5TbQz
		    [button] => stdClass Object
			(
			    [type] => buy_now
			    [name] => Buy now
			    [description] => 
			    [id] => 4e277b6f17669860d1417e0cc0b8e432
			)

		    [transaction] => 
		)

	)
   
                   
   
  

5.Buys

    5.1.stdClass Object function buy($amount, $agreeBtcAmountVaries=false)
        
        purpose:Purchase bitcoin by debiting your U.S. bank account
  

Usage:

    
    
     $response=Yii::app()->bitcoin->buy(1, true);

       Response:
         stdClass Object
(
    [success] => 1
    [transfer] => stdClass Object
        (
            [type] => Buy
            [code] => 6H7GYLXZ
            [created_at] => 2013-01-28T16:08:58-08:00
            [fees] => stdClass Object
                (
                    [coinbase] => stdClass Object
                        (
                            [cents] => 14
                            [currency_iso] => USD
                        )

                    [bank] => stdClass Object
                        (
                            [cents] => 15
                            [currency_iso] => USD
                        )

                )

            [status] => created
            [payout_date] => 2013-02-01T18:00:00-08:00
            [btc] => stdClass Object
                (
                    [amount] => 1.00000000
                    [currency] => BTC
                )

            [subtotal] => stdClass Object
                (
                    [amount] => 13.55
                    [currency] => USD
                )

            [total] => stdClass Object
                (
                    [amount] => 13.84
                    [currency] => USD
                )

        )

)
      note: for buying a bitcoin you have to do 2 following things.
            1.Verify Your bank account with Bitcoin.
            2.Verify Your mobile number with Bitcoin.
         if you havnt done this you will get an response format like below:
       
  
       stdClass Object
	  (
	      [success] => 
	      [errors] => Array
		  (
		      [0] => Payment method can't be blank
		      [1] => You must verify a phone number on your account
		  )

	      [transfer] => stdClass Object
		  (
		      [id] => 52aee3018bf6feb7840000a5
		      [created_at] => 
		      [fees] => stdClass Object
			  (
			      [coinbase] => stdClass Object
				  (
				      [cents] => 1639
				      [currency_iso] => USD
				  )

			      [bank] => stdClass Object
				  (
				      [cents] => 15
				      [currency_iso] => USD
				  )

			  )

		      [payout_date] => 
		      [transaction_id] => 
		      [_type] => AchDebit
		      [code] => 52aee3018bf6feb7840000a5
		      [type] => Buy
		      [status] => Pending
		      [btc] => stdClass Object
			  (
			      [amount] => 2.00000000
			      [currency] => BTC
			  )

		      [subtotal] => stdClass Object
			  (
			      [amount] => 1639.20
			      [currency] => USD
			  )

		      [total] => stdClass Object
			  (
			      [amount] => 1655.74
			      [currency] => USD
			  )

		      [description] => 
		  )

	  )
 
                
  

6.Contacts

    stdClass Object function getContacts($query=null, $page=0, $limit=null)
        
        purpose:List emails the user has previously used for autocompletion.
  

Usage:

    
    
      $response=Yii::app()->bitcoin->getContacts(null, 0, null);

   Response:
   
        stdClass Object
(
    [contacts] => Array
        (
            [0] => stdClass Object
                (
                    [contact] => stdClass Object
                        (
                            [email] => user1@example.com
                        )

                )

            [1] => stdClass Object
                (
                    [contact] => stdClass Object
                        (
                            [email] => user2@example.com
                        )

                )

        )

    [total_count] => 2
    [num_pages] => 1
    [current_page] => 1
)
                
      
  

7.Currencies

    7.1.stdClass Object function getCurrencies()
        
        purpose:Show currencies supported by Coinbase.
  

Usage:

   Response:
    Array
	(
	    [0] => stdClass Object
		(
		    [name] => Afghan Afghani (AFN)
		    [iso] => AFN
		)

	    [1] => stdClass Object
		(
		    [name] => Albanian Lek (ALL)
		    [iso] => ALL
		)

	    [2] => stdClass Object
		(
		    [name] => Algerian Dinar (DZD)
		    [iso] => DZD
		)

	    [3] => stdClass Object
		(
		    [name] => Angolan Kwanza (AOA)
		    [iso] => AOA
		)

	    [4] => stdClass Object
		(
		    [name] => Argentine Peso (ARS)
		    [iso] => ARS
		)

	    [5] => stdClass Object
		(
		    [name] => Armenian Dram (AMD)
		    [iso] => AMD
		)
	    .....upto 160 Currencies as of now.try it out to see all in the list.	
	) 
 
                
  

    7.2.stdClass Object function getExchangeRate($from=null, $to=null)
        
        purpose:Show exchange rates between BTC and other currencies
  

Usage:

    
      $response=Yii::app()->bitcoin->getExchangeRate(null, null);

   Response:
   stdClass Object
    (
	[gbp_to_usd] => 1.633667
	[usd_to_bwp] => 8.62852
	[usd_to_azn] => 0.784167
	[eur_to_usd] => 1.35924
	[usd_to_czk] => 20.11621
	[czk_to_btc] => 6.2e-05
	[btc_to_mga] => 1816130.167664
	[btc_to_djf] => 143630.629233
	[idr_to_btc] => 0.0
	[mnt_to_usd] => 0.00058
	[usd_to_ngn] => 158.682199
	[usd_to_gbp] => 0.61212
	[irr_to_btc] => 0.0
	[ils_to_usd] => 0.282751
	[ars_to_usd] => 0.163763
	[usd_to_uyu] => 21.16168
	[uyu_to_btc] => 5.9e-05
	[pyg_to_btc] => 0.0
	[usd_to_yer] => 215.006099
	.....try this example to see all in the list.
     )    
                  
   
  

8.Orders

    8.1.stdClass Object function getOrders($page=0)
        
        purpose:List merchant orders received
  

Usage:

    
    $response=Yii::app()->bitcoin->getOrders();

   Response:
       stdClass Object
(
    [orders] => Array
        (
            [0] => stdClass Object
                (
                    [order] => stdClass Object
                        (
                            [id] => A7C52JQT
                            [created_at] => 2013-03-11T22:04:37-07:00
                            [status] => completed
                            [total_btc] => stdClass Object
                                (
                                    [cents] => 100000000
                                    [currency_iso] => BTC
                                )

                            [total_native] => stdClass Object
                                (
                                    [cents] => 3000
                                    [currency_iso] => USD
                                )

                            [custom] => 
                            [button] => stdClass Object
                                (
                                    [type] => buy_now
                                    [name] => Order #1234
                                    [description] => order description
                                    [id] => eec6d08e9e215195a471eae432a49fc7
                                )

                            [transaction] => stdClass Object
                                (
                                    [id] => 513eb768f12a9cf27400000b
                                    [hash] => 4cc5eec20cd692f3cdb7fc264a0e1d78b9a7e3d7b862dec1e39cf7e37ababc14
                                    [confirmations] => 0
                                )

                        )

                )

        )

    [total_count] => 1
    [num_pages] => 1
    [current_page] => 1
)
               
  

    8.2.stdClass Object function getOrder($id)
        
        purpose:Show an individual merchant order
  

Usage:

    
     $response=Yii::app()->bitcoin->getOrder("A7C52JQT");

   Response:
   stdClass Object
(
    [order] => stdClass Object
        (
            [id] => A7C52JQT
            [created_at] => 2013-03-11T22:04:37-07:00
            [status] => completed
            [total_btc] => stdClass Object
                (
                    [cents] => 10000000
                    [currency_iso] => BTC
                )

            [total_native] => stdClass Object
                (
                    [cents] => 10000000
                    [currency_iso] => BTC
                )

            [custom] => 
            [button] => stdClass Object
                (
                    [type] => buy_now
                    [name] => test
                    [description] => 
                    [id] => eec6d08e9e215195a471eae432a49fc7
                )

            [transaction] => stdClass Object
                (
                    [id] => 513eb768f12a9cf27400000b
                    [hash] => 4cc5eec20cd692f3cdb7fc264a0e1d78b9a7e3d7b862dec1e39cf7e37ababc14
                    [confirmations] => 0
                )

        )

)
                      
  

9.PRICES

    9.1.float function getBuyPrice($qty=1)
        
        purpose:Get the total buy price for some bitcoin amount
  

Usage:

    
     $response=Yii::app()->bitcoin->getBuyPrice(1);

   Response:820.27
       
                 
   
  

    9.2.float Object function getSellPrice($qty=1)
        
        purpose:Get the total sell price for some bitcoin amount
  

Usage:

    
    
      $response=Yii::app()->bitcoin->getSellPrice(1);

   Response:796.75
         
               
   
  

    9.3.stdClass Object function getSpotPrice($currency=null)
        
        purpose:Get the spot price of bitcoin.
  

Usage:

    
    
       $response=Yii::app()->bitcoin->getSpotPrice("INR");

   Response:
     stdClass Object
      (
	  [amount] => 50161.23
	  [currency] => INR
      )
          
            
   
  

10.Recurring Payments

    10.1.stdClass Object function getRecurringPayments()
        
        purpose:List your recurring payment
  

Usage:

    
     $response=Yii::app()->bitcoin->getRecurringPayments()

   Response:
    stdClass Object
(
    [recurring_payments] => Array
        (
            [0] => stdClass Object
                (
                    [recurring_payment] => stdClass Object
                        (
                            [id] => 51a7b9e9f8182b4b22000013
                            [type] => send
                            [status] => active
                            [created_at] => 2013-05-30T13:43:21-07:00
                            [to] => user2@example.com
                            [from] => 
                            [start_type] => now
                            [times] => -1
                            [times_run] => 7
                            [repeat] => monthly
                            [last_run] => 2013-05-30T13:00:00-07:00
                            [next_run] => 2013-06-30T13:00:00-07:00
                            [notes] => 
                            [description] => Send 0.02 BTC to User Two
                            [amount] => stdClass Object
                                (
                                    [amount] => 0.02000000
                                    [currency] => BTC
                                )

                        )

                )

            [1] => stdClass Object
                (
                    [recurring_payment] => stdClass Object
                        (
                            [id] => 5193377ef8182b7c19000015
                            [type] => request
                            [status] => completed
                            [created_at] => 2013-05-15T00:21:34-07:00
                            [to] => 
                            [from] => user1@example.com
                            [start_type] => now
                            [times] => 3
                            [times_run] => 3
                            [repeat] => daily
                            [last_run] => 2013-05-15T00:22:57-07:00
                            [next_run] => 2013-05-16T00:22:57-07:00
                            [notes] => 
                            [description] => Request 0.01 BTC from user1@example.com
                            [amount] => stdClass Object
                                (
                                    [amount] => 0.01000000
                                    [currency] => BTC
                                )

                        )

                )

        )

    [total_count] => 2
    [num_pages] => 1
    [current_page] => 1
)
     
            
   
  

    10.2.stdClass Object function getRecurringPayment($id)
        
        purpose:Show an individual recurring payment
  

Usage:

    
    
     $response=Yii::app()->bitcoin->getRecurringPayments("5193377ef8182b7c19000015");

   Response:
     stdClass Object
(
    [recurring_payment] => stdClass Object
        (
            [id] => 5193377ef8182b7c19000015
            [type] => send
            [status] => active
            [created_at] => 2013-05-30T13:43:21-07:00
            [to] => user2@example.com
            [from] => 
            [start_type] => now
            [times] => -1
            [times_run] => 7
            [repeat] => monthly
            [last_run] => 2013-05-30T13:00:00-07:00
            [next_run] => 2013-06-30T13:00:00-07:00
            [notes] => 
            [description] => Send 0.02 BTC to User Two
            [amount] => stdClass Object
                (
                    [amount] => 0.02000000
                    [currency] => BTC
                )

        )

)
              
   
  

11.Sells

    11.1.stdClass Object function sell($amount)
        
        purpose:Sell bitcoin and receive a credit to your U.S. bank account
  

Usage:

    
    
     $response=Yii::app()->bitcoin->sell(1);

   Response:
    stdClass Object
(
    [success] => 1
    [transfer] => stdClass Object
        (
            [type] => Sell
            [code] => RD2OC8AL
            [created_at] => 2013-01-28T16:32:35-08:00
            [fees] => stdClass Object
                (
                    [coinbase] => stdClass Object
                        (
                            [cents] => 14
                            [currency_iso] => USD
                        )

                    [bank] => stdClass Object
                        (
                            [cents] => 15
                            [currency_iso] => USD
                        )

                )

            [status] => created
            [payout_date] => 2013-02-01T18:00:00-08:00
            [btc] => stdClass Object
                (
                    [amount] => 1.00000000
                    [currency] => BTC
                )

            [subtotal] => stdClass Object
                (
                    [amount] => 13.50
                    [currency] => USD
                )

            [total] => stdClass Object
                (
                    [amount] => 13.21
                    [currency] => USD
                )

        )

)
             
   
  

12.Subscribers

    12.1.stdClass Object function getSubscribers()
        
        purpose:List customer subscriptions.
  

Usage:

    
    
    $response=Yii::app()->bitcoin->getSubscribers();

   Response:
   
     stdClass Object
(
    [recurring_payments] => Array
        (
            [0] => stdClass Object
                (
                    [recurring_payment] => stdClass Object
                        (
                            [id] => 51a7cf58f8182b4b220000d5
                            [created_at] => 2013-05-30T15:14:48-07:00
                            [status] => active
                            [custom] => user123
                            [button] => stdClass Object
                                (
                                    [type] => subscription
                                    [name] => Test
                                    [description] => 
                                    [id] => 1b7a1019f371402ec02af389d1b24e55
                                )

                        )

                )

            [1] => stdClass Object
                (
                    [recurring_payment] => stdClass Object
                        (
                            [id] => 51a7be2ff8182b4b220000a5
                            [created_at] => 2013-05-30T14:01:35-07:00
                            [status] => paused
                            [custom] => user456
                            [button] => stdClass Object
                                (
                                    [type] => subscription
                                    [name] => Test
                                    [description] => 
                                    [id] => 1b7a1019f371402ec02af389d1b24e55
                                )

                        )

                )

        )

    [total_count] => 2
    [num_pages] => 1
    [current_page] => 1
)
                    
    
  

    12.2.stdClass Object function getSubscriber($id)
        
        purpose:Show an individual customer subscription
  

Usage:

    
    
       $response=Yii::app()->bitcoin->getSubscriber("51a7cf58f8182b4b220000d5");

   Response:
      stdClass Object
(
    [recurring_payment] => stdClass Object
        (
            [id] => 51a7cf58f8182b4b220000d5
            [created_at] => 2013-05-30T15:14:48-07:00
            [status] => active
            [custom] => user123
            [button] => stdClass Object
                (
                    [type] => subscription
                    [name] => Test
                    [description] => 
                    [id] => 1b7a1019f371402ec02af389d1b24e55
                )

        )

)
        
   
     

13.Tokens

    13.1.stdClass Object function createToken()
        
        purpose:Create a token which can be redeemed for bitcoin
  

Usage:

    
    
     Yii::app()->bitcoin->createToken();

   Response:
        stdClass Object
(
    [success] => 1
    [token] => stdClass Object
        (
            [token_id] => abc12e821cf6e128afc2e821cf68e12cf68e168e128af21cf682e821cf68e1fe
            [address] => n3NzN74qGYHSHPhKM1hdts3bF1zV4N1Aa3
        )

)
    
   
  

    13.2.stdClass Object function redeemToken($token_id)
        
        purpose:Redeem a token, claiming its address and all its bitcoins
  

Usage:

    
    
   Yii::app()->bitcoin->redeemToken("abc12e821cf6e128afc2e821cf68e12cf68e168e128af21cf682e821cf68e1fe");

   Response:
           stdClass Object
(
    [success] => 1
)
 
   
  

14.Transactions

    14.1.stdClass Object function getTransactions()
        
        purpose:List a user's recent transactions
  

Usage:

        
     Yii::app()->bitcoin->getTransactions();

   Response:
      stdClass Object
(
    [current_user] => stdClass Object
        (
            [id] => 5011f33df8182b142400000e
            [email] => user2@example.com
            [name] => User Two
        )

    [balance] => stdClass Object
        (
            [amount] => 50.00000000
            [currency] => BTC
        )

    [total_count] => 2
    [num_pages] => 1
    [current_page] => 1
    [transactions] => Array
        (
            [0] => stdClass Object
                (
                    [transaction] => stdClass Object
                        (
                            [id] => 5018f833f8182b129c00002f
                            [created_at] => 2012-08-01T02:34:43-07:00
                            [amount] => stdClass Object
                                (
                                    [amount] => -1.10000000
                                    [currency] => BTC
                                )

                            [request] => 1
                            [status] => pending
                            [sender] => stdClass Object
                                (
                                    [id] => 5011f33df8182b142400000e
                                    [name] => User Two
                                    [email] => user2@example.com
                                )

                            [recipient] => stdClass Object
                                (
                                    [id] => 5011f33df8182b142400000a
                                    [name] => User One
                                    [email] => user1@example.com
                                )

                        )

                )

            [1] => stdClass Object
                (
                    [transaction] => stdClass Object
                        (
                            [id] => 5018f833f8182b129c00002e
                            [created_at] => 2012-08-01T02:36:43-07:00
                            [hsh] => 9d6a7d1112c3db9de5315b421a5153d71413f5f752aff75bf504b77df4e646a3
                            [amount] => stdClass Object
                                (
                                    [amount] => -1.00000000
                                    [currency] => BTC
                                )

                            [request] => 
                            [status] => complete
                            [sender] => stdClass Object
                                (
                                    [id] => 5011f33df8182b142400000e
                                    [name] => User Two
                                    [email] => user2@example.com
                                )

                            [recipient_address] => 37muSN5ZrukVTvyVh3mT5Zc5ew9L9CBare
                        )

                )

        )

)
            
   
  

    14.2.stdClass Object function getTransaction($id)
        
        purpose:Show details for an individual transaction
  

Usage:

    
    
        Yii::app()->bitcoin->getTransaction("5018f833f8182b129c00002f");

   Response:
         stdClass Object
(
    [transaction] => stdClass Object
        (
            [id] => 5018f833f8182b129c00002f
            [created_at] => 2012-08-01T02:34:43-07:00
            [amount] => stdClass Object
                (
                    [amount] => -1.10000000
                    [currency] => BTC
                )

            [request] => 1
            [status] => pending
            [sender] => stdClass Object
                (
                    [id] => 5011f33df8182b142400000e
                    [name] => User Two
                    [email] => user2@example.com
                )

            [recipient] => stdClass Object
                (
                    [id] => 5011f33df8182b142400000a
                    [name] => User One
                    [email] => user1@example.com
                )

        )

)
   
   
  

    14.3.stdClass Object function sendMoney($to, $amount, $notes=null, $userFee=null, $amountCurrency=null)
        
        purpose:Send bitcoins to an email address or bitcoin address
  

Usage:

    
    
      Yii::app()->bitcoin->sendMoney("user1@example.com","1.234",null, null, "USD");

   Response:
    stdClass Object
(
    [success] => 1
    [transaction] => stdClass Object
        (
            [id] => 501a1791f8182b2071000087
            [created_at] => 2012-08-01T23:00:49-07:00
            [hsh] => 9d6a7d1112c3db9de5315b421a5153d71413f5f752aff75bf504b77df4e646a3
            [notes] => Sample transaction for you!
            [amount] => stdClass Object
                (
                    [amount] => -1.23400000
                    [currency] => BTC
                )

            [request] => 
            [status] => pending
            [sender] => stdClass Object
                (
                    [id] => 5011f33df8182b142400000e
                    [name] => User Two
                    [email] => user2@example.com
                )

            [recipient] => stdClass Object
                (
                    [id] => 5011f33df8182b142400000a
                    [name] => User One
                    [email] => user1@example.com
                )

            [recipient_address] => 37muSN5ZrukVTvyVh3mT5Zc5ew9L9CBare
        )

)
        
   
  

    14.4.stdClass Object function requestMoney($from, $amount, $notes=null, $amountCurrency=null)
        
        purpose:Send an invoice/money request to an email address
  

Usage:

    
    
     Yii::app()->bitcoin->requestMoney("user1@example.com","1.234",null, "USD");

   Response:
       stdClass Object
(
    [success] => 1
    [transaction] => stdClass Object
        (
            [id] => 501a3554f8182b2754000003
            [created_at] => 2012-08-02T01:07:48-07:00
            [hsh] => 
            [notes] => Sample request for you!
            [amount] => stdClass Object
                (
                    [amount] => 1.23400000
                    [currency] => BTC
                )

            [request] => 1
            [status] => pending
            [sender] => stdClass Object
                (
                    [id] => 5011f33df8182b142400000a
                    [name] => User One
                    [email] => user1@example.com
                )

            [recipient] => stdClass Object
                (
                    [id] => 5011f33df8182b142400000e
                    [name] => User Two
                    [email] => user2@example.com
                )

        )

)
     
   
  

    14.5.stdClass Object function resendRequest($id)
        
        purpose:Resend emails for a money request
  

Usage:

    
    
    Yii::app()->bitcoin->resendRequest("501a3554f8182b2754000003");

   Response:
    stdClass Object
       (
        "success"=>true
       )
               
   
  

    14.6.stdClass Object  function cancelRequest($id)
        
        purpose:Cancel a money request
  

Usage:

    
    
    Yii::app()->bitcoin->cancelRequest("501a3554f8182b2754000003");

   Response:
   
     stdClass Object
       (
        "success"=>true
       )
          
   
  

    14.7.stdClass Object function completeRequest($id)
        
        purpose:Complete a money request
  

Usage:

    
    
    Yii::app()->bitcoin->completeRequest("501a3554f8182b2754000003");

   Response:
      stdClass Object
(
    [success] => 
    [errors] => Array
        (
            [0] => Only the sender can complete a money request.
        )

    [transaction] => stdClass Object
        (
            [id] => 503c46a3f8182b106500009b
            [created_at] => 
            [hsh] => 
            [notes] => 
            [amount] => stdClass Object
                (
                    [amount] => 0.00000000
                    [currency] => BTC
                )

            [request] => 
            [status] => pending
            [recipient] => 
            [sender] => 
        )

)
      
   
  

15.Users

    15.1.stdClass Object function createUser($email, $password)
        
        purpose:Create or signup a new user
  

Usage:

    
    
    Yii::app()->bitcoin->createUser("newuser@example.com", "test");

   Response:
      stdClass Object
(
    [success] => 1
    [user] => stdClass Object
        (
            [id] => 501a3d22f8182b2754000011
            [name] => New User
            [email] => newuser@example.com
            [receive_address] => mpJKwdmJKYjiyfNo26eRp4j6qGwuUUnw9x
        )

)
      
   
  

    15.2.stdClass Object function getUserAccountSettings($email, $password)
        
        purpose:Show current user with account settingsr
  

Usage:

    
    
    Yii::app()->bitcoin->getUserAccountSettings("user1@example.com", "test");

   Response:
      stdClass Object
(
    [users] => Array
        (
            [0] => stdClass Object
                (
                    [user] => stdClass Object
                        (
                            [id] => 512db383f8182bd24d000001
                            [name] => User One
                            [email] => user1@example.com
                            [time_zone] => Pacific Time (US & Canada)
                            [native_currency] => USD
                            [balance] => stdClass Object
                                (
                                    [amount] => 49.76000000
                                    [currency] => BTC
                                )

                            [buy_level] => 1
                            [sell_level] => 1
                            [buy_limit] => stdClass Object
                                (
                                    [amount] => 10.00000000
                                    [currency] => BTC
                                )

                            [sell_limit] => stdClass Object
                                (
                                    [amount] => 100.00000000
                                    [currency] => BTC
                                )

                        )

                )

        )

)
      
   
  

    15.3.stdClass Object updateUserAccountSettings($id,$user_details)
        
        purpose:Update account settings for current user
  

Usage:

    
    $user_details=array(
     stdClass Object
(
    [user] => stdClass Object
        (
            [id] => 512db383f8182bd24d000001
            [name] => User One
            [email] => goodemail@example.com
            [time_zone] => Pacific Time (US & Canada)
            [native_currency] => USD
            [buy_level] => 1
            [sell_level] => 1
            [balance] => stdClass Object
                (
                    [amount] => 49.76000000
                    [currency] => BTC
                )
 
            [buy_limit] => stdClass Object
                (
                    [amount] => 10.00000000
                    [currency] => BTC
                )
 
            [sell_limit] => stdClass Object
                (
                    [amount] => 100.00000000
                    [currency] => BTC
                )
 
        )
 
)
    );    
    Yii::app()->bitcoin->updateUserAccountSettings("512db383f8182bd24d000001",$user_details);

   Response:
      stdClass Object
(
    [success] => 1
    [user] => stdClass Object
        (
            [id] => 512db383f8182bd24d000001
            [name] => User One
            [email] => goodemail@example.com
            [time_zone] => Pacific Time (US & Canada)
            [native_currency] => USD
            [buy_level] => 1
            [sell_level] => 1
            [balance] => stdClass Object
                (
                    [amount] => 49.76000000
                    [currency] => BTC
                )

            [buy_limit] => stdClass Object
                (
                    [amount] => 10.00000000
                    [currency] => BTC
                )

            [sell_limit] => stdClass Object
                (
                    [amount] => 100.00000000
                    [currency] => BTC
                )

        )

)
      
   
  

16.Ask UserPersmission

    16.1. function askPermission($scope)
        
        purpose:Ask UserPersmission to manage his/her bitcoin account
  

Usage:

    
     $scope=array(
       'all'
     );    
    Yii::app()->bitcoin->askPermission($scope);

17.get AccessToken

    17.1.function getAccessToken($code)
        
        purpose:Get AccessToken of a user to manage his/her bitcoin account.
  

Usage:

    
 
    Yii::app()->bitcoin->getAccessToken($code);

   Response:
      stdClass Object
(
    [access_token] => ...
    [refresh_token] => ...
    [token_type] => bearer
    [expire_in] => 7200
    [scope] => universal
)
      
   
  