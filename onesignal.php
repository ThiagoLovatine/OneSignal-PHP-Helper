<?php

function deleteSCheduledMessage($message_id){

  $APP_ID = 'YOUR_APP_ID';
  $REST_API_TOKEN     = 'YOUR_REST_API_TOKEN';

  try {
      $ch = curl_init();
      
      if (FALSE === $ch){
          throw new Exception('failed to initialize');
      }
      
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications/".$message_id."?app_id=".$APP_ID);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                          'Authorization: Basic '+$REST_API_TOKEN));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
      curl_setopt($ch, CURLOPT_VERBOSE, true);

      $content = curl_exec($ch);
      
      if (FALSE === $content){
          throw new Exception(curl_error($ch), curl_errno($ch));
      }
          
      return $content;

  } catch(Exception $e) {
      trigger_error(sprintf(
          'Curl failed with error #%d: %s',
          $e->getCode(), $e->getMessage()),
          E_USER_ERROR);
  }


  curl_close($ch);

  return $response;
}

function sendMessage($mensagem, $aditionalData = false, $title){

  $APP_ID             = 'YOUR_APP_ID';
  $REST_API_TOKEN     = 'YOUR_REST_API_TOKEN';

  $content = array(
      "en" => $mensagem
  );

  $headings = array(
      "en" => $title
  );

  $fields = array(
      'app_id'                => $APP_ID,
      'contents'              => $content,
      'headings'              => $headings,
      'large_icon'            => 'YOUR_LARGE_ICON_URL',
      'small_icon'            => 'YOUR_SMALL_ICON_URL', 
  );

  if(isset($aditionalData['location'])){
      $fields['filters'] = [
          [
              'field'     => 'location',
              'radius'    => $aditionalData['location']['radius'], 
              'lat'       => $aditionalData['location']['lat'],
              'long'      => $aditionalData['location']['long']
          ]
      ];
  }

  if(isset($aditionalData['big_picture'])){
      $fields['big_picture']   =   $aditionalData['big_picture'];
  }
  if(isset($aditionalData['ios_attachments'])){
      $fields['ios_attachments']   =   ['id1' => $aditionalData['ios_attachments'] ];
  }

  if(isset($aditionalData['send_after'])){
      $fields['send_after']   =   $aditionalData['send_after'];
  }

  if(isset($aditionalData['include_player_ids'])){
      $fields['include_player_ids'] = $aditionalData['include_player_ids'];
  } else {
      $fields['included_segments'] = array('All');
  }



  $fields = json_encode($fields);

  try {
      $ch = curl_init();
      
      if (FALSE === $ch){
          throw new Exception('failed to initialize');
      }
      
      curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                          'Authorization: Basic '.$REST_API_TOKEN));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
      curl_setopt($ch, CURLOPT_VERBOSE, true);

      $content = curl_exec($ch);
      
      if (FALSE === $content){
          throw new Exception(curl_error($ch), curl_errno($ch));
      }
          
      return $content;

  } catch(Exception $e) {
      trigger_error(sprintf(
          'Curl failed with error #%d: %s',
          $e->getCode(), $e->getMessage()),
          E_USER_ERROR);
  }


  curl_close($ch);

  return $response;
}
