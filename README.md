groLog version 0.0.2 pre-alpha
============
By groLog Project 

Last Public Update 7, December 2018

this is a basic grow logging system for horticulture and cultivation. this is not complete by any means but it can be used to simply track things when you need to go from a computer to a phone or a pad and back and forth. We can help you set up but it is mostly up to you
you need a stack with php a html server and a sql server capatible with mysql. a lot of people use xampp for ease of use. it can be used on windows or linux without much hassle.

What works:
-Caretaker home screen
-Admin Control Panel (partially, but all on one page)
-Last logins, dates and ips
-add breeder
-add plant
-add strain
-add seed bank
-strain info page
-plant info page
-upload plant photo or take photo directly from any phone
-works over any network as long as the http and mysql server are online
-plant comments
-start plant
-sprout plant
-add user through signup page (user is always an admin)
-all plants ever grown
-all breeders
-all strains
-soft delete a strain
-soft delete a plant

what needs to be done
-display wet weight harvest weights
-dry weight harvest csubmission form
-dry weight submission
-harvest specific photos
-nutrient specific feeding charting (not just comments) (most of the database is worked out, just needs finishing and a frontend page)
-better documentation
-breeder info page
-orient photos properly
-allow searching of photos not just display of most recent
-allow for display of multiple photos in a timeline and in a gallery
-allow photo of entire grow room
-enable multiple grow rooms
-create task lists
-specify clones
-specify mothers
-specify clone generation
-specify  numbers

-beautify for production
-export to PDF ability for paper logging

Set up
WARNING DONT LET THIS OPEN TO THE WORLD ONLY TO INTERNAL NETWORK! IT PROBABLY WILL BE HACKED AND ISNT SET UP FOR SECURITY!
Blowfish password encoding is insecure!

You must turn on file uploads in php.ini by using the following setting in your "php.ini" file
add/change the ini to reflect the following line of code
file_uploads = On

you must increase file upload size in your php.ini file
I set mine to 50MB so I can take super high definition pictures of the plants:
add/change the ini to reflect the following line of code
upload_max_filesize=50M

place all files in the root directory (in htdocs so index.php is in htdocs)

create mysql user with permissions to database with password of your choice (i used user grolog, password grolog)
edit inc/config.php set "$config['mysql']['rw']['user']" and "$config['mysql']['rw']['pass']"

go to localhost and then select register.
create your user and give it information
log in
"admin control panel"
then "add seed bank"
then "add breeder"
then "add strain"
then "add plant"


error "Notice: Undefined offset: 0 in C:\xampp\htdocs\plantinfo.php on line 89"
will occur until your first plant photo is uploaded, this will be remedied with error catching later.


NOTE you must give the uploads directory write access or it will not be able to save photosstill did not re orient photos yet. slow development the last few days