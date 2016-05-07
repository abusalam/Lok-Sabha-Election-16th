1. Install and Start Laragon (Download from laragon.org)
2. Start the Laragon Server(Click "Start All" Button)
3. Open the Laragon Terminal(Click "Terminal" Button) and Clone the PPDS Software from Server.
   Type the following Command in terminal:
	git clone http://paschimmedinipur.org/GitHub/ppds
	cd ppds
	git checkout Counting
	wget http://paschimmedinipur.org/GitHub/ppds.sql

4. Open phpMyAdmin URL(http://localhost/phpmyadmin) in browser
	UserName: root [no password required]

5. Create Database: ppds colation "utf8_bin"
6. Create User: pp4ds with password ppds
7. Open Laragon Terminal and Restore Blank Database using the command below:
	mysql -u root ppds < ppds.sql

8. Login to ppds URL(http://localhost/ppds)
	UserName: admin
	Password: nimda

9. Check the Master Data, Create One User for your Subdivision login to that user and Make the Dataentry for Office and Polling Personnel using their respective menus.

10. Take regular Backup of your Database using the following Command(Replace Datetime Format with with actual values):
	mysqldump -u root --databases ppds > ppds_YYYYMMDDHHMM.sql

11. To Update the "PPDS Counting Software" use the following commands:
      cd ppds
      git checkout Counting
      git pull