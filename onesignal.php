<?php

function sendMessage($mensagem, $title, $image = false, $include_player_ids = false, $aditionalData = false, $category = false){
    
    $one_signal_api_token       = '';
    $one_signal_app_id          = '';
    
    $content = array(
      "en" => $mensagem
    );

    $title = array(
      "en" => $headings
    );

    $fields = array(
      'app_id' => $app_id,
      'contents' => $content,
      'headings' => $title
    );
  
    // @Array => players_ids / Se for falso envia para todos
    if($include_player_ids){
      $fields['include_player_ids'] = $include_player_ids;
    }

    // @String(URL) => Imagem para receber notificação, avatar da empresa, imagem do evento, etc
    if($image){
      $fields['big_picture'] = $image;
      $fields['ios_attachments'] = ["id1" => $image];
    }

    $fields['included_segments'] = array('All');

    if($aditionalData){
      $fields['data'] = $aditionalData;
    }

    $fields = json_encode($fields);
    
    try {
        $ch = curl_init();
        
        if (FALSE === $ch){
            throw new Exception('failed to initialize');
        }
        
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                            'Authorization: Basic '.$one_signal_api_token));
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
