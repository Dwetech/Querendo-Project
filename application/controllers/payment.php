<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function success() {
        $data['payment'] = 'success';
        $data['current'] = 'invoice';
        $this->load->view('payment-view' , $data);
    }
    public function cancelled() {
        $data['payment'] = 'cancelled';
        $data['current'] = 'invoice';
        $this->load->view('payment-view' , $data);
    }

    public function test() {

        $this->load->model(array('payment_log_model','payments_model','balance_model','invoice_model'));


        $invoice_data = $this->invoice_model->get(3);

        print_r($invoice_data);

    }

    public function ipn() {


        $this->load->library('email');
        $this->load->model(array('payment_log_model','payments_model','balance_model','invoice_model','user_model'));
        $this->load->helper('file');



        // STEP 1: read POST data

        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream.
        $raw_post_data = file_get_contents('php://input');

        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode ('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }


        // Step 2: POST IPN data back to PayPal to validate

        $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp-like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
        // the directory path of the certificate as shown below:
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        // inspect IPN validation result and act accordingly

        if (strcmp ($res, "VERIFIED") == 0) {

            // The IPN is verified, process it:
            // check whether the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your Primary PayPal email
            // check that payment_amount/payment_currency are correct
            // process the notification

            // assign posted variables to local variables
            $item_name 		= $_POST['item_name'];
            $item_number 	= $_POST['item_number'];
            $payment_status = $_POST['payment_status'];
            $payment_amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id 		= $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email 	= $_POST['payer_email'];



            $payment_data = array(
                'invoice_id' 	=> $item_number,
                'txn_id'  		=> $txn_id,
                'item_name' 	=> $item_name,
                'item_number' 	=> $item_number,
                'mc_gross'  	=> $payment_amount,
                'mc_currency' 	=> $payment_currency,
                'payment_status'=> $myPost['payment_status'],
                'mc_fee'		=> isset($myPost['mc_fee']) ? $myPost['mc_fee'] : '',
                'first_name'	=> $myPost['first_name'],
                'last_name'		=> $myPost['last_name'],
                'address_street'=> $myPost['address_street'],
                'address_zip'	=> $myPost['address_zip'],
                'address_country_code' => $myPost['address_country_code'],
                'address_name'	=> $myPost['address_name'],
                'address_country'	=> $myPost['address_country'],
                'address_city'	=> $myPost['address_city'],
                'address_state'	=> $myPost['address_state'],
                'receiver_email'=> $myPost['receiver_email'],
                'payer_email'   => $payer_email,
                'payment_date'	=> $myPost['payment_date']
            );

            // Add all the IPN request (incomplete, pending, success etc) log in database
            $this->payment_log_model->add_payment_log($payment_data);

            // Now we will look up into database if we have any invoice with given invoice id.
            // if we find any - we will match this paypal sent data with our own data.
            $invoice_data = $this->invoice_model->get($item_number);
            $user_data    = $this->user_model->get_user_by_id($invoice_data->user_id);


            if(
                $payment_currency 	== 'BRL' || // currency match check
                $receiver_email == $this->settings_model->data['paypal_email']  // receiver match check
            ) {
                // All ok - add this to payment table
                if( strtolower($myPost['payment_status']) == 'completed' && $invoice_data  && $invoice_data->payment == $payment_amount ) {

                    // Add only Completed and verified payment in `payment` database
                    $payment_id = $this->payments_model->add_payment($payment_data);

                    // Now add balance to the `balance` table
                    // This will actually make user add more balance
                    $update_data = array(
                        'status'  => 'paid'
                    );
                    $this->invoice_model->update( $invoice_data->invoice_id, $update_data );

                    $this->email->initialize(array('mailtype'=>'html'));
                    $this->email->from($this->settings_model->data['website_email'], $this->settings_model->data['website_name']);
                    $this->email->to($user_data->email);
                    $this->email->subject('Querendo - Your payment successful');
                    $data['subject'] = 'Your payment for invoice '.$invoice_data->invoice_id.' successfully completed';
                    $data['message'] = '<p>Your payment has been made successfully. You can see your invoice status
                    by <a href="'.base_url('login').'">Sign in</a> to your account.</p>
                    <p>Here is your payment details : - </p>
                    <p>
                        <table>
                        <tr>
                                <th style="text-align: right">Invoice ID:</th>
                                <td width="15"></td>
                                <td>#'.$invoice_data->invoice_id.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Payment ID:</th>
                                <td width="15"></td>
                                <td>#'.$payment_id.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Transaction ID:</th>
                                <td width="15"></td>
                                <td>#'.$txn_id.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Payment Amount:</th>
                                <td></td>
                                <td>'.$payment_amount.' '.$payment_currency.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Payment Status:</th>
                                <td></td>
                                <td>'.$payment_status.'</td>
                            </tr>
                        </table>
                    </p>';
                        $message = $this->load->view('email_view', $data, true);

                        $this->email->message($message);
                        $this->email->send();



                }


            }



        } else if (strcmp ($res, "INVALID") == 0) {
            // IPN invalid, log for manual investigation
        }


    }


}
