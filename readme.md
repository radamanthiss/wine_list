# wine_list Application

This application run in a local environment

# Install and config wampserver
download [link](https://sourceforge.net/projects/wampserver/files/)
and init the control panel of wampp and activate de apache, mysql, php module.

# Install or configure cloudAMQP

### Initial steps to execute the project
Put the project into route C:/wamp64/www/ and then we can access to differents route

1. (http://localhost/list_wine/models/create_database.php) create database
2. (http://localhost/list_wine/models/create_table.php) create table into database
3. (http://localhost/list_wine/models/data_load.php) charge first time the RSS Feed
4. (http://localhost/list_wine/models/update_wine.php) update the wine list every day
5. (http://localhost/list_wine/views/index.php) principal view for application
6. (http://localhost/list_wine/views/validacion.php) receive the paramaters from home and creat the RabbitMQ
7. (http://localhost/list_wine/views/response.php) consume the RabbitMQ queue and show response to user


After knowing the project routes is necessary configure a instance for rabbitMQ, the proyect use 
[link](https://customer.cloudamqp.com/instance) CloudAMQP, here use the option Create new instance

![cloudamq](https://user-images.githubusercontent.com/22681704/54212697-47710480-44b1-11e9-85ba-a188835adaf4.PNG)

Then write the name for a new instance and select the option select region

![region](https://user-images.githubusercontent.com/22681704/54213007-b2bad680-44b1-11e9-8911-deb9c14e7eb8.PNG)

Then choose the option for a datacenter and choose the bottom review, finally confirm the create of instance

![datacenter](https://user-images.githubusercontent.com/22681704/54213066-ca925a80-44b1-11e9-88c0-b563cbd2ae97.PNG)

Finally configure with the details variables in the section of our instance, and replace the parameters in the archive (http://localhost/list_wine/views/response.php) and in the (http://localhost/list_wine/views/validacion.php), the parameters
to change are $host, $user, $pass, $port, $vhost in both archives

We can see the details after create a instance, if we want to see the rabbitMQ manager, choose the bottom 
like in the image

![details](https://user-images.githubusercontent.com/22681704/54213351-41c7ee80-44b2-11e9-814a-237101892497.PNG)


## RabbitMQ Manager

After configure the instance we can access to rabbitMQ manager, in this page we can administer the Queue

![rabbit](https://user-images.githubusercontent.com/22681704/54213574-a2efc200-44b2-11e9-998c-613f6e13468f.PNG)

# Install composer
in a cmd console if use windows os or in a terminal if user linux, choose the project and execute composer
init, then we follow the steps in console 

1. package name: press enter
2. description[]: write the project description and press enter
3. author[]: press enter
4. minimum stability: write stable and press enter
5. composer option: write project and pres enter
6. license []: press enter
7. dependencies: write no and press enter
8. confirm generation: write yes and press enter

finally execute composer install

# IMPORTANT RECOMMENDATIONS !!

Use the route 1 and 2 list in the section initial steps, is important because with this file we create 
the database and table for the project.

In the archive (http://localhost/list_wine/controllers/db_connect.php) modify the functions db_connect and db_connect_initial
change the value for variables to connect phpmyadmin/mysql and can create connections in the differents archive in the application.

Any questions can be written to the email ulkevinb@gmail.com or to the skype startek13

# Project Structure

The project is MVC type, it has the folders views, models and controllers, it also has a public folder where the css and the images of the project are located, finally we find a log folder where we store the transaction log of the application.


# Use of application wine

For use the application we  launche the route (http://localhost/list_wine/views/index.php) only if we already created the database and the table and launc the route (http://localhost/list_wine/models/data_load.php) to charge the rss feed into table wine. we can see the home page of our project

![home](https://user-images.githubusercontent.com/22681704/54214818-ecd9a780-44b4-11e9-9998-f616139df714.PNG)

if we choose the bottom submit, we sent to validacion page, to create the rabbitMQ and put in a queue the data
the validacion.php page looks like this

![validation](https://user-images.githubusercontent.com/22681704/54215119-62de0e80-44b5-11e9-83a5-47c5b007d376.PNG)

And the queue is created, we can see the queue and get the message in the queue

![queue](https://user-images.githubusercontent.com/22681704/54215189-843efa80-44b5-11e9-9a6b-2774dc7360c1.PNG)

get the message in the queue

![messages](https://user-images.githubusercontent.com/22681704/54215332-bd776a80-44b5-11e9-8434-91b54bfdd8a9.PNG)

then in the validation page, we can check the bottom show and then send to response page, to process the queue
and show the answer for the user


![response](https://user-images.githubusercontent.com/22681704/54215507-0b8c6e00-44b6-11e9-8440-c113502274a5.PNG)
 
And check the queue and the messages is consumed

![empty](https://user-images.githubusercontent.com/22681704/54216123-0f6cc000-44b7-11e9-9839-f7265d98224f.PNG)

# Logs 

we can see the transactions of application in the route Log/data_echa.log, the log file has the response of the executions and possible errors

![log](https://user-images.githubusercontent.com/22681704/54219330-4d6ce280-44bd-11e9-876a-0c404ed057ef.PNG)




