<?php

#####################################################################################################

function cmd_privmsg($client_index,$items)
{
  global $nicks;
  global $channels;
  # PRIVMSG #soylent :stuff
  $nick=client_nick($client_index);
  if ($nick===False)
  {
    return;
  }
  $chan=$items["params"];
  $trailing=$items["trailing"];
  if (isset($channels[$chan]["nicks"])==True)
  {
    $msg=construct_message($nick,"PRIVMSG",$chan,$trailing);
    $n=count($channels[$chan]["nicks"]);
    for ($i=0;$i<$n;$i++)
    {
      do_reply_nick($channels[$chan]["nicks"][$i],$msg,$client_index);
    }
  }
}

#####################################################################################################

?>
