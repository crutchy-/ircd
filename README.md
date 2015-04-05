# ircd

working on ability to connect multiple times to a network with the same nick. idea is that if there are a few servers on the network you could connect to each of them, and then if one disconnects you can still use the other (redundant) connections. authentication of subsequent connections to the same nick is done using a connection id appended to the username field (username sent out doesn't include the connection id though).
the server is at a point where i can connect to it with hexchat a couple of times (server spits out a connection id on first connect, and i just paste that to the end of the username in second connection). i can then join a channel from either connection, which automatically joins for the other connection (weird to watch). then i can chat and the chat appears on both connections. its pretty funky to play with.
if the project goes anywhere (unlikely) it might be ideal to have a client that handles the redundant connections for you automatically rather than having to establish separate connections manually and have each one take up room in the server list. netsplits could be a thing of the past.
prolly will try to make it ts6 and rfc compatible, but still early stages.


==NOTES==

connect ircd as a normal client to irc.sylnt.us irc network

allow any number of clients to connect to ircd

ircd to work as a relay between irc.sylnt.us and local

if a local client (xchat or bot) says something, it appears as "<exec> localnick: msg" at irc.sylnt.us,
and likewise if someone says something on irc.sylnt.us


i'll try set up my little ircd script so that i can make 2 connections
to it with xchat and have the server treat both as the same nick
(using a connection hash for 2nd connection)
