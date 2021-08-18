<!-- Create Dynamic Step Form With Data In MySql Table  -->
 <form class="steps" accept-charset="UTF-8"  method="post" novalidate="">
         <div class="progressbar">
            <ul id="progressbar">
               <div id="gradient_bar"></div>
               <?php 
                  for($ul=1;$ul <= $last_question_id;$ul++){
                  ?>   
               <li></li>
               <?php
                  }
                  ?>
               <li></li>
            </ul>
            <span id="progress_bar"><i class="fa fa-caret-up"></i>
            <span></span></span>
         </div>
         <div id="timer" class="timer">00</div>
         <?php
            $index=0;
            while($row = $result->fetch_assoc()) {
            	 $question_id=$row['question_id'];
             $question=$row['question'];
             $choices=$row['choices']; 
             $question_name=$row['name'];
             $question_input_type=$row['question_input_type'];
             $input_type=$row['input_type'];
             $index++ ;
             if($index == $last_question_id){   ?>
         <fieldset class="fieldset_<?php echo $question_name ; ?> last_fieldset">
         <?php 
            }
            else {
             ?>
         <fieldset class="fieldset_<?php echo $question_name ; ?>">
            <?php }?>
            <h2 class="fs-title"><?php echo $question ;?>    <span class="error1" style="display: none;">
               <i class="error-log fa fa-exclamation-triangle"></i>
               </span>
            </h2>
            <div class="hs_<?php echo $question_name ; ?> field hs-form-field">
               <?php 
                  if(!empty($question_input_type)) {
                  	 if( $question_input_type == "Input" && $input_type == 'url'){
                  					?>
               <input id="<?php echo $question_name ; ?>" name="<?php echo $question_name ; ?>" required="required" type="url" value="" placeholder="" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>"  onblur="checkURL(this)">
               <?php
                  }
                  else if($question_input_type == "Input" && $question_id == '10'){
                  ?>
               <input name="<?php echo $question_name ; ?>"  id="<?php echo $question_name ; ?>" type="<?php echo $input_type; ?>" min="1800" max="<?php echo date("Y");?>" value="<?php echo $answer_preselect[$question_name]; ?>"  data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>"/>
               <?php }
                  else if( $question_input_type == "Input"){
                                 			?>
               <input name="<?php echo $question_name ; ?>"  id="<?php echo $question_name ; ?>" type="<?php echo $input_type; ?>"  value="<?php echo $answer_preselect[$question_name]; ?>"  data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>"/>
               <?php }
                  else if( $question_input_type == "Select"){
                  		$choices= (explode(',',$choices));
                  	?>
               <select class="select" size="<?php  echo count($choices);  ?>" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>">
                  <?php 
                     foreach($choices as $value){
                     	?>
                  <option value="<?php echo $value ;?>"><?php echo $value ;?></option>
                  <?php
                     }
                     		?>    
               </select>
               <?php }
                  else if( $question_input_type == "Multiselect"){ ?>
               <select  class="select" multiple="multiple" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>">
                  <?php 
                     $choices= (explode(',',$choices));
                     foreach($choices as $value){
                     	?>
                  <option value="<?php echo $value ;?>"><?php echo $value ;?></option>
                  <?php
                     }
                     		?>    
               </select>
               <?php }
                  else if( $question_input_type == "Range"){
                  	 $choice = explode(',' , $choices );
                  	$step =  count($choice);
                  	$diff =  $choice['1'] - $choice['0'];
                  	$last  = $step-1;
                  	$difference=$step-1;
                  	$margin = 100/$difference;
                  	?>
               <div class="range-control">
                  <input type="range" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>" min="0" max="<?php echo $last ?>" step="1" data-thumbwidth="20" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>" aria-required="true" aria-invalid="false">
               </div>
               <div class="technology_range">
                  <?php foreach($choice as $ch){
                     if($margin == 100){
                     $margin = 96;
                     }
                     ?>
                  <span class='range_value' style = "width:<?php echo $margin;?>%">  <span class="range_value_inner">
                  <?php echo $ch; ?> </span> </span> <?php	}
                     ?>
               </div>
               <?php  
                  }
                  else if( $question_input_type == "Radio"){
                  		$choices= (explode(',',$choices));
                                      ?>
               <div class="radio_div">
                  <?php					
                     foreach($choices as $value){
                     	?>
                  <span>
                  <input type="radio" id="<?php echo $question_id.$value ;?>" name="<?php echo $question_id ; ?>" value="<?php echo $value ;?>">
                  <label for="<?php echo $question_id.$value ;?>"><?php echo $value ;?></label>
                  </span>
                  <?php
                     }
                     ?>
               </div>
               <?php
                  }
                              } 	
                  else if($choices == '') { 
                  if($question_name == 'age' || $question_name == 'payroll'){?>
               <input id="<?php echo $question_name ; ?>" class="form-text hs-input" name="<?php echo $question_name ; ?>" required="required" size="60" maxlength="128" type="number" value="" placeholder="" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>" >
               <?php }
                  else if($question_name == 'business_launch'){
                  $years = range(strftime("%Y", time()),1900 ); ?>
               <select class="select" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>" multiple data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>">
                  <?php foreach($years as $year) { ?>
                  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                  <?php } ?>			        
               </select>
               <?php } 
                  else if($question_name == 'work_email'){
                  	?>
               <input id="<?php echo $question_name ; ?>" name="<?php echo $question_name ; ?>" required="required" type="email" value="" placeholder="" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>" >
               <?php }
                  else if($question_name == 'business_type'){
                  	?>
               <input id="<?php echo $question_name ; ?>" name="<?php echo $question_name ; ?>" required="required" type="text" value="" placeholder="" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>" >
               <div id="note" style="display:none;"></div>
               <div class="no_result" style="display:none">
                  <select  class="select"  id= "no_result" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>">
                     <option value="Retailer">Retailer</option>
                     <option value="Service Provider">Service Provider</option>
                     <option value="Food & Beverage">Food & Beverage</option>
                  </select>
               </div>
               <?php }
                  else if($question_name == 'web_url'){
                  	?>
               <input id="<?php echo $question_name ; ?>" name="<?php echo $question_name ; ?>" required="required" type="url" value="" placeholder="" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>"  onblur="checkURL(this)">
               <?php }
                  else if($question_name == 'revenue_compare_2019'){
                  	?>
               <div class="range-value" id="revenueV"> </div>
               <input type="range" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>"  min="-20" max="20" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>">
               <div class="technology_range">
                  <span class="technology_range_left">-20%</span><span class="technology_range_right">20%+ </span>
               </div>
               <?php }
                  else { ?>
               <input id="<?php echo $question_name ; ?>" name="<?php echo $question_name ; ?>" required="required" type="text" value="" placeholder="" data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>" >
               <?php }
                  } else{
                  $choices= (explode(',',$choices));
                  	?>
               <select class="select" size="<?php echo count($choices); ?>" name="<?php echo $question_name ; ?>" id="<?php echo $question_name ; ?>"  data-rule-required="true" data-msg-required="Please give answer for <?php echo $question ; ?>">
                  <?php 
                     foreach($choices as $value){
                     	?>
                  <option value="<?php echo $value ;?>"><?php echo $value ;?></option>
                  <?php
                     }
                     		?>    
               </select>
               <?php } ?>
            </div>
            <div class="change_order">
               <div class="submit_button">
                  <div class="assessment_button">
                     <?php if($index !=1){   ?>
                     <input type="button" data-page="2" name="previous" class="previous action-button" value="Previous Question" />
                     <?php } ?>
                     <input type="button" data-page="<?php echo $index ; ?>" name="next" class="next action-button" value="Next" />
                  </div>
               </div>
               <p class="question_id" style="display:none"><?php echo $question_id;?></p>
               <p class="question_order" style="display:none"><?php echo $row['order'];?></p>
               <div class="explanation btn btn-small modal-trigger" data-modal-id="modal-3"></div>
            </div>
         </fieldset>
         <?php
            } ?>
         <fieldset>
            <h2 class="fs-title">Would you like to</h2>
            <div class="hs_mailchimp field hs-form-field">
               <div class="mailchimp">
                  <div class="mailchimp_inner">
                     <input type="checkbox" class="custom_check" name="MailChimp" id="mailchimp" value="yes" checked>
                     <label for="mailchimp">I want to receive news and updates from Main Street America</label>
                  </div>
                  <div class="mailchimp_inner business_share">
                     <input type="checkbox" class="custom_check" name="sharing_business" id="sharing_business" value="yes" checked>
                     <label for="sharing_business">Feature my business on the Main Street Online Tool Homepage</label>
                  </div>
               </div>
               <div id="wrapper">
                  <span class="drop_image_heading">We just need an image or logo to display your business on our homepage.</span>
                  <div class="input-drop">
                     <input type="file" id="name_myfile">
                     <div id="drop-area">
                        <h3 class="drop-text desktop">Drop Your Image Here</h3>
                        <h3 class="drop-text mobile">Upload Image</h3>
                     </div>
                  </div>
               </div>
               <div class="assessment_button last_assessment">
                  <input type="button" data-page="2" name="previous" class="previous action-button" value="Previous Question" />
                  <input id="submit" name="submit_assessment" class="hs-button primary large action-button next last_button" type="submit" value="View Your Result">
               </div>
            </div>
         </fieldset>
      </form>
<!--  Save Form Data In JSon Format In MySql Table -->
<?php
include ('../config.php');
$id = $_POST['id'];
$question = $_POST['name'];
$answer = $_POST['answer'];
$time = $_POST['time'];
$time = explode(":", $time);
$current_question_id = $_POST['current_question_id'];
$next_question_id = $_POST['next_question_id'];
$order = $_POST['question_order'];
if ($answer == "Previous Question" && $question == "previous" || $answer == "Next" || $question == "next") {
    $answer = $_POST['answer_select'];
    $question = $_POST['name_select'];
}
if (is_array($answer) == '1') {
    $answer = implode(',', $answer);
}
$answer = str_replace("'", "#", $answer);
$answer = trim($answer);
$questions_completed = 0;
$sql = "SELECT * FROM results WHERE user_id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $matchFound = "yes";
} else {
    $matchFound = "no";
}
$demo->$current_question_id = $answer;
$myJSON = json_encode($demo);
if ($matchFound == "no") {
    $query = "INSERT INTO results (questions_completed)
 VALUES ('$questions_completed')";
    mysqli_query($conn, $query);
    $sql = "SELECT questions_completed , result  FROM results WHERE user_id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($time[1] == 00) {
                $time_complete = $time[2];
            } else {
                $time_complete = 60;
            }
            $questions_completed = '1';
            $questions_completed+= $row['questions_completed'];
            $sql = "UPDATE results SET questions_completed = '$questions_completed' , result = '$myJSON', time_completion = '$time_complete' WHERE user_id = '$id'";
            mysqli_query($conn, $sql);
        }
    }
} else if ($matchFound == "yes") {
    $sql = "SELECT questions_completed , result , time_completion FROM results WHERE user_id = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $json_data = $row['result'];
            $json_data . "\n";
            $json_array = json_decode($json_data, true);
            if ($time[1] == 00) {
                $time_complete = $time[2];
            } else {
                $time_complete = 60;
            }
            if (array_key_exists($current_question_id, $json_array)) {
                $array_length = count($json_array);
                $questions_completed = $array_length;
                $json_array[$current_question_id] = $answer;
                $myJSONupdate = json_encode($json_array);
                $sql = "UPDATE results SET questions_completed = '$questions_completed' , result = '$myJSONupdate', time_completion = '$time_complete' WHERE user_id = '$id'";
                mysqli_query($conn, $sql);
            } else {
                $questions_completed = '1';
                $array_length = count($json_array);
                $questions_completed+= $array_length;
                $time_complete+= $row['time_completion'];
                $json_array[$current_question_id] = $answer;
                $myJSONupdate = json_encode($json_array);
                $sql = "UPDATE results SET questions_completed = '$questions_completed' , result = '$myJSONupdate', time_completion = '$time_complete' WHERE user_id = '$id'";
                mysqli_query($conn, $sql);
            }
        }
    }
}
$sql_new2 = "SELECT * FROM question_dependencies";
$result_new2 = $conn->query($sql_new2);
if ($result_new2->num_rows > 0) {
    while ($row = $result_new2->fetch_assoc()) {
        $exist = $row['question_id'];
        $dep_question = $row['question'];
        $dep_question_name = $row['question_name'];
        $dep_choice = $row['choice'];
        $sql_new1 = "SELECT question_id FROM question_list WHERE question = '$dep_question'";
        $result_new1 = $conn->query($sql_new1);
        if ($result_new1->num_rows > 0) {
            while ($row = $result_new1->fetch_assoc()) {
                $dep2_id = $row['question_id'];
                $sql_dep2 = "SELECT result FROM results WHERE user_id = '$id'";
                $result_dep2 = $conn->query($sql_dep2);
                if ($result_dep2->num_rows > 0) {
                    while ($row = $result_dep2->fetch_assoc()) {
                        $json_data = $row['result'];
                        $json_array = json_decode($json_data, true);
                        $dep_answer = $json_array[$dep2_id];
                        $dep_answer = str_replace("#", "'", $dep_answer);
                        if ($dep_answer == $dep_choice) {
                            $sql_new3 = "SELECT `order` FROM question_list WHERE question_id = '$exist'";
                            $result_new3 = $conn->query($sql_new3);
                            if ($result_new3->num_rows > 0) {
                                while ($row = $result_new3->fetch_assoc()) {
                                    $order = $row['order'];
                                }
                            }
                            $hide_new[] = $order;
                            $sql_dep = "SELECT result FROM results WHERE user_id = '$id'";
                            $result_dep = $conn->query($sql_dep);
                            if ($result_dep->num_rows > 0) {
                                while ($row = $result_dep->fetch_assoc()) {
                                    $json_data1 = $row['result'];
                                    $json_array1 = json_decode($json_data, true);
                                    if (array_key_exists($exist, $json_array1)) {
                                    } else {
                                        $questions_completed = '1';
                                        $array_length = count($json_array1);
                                        $questions_completed+= $array_length;
                                        $json_array1[$exist] = '';
                                        $myJSONupdate = json_encode($json_array1);
                                        $sql = "UPDATE results SET questions_completed = '$questions_completed', result = '$myJSONupdate' WHERE user_id = '$id'";
                                        mysqli_query($conn, $sql);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($hide_new);
?>

<!-- Sort Order OF Questions  From Backend Function  -->
<?php
include ('../config.php');
$current_order_question = $_POST['prev'];
$sql_question = "SELECT * FROM question_list  WHERE  question_list.question = '$current_order_question'";
$result_question = $conn->query($sql_question);
if ($result_question->num_rows > 0) {
    while ($row = $result_question->fetch_assoc()) {
        $current_order = $row['order'];
    }
}
$new_order = $_POST['curr'];
$prev = $current_order;
$curr = $_POST['curr'];
if ($current_order < $new_order) {
    $sql_order = "SELECT name FROM question_list  WHERE `order` = '$current_order'";
    $result_order = $conn->query($sql_order);
    if ($result_order->num_rows > 0) {
        while ($row = $result_order->fetch_assoc()) {
            $current_question_name = $row['name'];
            $sql_new = "SELECT * FROM question_dependencies WHERE question_name = '$current_question_name'";
            $result_new = $conn->query($sql_new);
            if ($result_new->num_rows > 0) {
                while ($row = $result_new->fetch_assoc()) {
                    $delete_id = $row['Id'];
                    $question_id = $row['question_id'];
                    $sql_check = "SELECT * FROM `question_list` WHERE question_list.question_id = '$question_id'";
                    $result_check = $conn->query($sql_check);
                    if ($result_check->num_rows > 0) {
                        while ($row = $result_check->fetch_assoc()) {
                            $order_require = $row['order'];
                            if ($order_require <= $new_order) {
                                $sql_delete = "DELETE FROM  question_dependencies WHERE Id = '$delete_id'";
                                mysqli_query($conn, $sql_delete);
                            }
                        }
                    }
                }
            }
        }
    }
} else if ($current_order > $new_order) {
    $sql_order = "SELECT question_id FROM question_list  WHERE `order` = '$current_order'";
    $result_order = $conn->query($sql_order);
    if ($result_order->num_rows > 0) {
        while ($row = $result_order->fetch_assoc()) {
            $current_question_id = $row['question_id'];
            $sql_new = "SELECT * FROM question_dependencies WHERE question_id = '$current_question_id'";
            $result_new = $conn->query($sql_new);
            if ($result_new->num_rows > 0) {
                while ($row = $result_new->fetch_assoc()) {
                    $delete_id = $row['Id'];
                    $question_name = $row['question_name'];
                    $sql_check = "SELECT * FROM `question_list` WHERE question_list.name = '$question_name'";
                    $result_check = $conn->query($sql_check);
                    if ($result_check->num_rows > 0) {
                        while ($row = $result_check->fetch_assoc()) {
                            $order_require = $row['order'];
                            if ($order_require >= $new_order) {
                                $sql_delete = "DELETE FROM  question_dependencies WHERE Id = '$delete_id'";
                                mysqli_query($conn, $sql_delete);
                            }
                        }
                    }
                }
            }
        }
    }
}
$sql = "UPDATE question_list SET `order` = '9999999'  WHERE `order` = '$prev'";
mysqli_query($conn, $sql);
if ($prev > $curr) {
    while ($prev > $curr) {
        $order = $prev;
        $prev--;
        $sql = "UPDATE question_list SET `order` = '$order'  WHERE `order` = '$prev'";
        mysqli_query($conn, $sql);
    }
}
if ($prev < $curr) {
    while ($prev < $curr) {
        $order = $prev;
        $prev++;
        $sql = "UPDATE question_list SET `order` = '$order'  WHERE `order` = '$prev'";
        mysqli_query($conn, $sql);
    }
}
$sql = "UPDATE question_list SET `order` = '$curr'  WHERE `order` = '9999999'";
mysqli_query($conn, $sql);
echo json_encode(array("statusCode" => 200));
?>

<!--Get Ip Adress Function -->
<?php
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
    else $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$IPaddress = get_client_ip();
echo 'IPaddress: ' . $IPaddress . '<br>';
$ip = get_client_ip(); // your ip address here
$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
if ($query && $query['status'] == 'success') {
    echo 'Your City is ' . $query['city'];
    echo '<br />';
    echo 'Your State is ' . $query['region'];
    echo '<br />';
    echo 'Your Zipcode is ' . $query['zip'];
    echo '<br />';
    echo 'Your Coordinates are ' . $query['lat'] . ', ' . $query['lon'];
}
?>

<!-- Call Ip Adress Function-->
<?php
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR');
    else $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
$IPaddress = get_client_ip();
$ip_address = $IPaddress;
$ip = get_client_ip();
?>

<!--  Encrypt Decrypt Function  -->
  <?php
}
function encrypt_decrypt($string, $action = 'encrypt') {
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
?>