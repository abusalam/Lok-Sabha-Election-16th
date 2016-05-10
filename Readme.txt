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

5. Execute the following SQL:
        CREATE DATABASE `ppds_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;CREATE USER 'pp4ds'@'localhost' IDENTIFIED BY 'ppds';GRANT SELECT, INSERT, UPDATE, DELETE ON `ppds`.* TO 'pp4ds'@'localhost';
        
6. Open Laragon Terminal and Restore Blank Database using the command below:
	mysql -u root ppds < ppds.sql

7. Login to ppds URL(http://localhost/ppds)
	UserName: admin
	Password: nimda

8. Check the Master Data, Create One User for your Subdivision login to that user and Make the Dataentry for Office and Polling Personnel using their respective menus.

9. Take regular Backup of your Database using the following Command(Replace Datetime Format with with actual values):
	mysqldump -u root --databases ppds > ppds_YYYYMMDDHHMM.sql

10. To Update the "PPDS Counting Software" use the following commands:
      cd ppds
      git checkout Counting
      git pull