When I did this the first time I needed to give my user permission 
to edit the server files:
sudo adduser $USER www-data
sudo usermod -a -G www-data $USER

This initially didn't work. I didn't have the permission and `groups`
said I wasn't in the group even though `groups $USER` said I was.
Against all the advice on the web, I had to restart (*not* log out and
in again) to get the changes to take effect.

Even after changing the group I still needed to change the permissions
from `rw-rw-r--` to `rw-rw-r--` so the group could modify files in the
directory.
`sudo chmod -R 664 ./wp-content/` and `sudo chmod -R +X ./wp-content`
(to be able to browse the directories again)

Helpful info
https://hub.docker.com/_/wordpress


