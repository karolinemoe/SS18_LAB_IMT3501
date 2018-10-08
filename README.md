# SS18_LAB_IMT3501

## Members  
Karoline Moe Arnesen (473190) - PROG  
Kjetil Wilhelmsen Helgås (473187) - PROG  
Jørgen Jærnes (473179) - PROG  
Anders Gustad (699643) - BITSEC  
Daniel C. H. Magnus(473141) - BITSEC  
Adrian J. Moen (473156) - BITSEC  
Abu Baker Al Shammari (473154) - BITSEC  

## Assignment Description
This is a group assignment, and each group should consist of at least 4 and at most 7 members. At least 3 members of each group should be students of "Bachelor in Programming" study program. 


In this assignment and next ones, you are asked to develop a simple secure discussion forum. The forum should have a simple GUI, a controller and a DB. It has a sign up and a login functions. Users can create topics in various categories, and other users  can post replies.Messages can be posted as either replies to existing messages or posted as new messages. The forum organizes visitors and logged in members into user groups. Privileges and rights are given based on these groups.  

### Lab_1
In the first assigment you have to specify functional and  security requirements, as well as develop the first design draft of the application, including the database schema. You are free to choose the types and tools that you use for developing the design models. 

### Lab_2
In this assignment you have to continue the development process of your forum applicaiton. After you finish with the requirements and high level design, you start with the detailed design of each module of the application that fulfills your requirements. Then you implement the application.  

Divide the team into smaller groups (1-2), each of is responisible for one module of the application.  This assignment has two submissions, a running application and an installation guide. 


### Installation (not complete)
1. It is important to have Docker installed before deploy the forum.

```sh
sudo apt update
```

```sh
sudo apt install docker
```

```sh
sudo apt install docker-compose 
```

* Clone the documents from git and run the forum

__It is important that you have git installed and have a user in GitHub so you can clone the documents__

```sh
sudo git clone https://github.com/karolinemoe/SS18_LAB_IMT3501.git         
```

```sh
cd SS18_LAB_IMT3501/
```

If you like, you can press __ctrl+shift+t__ to open a new tab in terminal so you can run this in background.

```sh
sudo docker-compose up
```
> It takes some time to deploy it, so be patient

After you deploy it, you can open your favorite browser and type localhost. It will direct you to the forum, the url will be localhost/php/ 

