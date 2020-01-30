<?php
defined('BASEPATH') OR exit('no direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH.'/libraries/REST_Controller.php');
/**
* REST API
*/
class Api extends REST_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model(['page_model','user_model','login_model','post_model','admin_model']);
    
  }

  function skip_logics_get()
  {
    
    $data = $this->admin_model->get_all_skip_logics();

    $result = array();
    $count = 0;
    foreach ($data as $key) {
      $result[$count]['formId'] = (int) $key['form_id'];
      $cq = explode('||_||',$key['question']);
      $result[$count]['checkQuestionDesc'] = $cq[0];
      $result[$count]['checkQuestionId'] = $cq[1];
      $result[$count]['checkCondition'] = $key['check_condition'];
      $result[$count]['checkValue'] = $key['check_value'];
      $sq = explode('||_||', $key['skip_columns']);
      $result[$count]['showOrHideQuestion'] = $sq[0];
      $result[$count]['showOrHideQuestionId'] = $sq[1];
    $count++;
    }
    
    $this->response( $result );

die;
  }
  
  function upload_post()
  { 

      $this->load->helper('file');
      // $data = json_encode($_POST);
      // write_file('./uploads/logs.php', $data);

      if ( $_FILES['picture']['size'] > 0 ) {
        $filename = $_FILES['picture']['name'];

        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('picture'))
        {
                $error = $this->upload->display_errors();

                $this->response($error, 400);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());

                

                $this->response('Successfully updated the image', 200);
        }

      }else{
        $this->response('No file selected', 400);
      }
    
  }

  function insert_post()
  {  
    

    $input_data = trim(file_get_contents('php://input')); //If RAW
    $a = json_decode($input_data,TRUE);
    $sets = $a['data'];
    $input_user_id = $a['userId']; 


    //Get username from input_user_id
    $resultuser = $this->admin_model->get_user_by_id($input_user_id);
    $submittedBy = '';
    if (count($resultuser) > 0) {
      $submittedBy = $resultuser['firstname'] . ' '. $resultuser['lastname'] . ' ('. $resultuser['user_name'] .')';
    }
    
    // print_r($a['infoData']);

    $return = array();
    foreach($sets as $val) {
        $return[$val['filledId']][] = $val;
    }
    $info = array();
    foreach ($a['infoData'] as $infokey) {
      $info[ $infokey['filledFormId'] ][] = $infokey;
    } 
    $a = '';$d = '';
    foreach ($return as $rkey => $value) {
      
      $answer = [];
      $question = []; 
      $questiontype = [];
      foreach ($value as $ans ) {
      
      if ( array_key_exists('answer', $ans) ) {
          
          if ( strpos($ans['answer'], '.jpg') != false) {
            $answer[] = base_url().'uploads/'.$ans['answer'];
          }else{
            $answer[] = $ans['answer'];  
          }
        }else{
          $answer[] = "";
        }  
        
        $question[] = $ans['questionId'];
        $questiontype[] = $ans['questionType'];
      }
      
      $form_id = $value[0]['formId'];
      $tablename = $this->post_model->get_table_name_by_id($form_id);
      
      //Get types by id
      $tts = $this->admin_model->get_table_by_id($form_id);
      $table = $tts[0];

      $answerData = array_combine($question,$answer);
      
      $fields = explode( ',', $table['fields'] );
      $types = explode( ',', $table['types'] );
      
      $i = 0;
      $newtype = [];
      foreach ($types as $key) {
        if ($key == 'legend' ) {
          unset($types[$i]);
        }else{
          $newtype[] = $key;  
        }
        $i++;
      }
      
      $new_answers = [];
      $count = 0;
      foreach ($answerData as $akey => $aval) {
       
        $in_type = $newtype[$count];
        
        if ( $questiontype[$count] == 'Radio' ) 
        {
          $vals = $this->admin_model->get_values_by_tableid_and_name($form_id,$in_type);
          
          $tocheck = explode('|', $vals[0]['vals'] );
          $answerData[$akey] = $tocheck[ $answer[$count] ];
        }
        if ( $questiontype[$count] == 'Checkbox' )
        {
          $vals = $this->admin_model->get_values_by_tableid_and_name($form_id,$in_type);

          $tocheck = explode('|', $vals[0]['vals'] );
          $checkvalue = explode(',', $answerData[$akey] );
          
          $newcheckvalue = [];  
          $chk_count = 0;
          foreach ( array_filter($checkvalue) as $chkkey ) {
            
            $newcheckvalue[] = $tocheck[$chkkey];

            $chk_count++;
          }
          $answerData[$akey] = implode(',', $newcheckvalue);
        }
        
        $count++;
      }
      $answerData['surveyDuration'] = $info[$rkey][0]['duration'];
      $answerData['submittedDate'] = $info[$rkey][0]['date'];
      
      $userid = $value[0]['filledId'];
      
      $answerData['user_id'] = $input_user_id;
      $answerData['filledId'] = $userid;
      $answerData['submittedBy'] = $submittedBy;
      
      
      $nick = $this->post_model->get_data_by_filled_id($input_user_id,$tablename,$userid,$info[$rkey][0]['duration'],$submittedBy,$info[$rkey][0]['date']);
      
      if ($nick == false) {
       $anss = $this->post_model->insert_form($tablename, $answerData);
      }
    }//Loop for $return

    $this->response('Succesfully inserted data', 200);

    
    
  }

  function chkLogin_post()
  {
    $user_name = $this->post('username');
    $user_password = sha1( $this->post('password') );
    $login_condition = array("user_name"=>$user_name, "user_password"=>$user_password, "status"=>'active');

    $result = $this->user_model->userLogin($login_condition);
    if ($result['user_id']) 
    {
      $this->response("Success", 200);
    }else{
      $this->response("Wrong username or password", 401);
      }
  }
  
  function login_post()
  {
    
    $user_name = $this->post('username');
    $user_password = sha1( $this->post('password') );
    $login_condition = array("user_name"=>$user_name, "user_password"=>$user_password, "status"=>'active');

    $result = $this->user_model->userLogin($login_condition);
    if ($result['user_id']) 
    {

      $response = $this->login_model->set_token($result['user_id']);
      $this->response($response, 200);
    }
    else
    {
      $this->response("Wrong username or password", 401);
    }

  }

  /*
  Response from server User-ID and token
  If token is not needed to delete just use expired_at
  */
  public function logout_post()
  {
    $uid = $this->input->get_request_header('User-ID', TRUE);
    // $token = $this->post('token');
    // $this->response($uid, 200);
    $response = $this->login_model->logout($uid);
    $this->response($response, 200);

  }

  function allQuestionSets_get()
  {

    $a = $this->page_model->get_tables();
    $allsets = $this->admin_model->get_sets();
    if (empty($a)) {
      $this->response("No form have been created yet.", 400);
    }
    

    $set = [];
    $count = 0;
    foreach ($allsets as $s) {
      //Main Loop for all sets
      $set[$count]['setID'] = $s['id'];
      $set[$count]['setName'] = $s['set_name'];
      $set[$count]['forms'] = [];
      $questionids = $s['question_id'];
      $qarray = explode(', ', $questionids);
      
      //Get loop $a fields names here
      $i = 0;
      foreach ($a as $form) {
        //formid
        $formID = $form['id'];
        //formname
        $formName = $form['title'];
        foreach( $qarray as $qids )
        {
          //First check if question is in the set
          $comb = [];
          if ( $formID == $qids ) {
            //Then add form to array
            $set[$count]['forms'][$i]['formID'] = $formID;
            $set[$count]['forms'][$i]['formName'] = $formName;
            $set[$count]['forms'][$i]['questions'] = [];

            //Get form fields,types,values from formID
            $tdata = $this->page_model->get_table_by_id($qids);
            $tvalues = $this->page_model->get_table_values_by_id($qids);
           
            $tids = $tdata[0]['fields'];
            $fields = explode(',', $tids);
            
            $ttypes = $tdata[0]['types'];
            $types = explode(',', $ttypes);
            
            $tdescs = $tdata[0]['nepali_title'];
            $display_name = explode(', ',$tdescs);

            $comb = array_combine($fields, $types);

            //For display name removing legends
            foreach($display_name as $k => $v)
            {
              if($v == 'legend')
              {
                unset($display_name[$k]);
                foreach ($fields as $kk => $vv)
                {
                  if($kk == $k){
                    unset($fields[$kk]);
                  }
                }
              }else{
                $new_display_name[] = $v;
              }
            }

            
            $j = 0;
            foreach ($comb as $key => $value) {
              

              if ($value == 'legend') {
                $legend_name = '';
                $legend_name  = $key;
                
                unset($comb[$legend_name]);
              }
              if($key != $legend_name){
                $set[$count]['forms'][$i]['questions'][$j]['id'] = $key;
                $set[$count]['forms'][$i]['questions'][$j]['group'] = $legend_name;
                //For Types
                if ($value == 'VARCHAR'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Text';
                }elseif ($value == 'DATE'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Date';
                }elseif ($value == 'signature'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Signature';
                }elseif ($value == 'Decimal'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Decimal';
                }elseif ($value == 'INT'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Number';
                }elseif ($value == 'gps'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'gps';
                }elseif ($value == 'qrcode'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'qrcode';
                }elseif ($value == 'file'){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'file';
                }elseif ( strpos($value,'radio') !== FALSE ){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Radio';
                }elseif ( strpos($value,'dropdown') !== FALSE ){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Dropdown';
                }elseif ( strpos($value,'TEXT') !== FALSE ){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Textarea';
                }elseif ( strpos($value,'checkbox') !== FALSE ){
                  $set[$count]['forms'][$i]['questions'][$j]['type'] = 'Checkbox';
                }

                //Display name
                $set[$count]['forms'][$i]['questions'][$j]['desc'] = $new_display_name[$j];
                if ( $j == 0 || $j == 1 || $j == 2 ) {
                  $set[$count]['forms'][$i]['questions'][$j]['isName'] = true;
                }else{
                  $set[$count]['forms'][$i]['questions'][$j]['isName'] = false;
                }
                $set[$count]['forms'][$i]['questions'][$j]['options'] = [];
                //For values or options
                if( strpos($value,'radio') !== FALSE || strpos($value,'checkbox') !== FALSE
                    || strpos($value,'dropdown') !== FALSE )
                {
                  
                  foreach ($tvalues as $vValue) {
                    if ($vValue['name'] == $value) {
                      
                      $set[$count]['forms'][$i]['questions'][$j]['options'] = explode('|', $vValue['vals']);
                    }
                  }
                }


              }else{
                $j--;
              }

              $j++;
            }
            // print_r($comb);
            // die;
            
          $i++;
          //Reset new display name array for next set
          $new_display_name = [];
          }
        }
      }

      $count++;
    }
    // print_r($res);

    $this->response($set, 200);
  }


  function getAllSets_get()
  {
      $res = $this->admin_model->getAllQuestionSets();
      $arr = [];
      $i=0;
      foreach ($res as $key) {
        $arr[$i]['setId'] = $key['id'];
        $arr[$i]['setName'] = $key['set_name'];
        $arr[$i]['setLink'] = base_url()."API/getFormLists?setId=".$key['id']; 
        $i++;
      }
      
      $this->response($arr, 200);
  }

  function getFormLists_get()
  {
      $setid = $this->get('setId');
      $allsets = $this->admin_model->get_formlist_by_setid($setid);
      // echo "<pre>";
      // print_r($allsets);
      

      $questionids = $allsets[0]['question_id'];
      $questionnames = $allsets[0]['question_name'];

      $formlist = [];
      $comb = array_combine( explode(', ', $questionids) , explode(', ', $questionnames) );
      // print_r($comb);
      $i=0;
      foreach($comb as $k => $v)
      {
        $formlist[$i]['formID'] = $k;
        //Get form Display name by id
        $result = $this->admin_model->getFormdisplayname($k);
        //Get form oldid by main id
        $resultoldid = $this->admin_model->getFormOldId($k);
        
        $formlist[$i]['oldFormId'] = (int) $resultoldid['oldFormId']; 
        
        $displayname = $result[0]['display_name'];
        
        $formlist[$i]['formName'] = $v;
        $formlist[$i]['formDisplayName'] = $displayname;
        $formlist[$i]['formLink'] = base_url()."API/formGetByID?formId=".$k;
        $i++;
      }

      $this->response($formlist,200);


  }

  function formGetByID_get()
  {
    $formId = $this->get('formId');
    $data = [];
    $count = 0;
    $tdata = $this->page_model->get_table_by_id($formId);
    $tvalues = $this->page_model->get_table_values_by_id($formId);

    $tids = $tdata[0]['fields'];
    $fields = explode(',', $tids);
    $ttypes = $tdata[0]['types'];
    $types = explode(',', $ttypes);
    $tdescs = $tdata[0]['nepali_title'];
    $display_name = explode('|or|',$tdescs);
    $requirement = '';
    if ( $tdata[0]['require_or_not'] != '' ) {
      $requirement = explode('|or|', $tdata[0]['require_or_not']);
    }

    $comb = array_combine($fields, $types);

    $groups = [];
    foreach ($comb as $fld => $typ) {
      
      if ( $typ == 'legend' ) {
        $group = $fld;
      }

      if ( $typ != 'legend' ) {
        $groups[] = $group;
      }
      

    }
    
    foreach ($comb as $key => $value) {
      
      if ( trim($value) == 'legend' ) {
        unset( $comb[$key] );
      }

    }
    
    
    $requirement_new = array();
    if (is_array($requirement)) {
      foreach ($requirement as $rvalue) {
      if ( trim($rvalue) != 'legend' ) {
        $requirement_new[] = $rvalue;
        }
      }
    }
    
    //For display name removing legends
    $new_display_name = [];
    foreach ($display_name as $dk) {
      
      if ( trim($dk) != 'legend' ) {
        $new_display_name[] = $dk;
      }

    }

    $j = 0;
    foreach ($comb as $key => $value) {
      
        $data[$j]['id'] = $key;
        
        $data[$j]['group'] = $groups[$j];
        //For Types
        if ($value == 'VARCHAR'){
          $data[$j]['type'] = 'Text';
        }elseif ($value == 'DATE'){
          $data[$j]['type'] = 'Date';
        }elseif ($value == 'signature'){
          $data[$j]['type'] = 'Signature';
        }elseif ($value == 'Decimal'){
          $data[$j]['type'] = 'Decimal';
        }elseif ($value == 'INT'){
          $data[$j]['type'] = 'Number';
        }elseif ($value == 'gps'){
          $data[$j]['type'] = 'gps';
        }elseif ($value == 'qrcode'){
          $data[$j]['type'] = 'qrcode';
        }elseif ($value == 'file'){
          $data[$j]['type'] = 'file';
        }elseif ( strpos($value,'radio') !== FALSE ){
          $data[$j]['type'] = 'Radio';
        }elseif ( strpos($value,'dropdown') !== FALSE ){
          $data[$j]['type'] = 'Dropdown';
        }elseif ( strpos($value,'TEXT') !== FALSE ){
          $data[$j]['type'] = 'Textarea';
        }elseif ( strpos($value,'checkbox') !== FALSE ){
          $data[$j]['type'] = 'Checkbox';
        }

        //Display name
        $data[$j]['desc'] = $new_display_name[$j];

        if ( $j == 0 ) {
          $data[$j]['isName'] = true;
        }else{
          $data[$j]['isName'] = false;
        }
        //Is required
        $data[$j]['isRequired'] = (int) $requirement_new[$j];

        $data[$j]['options'] = [];
        //For values or options
        if( strpos($value,'radio') !== FALSE || strpos($value,'checkbox') !== FALSE
            || strpos($value,'dropdown') !== FALSE )
        {
          foreach ($tvalues as $vValue) {
            if ($vValue['name'] == $value) {
              $data[$j]['options'] = explode('|', $vValue['vals']);
            }
          }
        }

      $j++;
    }

    $this->response($data, 200);
  
  }

  function allTables_get()
  {

    $a = $this->page_model->get_tables();
    if (empty($a)) {
      $this->response("No form have been created yet.", 400);
    }
    // echo "<pre>";
    // print_r($res);
    $res = [];
    foreach ($a as $ask => $key)
    {
      $b = $this->page_model->get_table_values_by_id($key['id']);
      $fields = explode(',', $key['fields']); //desc
      $types = explode(',', $key['types']); //type
      $display_name = explode(', ', $key['nepali_title']);
      $fields = array_combine($fields, $types);
      // print_r($fields);
      $count = 0;
      $res[$ask]['fid'] = $key['id'];
      foreach ($fields as $key => $value)
      {
        $res[$ask]['forms'][$count]['name'] = $key;

        $res[$ask]['forms'][$count]['type'] = $value;
        if ($value == 'legend')
        {
          $res[$ask]['forms'][$count]['type'] = "Legend";
        }
        elseif ($value == 'VARCHAR')
        {
          $res[$ask]['forms'][$count]['type'] = "Text";
        }
        elseif ($value == 'INT')
        {
          $res[$ask]['forms'][$count]['type'] = "Number";
        }
        elseif ( strpos($value,'radio') !== FALSE )
        {
          $res[$ask]['forms'][$count]['type'] = "Radio";
        }
        elseif ( strpos($value,'dropdown') !== FALSE )
        {
          $res[$ask]['forms'][$count]['type'] = "Dropdown";
        }
        elseif ( strpos($value,'TEXT') !== FALSE )
        {
          $res[$ask]['forms'][$count]['type'] = "Textarea";
        }
        elseif ( strpos($value,'checkbox') !== FALSE )
        {
          $res[$ask]['forms'][$count]['type'] = "Checkbox";
        }
        else
        {
          $res[$ask]['forms'][$count]['type'] = $value;
        }


        if( strpos($value,'radio') !== FALSE || strpos($value,'checkbox') !== FALSE
            || strpos($value,'dropdown') !== FALSE )
        {
          foreach ($b as $k)
          {
            if ($value == $k['name'])
            {
              $res[$ask]['forms'][$count]['options'] = explode('|', $k['vals']);
            }
          }
        }
        else
        {
          $res[$ask]['forms'][$count]['options'] = [];
        }

        $count++;
      }

    }
    // print_r($data);

    $this->response($res, 200);
  }
  
  function form_by_id_get()
  {
    
    $id = $this->get('id');
    $a = $this->page_model->get_table_by_id($id);
    $b = $this->page_model->get_table_values_by_id($id);

    
    if (count($a) == 0)
    {
      $this->response('No such form', 400);
    exit;
    }
    
    $fields = explode(',', $a[0]['fields']); //desc
    $types = explode(',', $a[0]['types']); //type
    $display_name = explode('|or|', $a[0]['nepali_title']);
    
    foreach($types as $s => $t){
      if($t=='legend'){
        unset($types[$s]);

      }else{
        $newtypes[] = $t;  
      }
      
    }
    foreach($display_name as $key => $value)
    {
      if($value == 'legend')
      {
        unset($display_name[$key]);
        foreach ($fields as $k => $v)
        {
          if($k == $key){
            unset($fields[$k]);
          }
        }
      }else{
        $new_display_name[] = $value;
      }
    }

    $fields = array_combine($fields, $types);
    
    foreach ($fields as $key => $value) {
      if($value == 'legend'){
        unset($fields[$key]);
      }
    }

    $count = 0;
    foreach ($fields as $key => $value)
    {
      $res['data'][$count]['id'] = $key;
      $res['data'][$count]['desc'] = $new_display_name[$count];
      if ($value == 'legend')
      {
        
      }
      elseif ($value == 'VARCHAR')
      {
        $res['data'][$count]['type'] = "Text";
      }
      elseif ($value == 'INT')
      {
        $res['data'][$count]['type'] = "Number";
      }
      elseif ( strpos($value,'radio') !== FALSE )
      {
        $res['data'][$count]['type'] = "Radio";
      }
      elseif ( strpos($value,'dropdown') !== FALSE )
      {
        $res['data'][$count]['type'] = "Dropdown";
      }
      elseif ( strpos($value,'TEXT') !== FALSE )
      {
        $res['data'][$count]['type'] = "Textarea";
      }
      elseif ( strpos($value,'checkbox') !== FALSE )
      {
        $res['data'][$count]['type'] = "Checkbox";
      }
      else
      {
        $res['data'][$count]['type'] = $value;
      }

      if( strpos($value,'radio') !== FALSE || strpos($value,'checkbox') !== FALSE
          || strpos($value,'dropdown') !== FALSE )
      {
        foreach ($b as $k)
        {
          if ($value == $k['name'])
          {
            $res['data'][$count]['options'] = explode('|', $k['vals']);
          }
        }
      }
      else
      {
        $res['data'][$count]['options'] = [];
      }
    $count++;
    }

    $this->response($res, 200);
    exit;
  
  }

  function tables_get()
  {
  
    // $id = $this->get('User-ID');
    $token = $this->input->get_request_header('token', TRUE);

    $response = $this->login_model->auth($token);
    if($response['status'] == 200)
    {
      $result = $this->page_model->get_table_names();
      // echo "<pre>";
      // print_r($result);
      foreach ($result as $key => $value) 
      {
        $value['link'] = "http://encoderslab.com/demoRESTwebservice/API/form_by_id?id=".$value['id'];
        $a[] = $value;
      }
      if ($result) 
      {
        return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array(
                        'status' => '200',
                        'message' => 'Ok',
                        'data' => $a,
                )));
      }
      else
      {
        $this->response("No record found", 404);
      }
    }
    else
    {
        $this->response("Token expired or error", 404);
    }
  }

  function values_get()
  {
    $result = $this->page_model->get_table_values();
    if ($result) 
    {
      $this->response($result, 200);
    }
    else
    {
      $this->response("No record found", 404);
    }
  }

  function tablefromurl_get()
  {
    $tid = $this->uri->segment(3,1);
    $data['table_names1'] = $this->page_model->get_for_table_names();
    $data['table_data1'] = $this->page_model->get_for_table_by_id($tid);
    //get foreign table is exists
    $tbname = $data['table_data1'][0]['title'];
    $data['table_values'] = $this->page_model->get_table_values_by_id($tid);
    
    $this->response($data, 200);
  }

  function tablefromid_get()
  {
    $tid = $this->get('id');
    $result = $this->page_model->get_table_by_id($tid);
    if ($result) 
    {
      $this->response($result, 200);
    }
    else
    {
      $this->response("No record found", 400);
    }
  }

  function testfileupload_post()
  { 

      $this->load->helper('file');
      // $data = json_encode($_POST);
      // write_file('./uploads/logs.php', $data);

      if ( $_FILES['picture']['size'] > 0 ) {

        $filename = $_FILES['picture']['name'];

        if ( !file_exists( 'uploads/'. $filename ) ) {

          $config['upload_path'] = 'uploads/';
          $config['allowed_types'] = 'gif|jpg|png|jpeg';
          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('picture'))
          {
                  $error = $this->upload->display_errors();

                  $this->response($error, 400);
          }
          else
          {
                  $data = array('upload_data' => $this->upload->data());

                  

                  $this->response('Successfully updated the image', 200);
          }

        }

      }else{
        $this->response('No file selected', 400);
      }
    
  }

}