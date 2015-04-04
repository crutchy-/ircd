<?php

#####################################################################################################

function cmd_user($client_index,$items)
{
  global $nicks;
  global $connections;
  # USER crutchy crutchy 192.168.0.21 :crutchy
  # USER HOSTSctl 8 * :APK
  # USER <username>[<connection id>] <hostname> <servername> :<realname>
  $nick=client_nick($client_index,False,False);
  $conn=connection_index($client_index);
  if (($nick===False) or ($conn===False))
  {
    return;
  }
  $param_parts=explode(" ",$items["params"]);
  if (count($param_parts)<>3)
  {
    do_reply($client_index,"ERROR: INCORRECT NUMBER OF PARAMS (NUMERIC 461)");
    return;
  }
  $connection=$connections[$conn];
  if ($connection["authenticated"]==False)
  {
    $username=substr($param_parts[0],0,strlen($param_parts[0])-CONNECTION_ID_LEN);
    $conn_id=substr($param_parts[0],strlen($param_parts[0])-CONNECTION_ID_LEN);
    if ($nicks[$nick]["connection_id"]==$conn_id)
    {
      $connections[$conn]["authenticated"]=True;
      do_reply($client_index,"SUCCESSFULLY AUTHENTICATED AS \"$nick\" USING CONNECTION ID \"$conn_id\"");
    }
    else
    {
      do_reply($client_index,"ERROR: CONNECTION ID MISMATCH");
      return;
    }
  }
  else
  {
    $username=$param_parts[0];
  }
  if (isset($nicks[$nick]["prefix"])==False)
  {
    $nicks[$nick]["username"]=$username;
    $nicks[$nick]["hostname"]=$param_parts[1];
    $nicks[$nick]["servername"]=$param_parts[2];
    $nicks[$nick]["realname"]=$items["trailing"];
    $nicks[$nick]["prefix"]=$nick."!".$connection["ident_prefix"].$nicks[$nick]["username"]."@".$nicks[$nick]["hostname"];
  }
  var_dump($nicks);
  $addr=$connection["addr"];
  broadcast("*** USER MESSAGE RECEIVED FROM $addr");
}

#####################################################################################################

?>
