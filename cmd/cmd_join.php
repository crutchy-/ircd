<?php

/*
<< JOIN #stuff
>> :crutchy!~crutchy@709-27-2-01.cust.aussiebb.net JOIN #stuff
<< MODE #stuff
<< WHO #stuff
>> :irc.sylnt.us MODE #stuff +nt
>> :irc.sylnt.us 353 crutchy = #stuff :@crutchy
>> :irc.sylnt.us 366 crutchy #stuff :End of /NAMES list.
>> :irc.sylnt.us 324 crutchy #stuff +nt
>> :irc.sylnt.us 329 crutchy #stuff 1417818719
>> :irc.sylnt.us 352 crutchy #stuff ~crutchy 709-27-2-01.cust.aussiebb.net irc.sylnt.us crutchy H@ :0 crutchy
>> :irc.sylnt.us 315 crutchy #stuff :End of /WHO list.
*/

#####################################################################################################

function cmd_join($client_index,$items)
{
  global $nicks;
  global $channels;
  $nick=client_nick($client_index);
  if ($nick===False)
  {
    return;
  }
  $conn=nick_connection($client_index,$nick);
  $addr=$conn["addr"];
  $chan=$items["params"];
  if (isset($channels[$chan])==False)
  {
    $channels[$chan]=array();
    $channels[$chan]["nicks"]=array();
  }
  $channels[$chan]["nicks"][]=$nick;
  do_join($nick,$chan);
}

#####################################################################################################

function do_join($nick,$channel,$client_index=False)
{
  global $nicks;
  global $channels;
  $prefix=$nicks[$nick]["prefix"];
  for ($i=0;$i<count($channels[$channel]["nicks"]);$i++)
  {
    do_reply_nick($channels[$channel]["nicks"][$i],":".$prefix." JOIN ".$channel,$client_index);
  }
  do_reply_nick($nick,":".SERVER_HOSTNAME." 353 $nick = $channel :".implode(" ",$channels[$channel]["nicks"]),$client_index);
  do_reply_nick($nick,":".SERVER_HOSTNAME." 366 $nick $channel :End of /NAMES list.",$client_index);
  do_reply_nick($nick,":".SERVER_HOSTNAME." 324 $nick $channel +nt",$client_index);
  do_reply_nick($nick,":".SERVER_HOSTNAME." 329 $nick $channel ".time(),$client_index);
}

#####################################################################################################

?>
