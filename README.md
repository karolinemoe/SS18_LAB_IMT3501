# SS18_LAB_IMT3501

curl -L "https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m)" > ./docker-compose <br>
sudo mv ./docker-compose /usr/bin/docker-compose <br>
sudo chmod +x /usr/bin/docker-compose <br>


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


### Installation
> Prerequisites: Regarding ports, any webserver and mysql server running locally needs to be shut off before running docker-compose up, to free up the needed ports (80, 443 and 3306). 

1. Install Docker and Git before deploying the application.

```sh
sudo apt update
```

```sh
sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    software-properties-common
    
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
    
    sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
   
   sudo apt-get update
   
   sudo apt-get install docker-ce
```

```sh
sudo apt install docker-compose 
```

```sh
sudo apt install git       
```

2. Clone our git repo

```sh
sudo git clone https://github.com/karolinemoe/SS18_LAB_IMT3501.git         
```

3. Navigate to the repo folder

```sh
cd SS18_LAB_IMT3501/
```

4. Run docker compose
> It takes some time to deploy it, so be patient. If you like, you can press __ctrl+shift+t__ to open a new tab in terminal so you can run this in background.

```sh
sudo docker-compose up
```

After you deploy it, you can open your favorite browser and type localhost. It will direct you to the forum, the url will be localhost/php/ <br/>

# Dummy data is provided and existing users/admin have the following credentials: <br/>
Uname: user1 Passwd: user1 <br/>
Uname: user2 Passwd: user2 <br/>
Uname: user3 Passwd: user3 <br/>
Uname: admin Passwd: admin <br/>


