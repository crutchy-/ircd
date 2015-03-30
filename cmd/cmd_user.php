<?php

#####################################################################################################

function cmd_user($client_index,$items)
{
  global $nicks;
  # USER crutchy crutchy 192.168.0.21 :crutchy
  # USER <username> <hostname> <servername> :<realname>
  $nick=client_nick($client_index);
  if ($nick===False)
  {
    return;
  }
  $param_parts=explode(" ",$items["params"]);
  if (count($param_parts)<>3)
  {
    do_reply($client,"ERROR: INCORRECT NUMBER OF PARAMS (NUMERIC 461)");
    return;
  }
  $nicks[$nick]["username"]=$param_parts[0];
  $nicks[$nick]["hostname"]=$param_parts[1];
  $nicks[$nick]["servername"]=$param_parts[2];
  $nicks[$nick]["realname"]=$items["trailing"];
  $nicks[$nick]["prefix"]=$nick."!".$nicks[strtolower($nick)]["connection"]["ident_prefix"].$nicks[strtolower($nick)]["username"]."@".$nicks[strtolower($nick)]["hostname"];
  var_dump($nicks);
  $addr=$nicks[strtolower($nick)]["connection"]["addr"];
  broadcast("*** USER MESSAGE RECEIVED FROM $addr");
}

#####################################################################################################

?>
