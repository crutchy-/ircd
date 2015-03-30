<?php

#####################################################################################################

function cmd_nick($client_index,$items)
{
  global $clients;
  global $connections;
  global $nicks;
  $nick=$items["params"];
  if (isset($nicks[strtolower($nick)])==False)
  {
    $connection_index=connection_index($client_index);
    if ($connection_index===False)
    {
      return;
    }
    # TODO: CHANGE NICK
    $nicks[strtolower($nick)]=array();
    $nicks[strtolower($nick)]["connection"][]=&$connections[$connection_index];
    $nicks[strtolower($nick)]["connection_index"][]=$connection_index;
    $addr=$connections[$connection_index]["addr"];
    do_reply($client_index,"*** NICK MESSAGE RECEIVED FROM $addr: $nick");
    $nicks[strtolower($nick)]["connection_id"]=random_string(CONNECTION_ID_LEN);
  }
  else
  {
    if (strlen($nick)>CONNECTION_ID_LEN)
    {
      $test_nick=strtolower(substr($nick,0,strlen($nick)-CONNECTION_ID_LEN));
      $test_id=substr($nick,strlen($nick)-CONNECTION_ID_LEN);
      echo "*** test_nick = $test_nick\n";
      echo "*** test_id = $test_id\n";
      foreach ($nicks as $loop_nick => $loop_data)
      {
        $loop_id=$nicks[$loop_nick]["connection_id"];
        if (($loop_nick==$test_nick) and ($loop_id==$test_id))
        {
          $nicks[$test_nick]["connection"][]=&$connections[$connection_index];
          $nicks[$test_nick]["connection_index"][]=$connection_index;
          $addr=$connections[$connection_index]["addr"];
          do_reply($client_index,"*** NICK MESSAGE RECEIVED FROM $addr: $test_nick (USING CONNECTION ID)");
          return;
        }
      }
    }
    do_reply($client_index,"ERROR: NICK ALREADY EXISTS (NUMERIC 433)");
  }
}

#####################################################################################################

?>
