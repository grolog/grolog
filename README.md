groLog version 0.0.3 pre-alpha
============
By groLog Project 

Last Public Update 11, December 2018

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
-display wet weight harvest weights
-dry weight harvest submission form
-dry weight submission
-better documentation
-listing of nutrient companies youve added (in admin panel)
-listing all nutrients you have added and their most common nutrient contents
-adding nutrients with their most common contents

what needs to be done
-orient photos properly
-breeder info page
-harvest specific photos
-nutrient specific logging in the plant info page
-graphing
-api for integration of monitoring
-beautify for production
-export to PDF ability for paper logging
-allow searching of photos not just display of most recent
-allow for display of multiple photos in a timeline and in a gallery
-allow photo of entire grow room
-enable multiple grow rooms
-create task lists
-specify clones
-specify mothers
-specify clone generation
-specify  numbers
-allow a "semi-public view" for those with a password to log in and view photos and info but not view private info such as names and info marked by the caretaker/admin as private (such as who and when the plant was cared for)


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



from there you can click home and then either click plant id or strain name and be taken to the plant info page. click strain id number to get the strain info. on the plant info page, you will find a table with the plant id the stran id the strain name the room id the caretaker who planted it, their unique identifier the breeder it came from when it was obtained, when it was planted when it sprouted and tis age. also at the top you will see a photo of the plant as it is when you last took a photo. all other photos are saved, but only the most recent is shown. in the future, with help or with time, this will be oriented correctly.
You can set the seed to sprout later when adding the plant. You can click to confirm the seed sprouted today to start the age clock so you can verify the age of the plant. you can also soft delete the plant if you messed up or if the plant died. if the plant died please make sure you write an update note. update notes are showin in the 10 most recent updates. when you upload a photo an update showing you uploaded a photo shows in the 10 most recent updates. you can add a comment in the text box and then hit submit.
you can harvest the plant by clicking "harvest plant" which will allow you to insert wet weights and add it to the system allowing you to select that you harvest the plant which takes it off your active plants list. Currently the dry weights harvest page has not been created but should be easy to do based upon the harvest plant page.
you can take or select a photo by hitting choose file and hit upload. once its uploaded, you can go back by hitting admin panel or home. your home screen will always bring up the plants that are alive and not harvested or soft deleted. soft deleted items are kept in storage so that the plants are kept on record for future needs in case of audit. if you do not like this feature you can remove the plant from the plants table and strains from strain table




error "Notice: Undefined offset: 0 in C:\xampp\htdocs\plantinfo.php on line 89"
will occur until your first plant photo is uploaded, this will be remedied with error catching later.