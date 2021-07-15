# THE VIDEO RECORDING TASK
### Intoduction:
This is a small application built using **Laravel** to record a video using 
webcam via **MediaStream Recording API** check browser compatibility [here](https://developer.mozilla.org/en-US/docs/Web/API/MediaStream_Recording_API#browser_compatibility). 
A demo can be found deployed on Heroku here: [Demo Link](https://zarroug.herokuapp.com/public/). 
For remote mysql database I used [Cloud Clusters](https://www.cloudclusters.io/)
  
**Dashboard details:**
*email*:  admin@email.com
*Password*:  123456

---
### Run this app on your system
---
**Requirments:** *PHP8, Laravel8, Composer, Git*

Install:

    git clone https://github.com/MedZed/HCG.git
    cd HCG
    composer update
    composer install
    php artisan php artisan link storage

Update dependecies:
   
    composer update
    composer install
    php artisan php artisan link storage
    
Config & databasa: (Might need to setup .env file for database connection first)
 
	php artisan key:generate
	php artisan db:seed AdminSeeder
	php artisan storage:link
   
Run

    php artisan serve


## TODO

 - Fix bugs concerning http ajax submission
 - Convert Frontend to **React**
 - Implement a better 
