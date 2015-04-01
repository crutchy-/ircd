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
    $n=count($channels[$chan]["nicks"]);
    for ($i=0;$i<$n;$i++)
    {
      $c=count($nicks[$nick]["connection"]);
      for ($j=0;$j<$c;$j++)
      {
        $conn=$nicks[$nick]["connection"][$j];
        if ($conn["client_index"]<>$client_index)
        {
          $msg=construct_message($nick,"PRIVMSG",$chan,$trailing);
          if ($msg!==False)
          {
            do_reply($conn["client_index"],$msg);
          }
        }
      }
    }
  }
}

#####################################################################################################

?>
