#!/usr/bin/python

import sys
import sys
import argparse
import os
def new_virtualHost():
    virtualHostDirectory='/var/www/html/repairtracker/public'
    host_file = open("/tmp/"+args.virtualHostDomain+".conf", "w")
    host_file.write('<VirtualHost *:80>\nServerAdmin localserver@localhost\nServerName '+args.virtualHostDomain+
    '\nServerAlias www.'+args.virtualHostDomain+
    '\nDocumentRoot "'+virtualHostDirectory+
    '"\n<Directory "'+virtualHostDirectory+
    ">\nAllowoverride All"+
    "\n</Directory>"+
    "\nErrorLog ${APACHE_LOG_DIR}/error.log\nCustomLog ${APACHE_LOG_DIR}/access.log combined"+
    "\n</VirtualHost>")
    host_file.close()
    os.system("sudo mv \"/tmp/"+args.virtualHostDomain+".conf\" \"/etc/apache2/sites-available/\"")

   

    os.system("sudo a2dissite 000-default.conf")
    os.system("sudo a2ensite "+args.virtualHostDomain+".conf")
    #os.system("sudo service apache2 restart")
    #os.system("service apache2 reload")
    os.system("apachectl -k graceful")
    os.system("sudo sed -i -e '1i127.0.1.1   "+args.virtualHostDomain+ "\' \"/etc/hosts\"")
  
    print "\nSuccess! Please visit http://"+args.virtualHostDomain+"/ from any web browser\n\n"


parser = argparse.ArgumentParser(description='This is a demo script by nixCraft.')
parser.add_argument('-vd','--virtualHostDomain', help='virtual host name for app',required=True)
parser.add_argument('-ap','--appPath',help='appPath', required=False)
args = parser.parse_args()

new_virtualHost()


'''
virtualHostDirectory='/var/www/html/repairtracker/public'
host_file = open("/tmp/"+args.virtualHostDomain+".conf", "w")
host_file.write('<VirtualHost *:80>\nServerAdmin localserver@localhost\nServerName '+args.virtualHostDomain+
'\nServerAlias www.'+args.virtualHostDomain+'DocumentRoot"'+virtualHostDirectory+
'" \n<Directory "'+virtualHostDirectory+
"> \nAllowoverride All </Directory>"+
"\nErrorLog ${APACHE_LOG_DIR}/error.log\nCustomLog ${APACHE_LOG_DIR}/access.log combined"+
"\n</VirtualHost>")
host_file.close()
os.system('sudo mv /tmp/'+args.virtualHostDomain+'.conf /etc/apache2/sites-available/')

os.system("sudo a2dissite 000-default.conf")
'''





