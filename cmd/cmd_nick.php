<?php

# TODO :old_nick!~crutchy@119-18-0-66.cust.aussiebb.net NICK :new_nick

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
  if (isset($nicks[$nick])==False)
  {
    $nicks[$nick]=array();
    $nicks[$nick]["connection"][]=&$connections[$connection_index];
    $nicks[$nick]["connection_index"][]=$connection_index;
    $connections[$connection_index]["authenticated"]=True;
    $addr=$connections[$connection_index]["addr"];
    $id=random_string(CONNECTION_ID_LEN);
    $nicks[$nick]["connection_id"]=$id;
    do_reply($client_index,"*** NICK MESSAGE RECEIVED FROM $addr: $nick");
    do_reply($client_index,"*** CONNECTION ID FOR NICK $nick: $id");
  }
  else
  {
    $connections[$connection_index]["authenticated"]=False;
    $nicks[$nick]["connection"][]=&$connections[$connection_index];
    $nicks[$nick]["connection_index"][]=$connection_index;
    $addr=$connections[$connection_index]["addr"];
    do_reply($client_index,"*** NICK MESSAGE RECEIVED FROM $addr: $nick (NOT AUTHENTICATED)");
  }
}

#####################################################################################################

?>
