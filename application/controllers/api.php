<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Api extends Controller {

    public function __construct()
    {
        parent::Controller();
     
        $this->load->model(array('fatsecret/fsprofile_food','fatsecret/Recipeapi', 'user_model', 'user_food_model','recipes_model','journal_model'));
        $this->load->library(array('Auth', 'form_validation','pagination'));
        $this->load->helper(array('form', 'url', 'strings', 'fsdate', 'ui'));
    }

    public function index()
    {
        $this->load->view("api/api_form");
    }

    public function addUser()
    {
            $myFile = "alchemy_user.xml";
            $fh = fopen($myFile, 'w') or die("can't open file");
            $stringData = '';
            $stringData .= '<?xml version="1.0" encoding="UTF-8" ?>';
                $stringData .= '<flflsRequest version="1.0.0">';
                        $stringData .= '<flflsAccount>';
                                $stringData .= '<flflsAccountUser>cC1106int</flflsAccountUser>';
                                $stringData .= '<flflsAccountPass>yydhfjj</flflsAccountPass>';
                                $stringData .= '<flflsAccountEncryptKey>21232f297a57a5a743894a0e4a801fc3</flflsAccountEncryptKey>';
                        $stringData .= '</flflsAccount>';
                        $stringData .= '<flflsDateOfEntry>2011-06-14</flflsDateOfEntry>';
                        $stringData .= '<flflsPointOfEntry>CC</flflsPointOfEntry>';
                        $stringData .= '<flflsAddCustomer>';
                                $stringData .= '<flflsFirstName>'.$_POST['firstname'].'</flflsFirstName>';
                                $stringData .= '<flflsMiddleName>'.$_POST['middlename'].'</flflsMiddleName>';
                                $stringData .= '<flflsLastName>'.$_POST['lastname'].'</flflsLastName>';
                                $stringData .= '<flflsStreetAddress>'.$_POST['street_address_1'].'</flflsStreetAddress>';
                                $stringData .= '<flflsStreetAddress2>'.$_POST['street_address_2'].'</flflsStreetAddress2>';
                                $stringData .= '<flflsCity>'.$_POST['city'].'</flflsCity>';
                                $stringData .= '<flflsState>'.$_POST['state'].'</flflsState>';
                                $stringData .= '<flflsZip>'.$_POST['zipcode'].'</flflsZip>';
                                $stringData .= '<flflsCountry>'.$_POST['country'].'</flflsCountry>';
                                $stringData .= '<flflsEmail>'.$_POST['email'].'</flflsEmail>';
                                $stringData .= '<flflsCustomerID>{PROVIDA_PROVIDED_FORMAT}</flflsCustomerID>';
                        $stringData .= '</flflsAddCustomer>';
                        $stringData .= '<flflsFailureNotification>';
                                $stringData .= '<flflsEmailTo>sobujarefin@gmail.com, yasir@bglobalsourcing.com</flflsEmailTo>';
                        $stringData .= '</flflsFailureNotification>';
                $stringData .= '</flflsRequest>';
            fwrite($fh, $stringData);
            fclose($fh);


            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://localhost/alchemy/alchemy_user.xml");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            $output_xml = simplexml_load_string($output);

            /*$xml = new XMLReader();
            if ($xml->xml($output_xml, NULL, LIBXML_DTDVALID)) {*/
              if($output_xml->flflsAccount->flflsAccountUser == 'cC1106int' && $output_xml->flflsAccount->flflsAccountPass == 'yydhfjj' && $output_xml->flflsAccount->flflsAccountEncryptKey == '21232f297a57a5a743894a0e4a801fc3'){
                    $sql = 'select * from users where email="'.trim($output_xml->flflsAddCustomer->flflsEmail).'"';
                    $result = mysql_query($sql);
                    $num_rows = mysql_num_rows($result);
                    list($email1, $email2) = split(',', $output_xml->flflsFailureNotification->flflsEmailTo);

                    if($num_rows < 1){
                    $sql_user = "insert into users
                                 set first_name = '".$output_xml->flflsAddCustomer->flflsFirstName."',
                                 middle_name = '".$output_xml->flflsAddCustomer->flflsMiddleName."',
                                 last_name ='".$output_xml->flflsAddCustomer->flflsLastName."',
                                 email ='".$output_xml->flflsAddCustomer->flflsEmail."',
                                 created ='".$output_xml->flflsDateOfEntry."'";
                    if($this->db->query($sql_user)){
                        $sql_adduser = "insert into users_homeaddress
                                 set uid = ".mysql_insert_id().",
                                 street_address = '".$output_xml->flflsAddCustomer->flflsStreetAddress."',
                                 city='".$output_xml->flflsAddCustomer->flflsCity."',
                                 state='".$output_xml->flflsAddCustomer->flflsState."',
                                 zip_code='".$output_xml->flflsAddCustomer->flflsZip."',
                                 country='".$output_xml->flflsAddCustomer->flflsCountry."'";

                        if($this->db->query($sql_adduser)){
                            if(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email1)){
                                $to  = $email1 . ', ';
                            }

                            if(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email2)){
                                $to .= $email2;
                            }
                           
                            $subject = 'About user entry';

                            $message = 'User information has been added successfully';

                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            
                                if(preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $output_xml->flflsAddCustomer->flflsEmail)){
                                    $headers .= 'Cc: '.$output_xml->flflsAddCustomer->flflsEmail. "\r\n";
                                }
                                
                                if(mail($to, $subject, $message, $headers)){
                                    //echo 'A notification mail has been sent to your mail address';
                                    $data['msg'] = 'A notification mail has been sent to this '.$output_xml->flflsAddCustomer->flflsEmail.' mail address';
                                    $this->load->view('api/api_msg', $data);
                                }
                                else{
                                    //echo 'Mail sending failed';
                                    $data['msg'] = 'Mail sending failed';
                                    $this->load->view('api/api_msg', $data);
                                }
                            }
                       }
                    }
                    else{
                        $data['msg'] = 'This user information already inserted';
                        $this->load->view('api/api_msg', $data);
                    }
                }
                else{
                    //die('This file is not authenticated');
                    $data['msg'] = 'This file is not authenticated';
                    $this->load->view('api/api_msg', $data);
                }
            /*}
            else{
                $data['msg'] = 'Not well formated';
                $this->load->view('api/api_msg', $data);
            }*/
    }
}
?>
