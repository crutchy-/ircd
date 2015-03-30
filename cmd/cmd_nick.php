<?php

#####################################################################################################

function cmd_nick($client_index,$items)
{
  global $clients;
  global $connections;
  global $nicks;
  $connection_index=connection_index($client_index);
  if ($connection_index===False)
  {
    return;
  }
  $nick=$items["params"];
  $test_nick="";
  $test_id="";
  if (strlen($nick)>CONNECTION_ID_LEN)
  {
    $test_nick=strtolower(substr($nick,0,strlen($nick)-CONNECTION_ID_LEN));
    $test_id=substr($nick,strlen($nick)-CONNECTION_ID_LEN);
  }
  $nick=strtolower($nick);
  if ((isset($nicks[$nick])==False) and (isset($nicks[$test_nick])==False))
  {
    # TODO: CHANGE NICK
    $nicks[$nick]=array();
    $nicks[$nick]["connection"][]=&$connections[$connection_index];
    $nicks[$nick]["connection_index"][]=$connection_index;
    $addr=$connections[$connection_index]["addr"];
    do_reply($client_index,"*** NICK MESSAGE RECEIVED FROM $addr: $nick");
    $id=random_string(CONNECTION_ID_LEN);
    $nicks[$nick]["connection_id"]=$id;
    do_reply($client_index,"*** CONNECTION ID FOR NICK $nick: $id");
  }
  else
  {
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
    do_reply($client_index,"ERROR: NICK ALREADY EXISTS (NUMERIC 433)");
  }
}

#####################################################################################################

?>
