<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flex Sports Wear</title>
   
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>

    <!-- Bootstrap CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>

    <!-- Bootstrap Js -->
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js'></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Your CSS -->
     <style>
         
         body    {
             background-color: #dedede;
                 
         }
        
        .navbar {
            padding: 0px 100px; /* Adjust the padding */
            
            
        }
       
        .navbar-nav .nav-link {
            font-size: 15px;
            font-family: Copperplate;
            transition: border-bottom 0.9s ease;
        }

        .navbar-nav .nav-link:hover {
            border-bottom: 1px solid;
        }
            
        .member-button {
            margin-left: 700px;
            color: #FFFFFF;
            background-color: transparent;
            border: none;
        }

        * {
            box-sizing: border-box;
        }

        .search-box{
            width: fit-content;
            height: fit-content;
            position: relative;
}

        .input-search {
            height: 30px;
            width: 30px;
            border: none;
            padding: 10px;
            font-size: 18px;
            letter-spacing: 2px;
            outline: none;
            border-radius: 40px;
            transition: width 0.5s ease-in-out; /* Added transition */
            background-color: #E7E7E7;
            color: #000000;
        }

        .input-search::placeholder {
            color: rgba(255, 255, 255, 0.5);
            font-size: 18px;
            letter-spacing: 2px;
            font-weight: 100;
        }

        .btn-search {
            width: 40px;
            height: 40px;
            border: none;
            font-size: 20px;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
            position: absolute;
            right: -5px;
            top: -25px; /* Adjusted top position for responsiveness */
            transform: translateY(50%); /* Center vertically */
            color: #000000;
            
        }

        .btn-search:focus ~ .input-search {
            width: 200px;
            border-radius: 10px;
            outline: none;
                  
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 500ms cubic-bezier(0, 0.11, 0.35, 2);
        }

        .input-search:focus{
            width: 200px;
            border-radius: 20px;
            border: 10px;
            border-color: #000000;
            background-color: #E7E7E7;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 500ms cubic-bezier(0, 0.11, 0.35, 2);
        }
        
       btn-profile {
            
            border: none;
            font-size: 20px;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
            position: absolute;
            right: -90px; /* Adjusted position */
            top: -25px; /* Adjusted top position for responsiveness */
            transform: translateY(50%); /* Center vertically */
            color: #000000;
        }
        
        .container{
            
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 60px;
            margin-bottom: 60px;
            
            
        }
        
        .gallery{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .img-box{
            width: 200px;
            height: 500px;
            margin: 10px;
            border-radius: 50px;
            background: url(Adidas.png);
            background-size: cover;
            background-position: center;
            position: relative;
            transition: width 0.5s;
            display: flex;
            flex-direction: column;
            padding: 30px;   
                
        }
        
        .img-box h3 {
            margin-top: 5px; /* Adjust vertical placement */
            margin-bottom: auto; /* Adjust vertical placement */
            margin-left: auto; /* Adjust horizontal placement */
            margin-right: auto; /* Adjust horizontal placement */
            font-size: 21px;
            font-family: Copperplate;
            
            }   
            
        .img-box:nth-child(2){
            background: url(Nike.png);
            background-size: cover;
            background-position: center;
            
        }
        
        .img-box:nth-child(3){
            background: url(UA.png);
            background-size: cover;
            background-position: center;
        }
        
        .img-box:nth-child(4){
            background: url(Flex.png);
            background-size: cover;
            background-position: center;
        }
        
        
        .img-box:hover{
            width:650px;
            cursor: pointer;
            
        }
        
        .container {
  position: relative;
  font-family: sans-serif;
  color:#FFFFFF;
  
}


        .container .box {
  width: 550px;
  height: 15.875em;
  padding: 1rem;
  color: #000000;
  border: 1px solid rgba(255, 255, 255, 0.222);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 0.7rem;
  transition: all ease 0.3s;
  background-color:#FFFFFF;
}

        .container .box {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

        .container .box .title {
  font-size: 2rem;
  font-weight: 500;
  letter-spacing: 0.1em;
}

        .container .box div strong {
  display: block;
  margin-bottom: 0.5rem;
}

        .container .box div p {
  margin: 0;
  font-size: 0.9em;
  font-weight: 300;
  letter-spacing: 0.1em;
}

.container .box div span {
  font-size: 0.7rem;
  font-weight: 300;
}

.container .box div span:nth-child(3) {
  font-weight: 500;
  margin-right: 0.2rem;
}

.container .box:hover {
  box-shadow:  7px 7px 14px #323232,
             -7px -7px 14px #535353;
  border: 1px solid rgba(255, 255, 255, 0.454);
}

        
</style>

</head>
<body>
    <!-- Your HTML content goes here -->
    <div class="member-navbar" style="background-color: #000000;">
        <button type="button" class="member-button">FREE SHIPPING FOR MEMBERS</button>
        
    </div>
    
    <div class="navigation-wrap bg-light start-header start-style">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <img src="logo.png" alt="" style="width: 200px; height:120px; margin-left:-150px;">	
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto py-4 py-md-0">
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">MEN</a>
                                    <div class="dropdown-menu" style="margin-left:150px">
                                        <a class="dropdown-item" href="#">Clothing</a>
                                        <a class="dropdown-item" href="#">Shoes</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </div>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">WOMEN</a>
                                    <div class="dropdown-menu" style="margin-left:250px">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                    </div>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="#">Agency</a>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" hrfe="#">Services</a>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="#">Journal</a>
                                </li>
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <a class="nav-link" href="#">Contact</a>
                                </li>
                                <!-- Profile Icon -->
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <button class="btn-profile"><i class="fas fa-user"></i></button>
                                </li>
                                <!-- Search Box -->
                                <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                    <div class="search-box">
                                        <button class="btn-search"><i class="fas fa-search"></i></button>
                                        <input type="text" class="input-search" placeholder=" Type to Search..." style="font-size:15px;">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
                                <div class="container">
                                    <div class="gallery">
                                        <div class="img-box"><h3>Adidas</h3></div>
                                        <div class="img-box"><h3>Nike</h3></div>
                                        <div class="img-box"><h3>Under Armour</h3></div>
                                        <div class="img-box"><h3>Puma</h3></div>
                                        
                                    </div>
        
        </div>
    
   <marquee behavior="scroll" direction="right" scrollamount="15" style="font-size: 50px; font-family: Copperplate; margin-bottom: 60px;">SHOP NOW</marquee>

   <div class="container">
  <div class="box">
    <span class="title">SHOES</span>
    <div>
    </div>
  </div>
</div>
   
</body> 
    
    
</body>
</html>
