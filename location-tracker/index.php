<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../location-tracker/img/logo.png">
  <meta charset="UTF-8">
  <title>Home - Paaila</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: 'Trebuchet MS', sans-serif;
    }

    
    #landing {
      position: fixed;
      z-index: 9999;
      background: #fff;
      width: 100%;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      animation: hideLanding 1s ease forwards;
      animation-delay: 5s;
    }

    .logo-container {
      position: fixed;
      top: 30%;
      left: 40%;
      width: 400px;
      height: 150px;
    }

    .trekker {
      position: absolute;
      left: -60px;
      top: 75px;
      bottom: 0;
      width: 38px;
      animation: walk 2s forwards;
    }

    .text {
      color: red;
      position: absolute;
      left: 80px;
      bottom: 10px;
      font-size: 48px;
      opacity: 0;
      animation: fadeInText 1s 1.5s forwards;
    }

    .plane {
      opacity: 0;
      position: absolute;
      top: 70px;
      left: 80px;
      width: 40px;
      animation: flyIn 1s ease-in-out 2.5s forwards;
    }

    @keyframes walk {
      to {
        left: 200px;
      }
    }

    @keyframes fadeInText {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes flyIn {
      0% {
        opacity: 1;
        top: 70px;
        left: 80px;
        transform: rotate(0deg);
      }
      100% {
        opacity: 1;
        top: 77px;
        left: 120px;
        transform: rotate(-1deg);
      }
    }
    @keyframes hideLanding {
      to {
        opacity: 0;
        visibility: hidden;
      }
    }


    /* Main site content */
    #main-content {
      opacity: 0;
      animation: fadeInMain 1s ease forwards;
      animation-delay: 5.2s;
      padding: 0;
    }

     nav {
            background-color: red;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5%;
        }

        #logo {
            max-height: 40px;
            max-width: 80px;
        }

        #right ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 40px;
        }

        #right li a {
            text-decoration: none;
            color: white;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-weight: bold;
            font-size: large;
            transition: color 0.3s;
        }

        #right li a:hover {
            color: #f19430ff;
        }

        

    @keyframes fadeInMain {
      to { opacity: 1; }
    }





     @media (max-width: 768px) {
            .logo-container {
                top: 35%;
                left: 20%;
                height: auto;
                align-content: flex-start;
            }

            .trekker {
                width: 30px;
                top: 50px;
                left: 20px;
                animation: walkMobile 2s forwards;
            }

            .text {
                     color: red;
                     top: 60px;
                     left: 60px;
                     font-size: 34px;
                     opacity: 0;
            }
            .sec{
              position: relative;
              top: 90px;
              color: red;
              left: 48px;
              font-size: 1px;
              opacity: 0;
              animation: fadeInText 1s 1.5s forwards;
            }
            .plane {
                width: 30px;
                top: 50px;
                left: 50px;
                animation: flyInMobile 1s ease-in-out 2.5s forwards;
            }

            nav {
                padding: 8px 4%;
            }

            #nav {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            #right ul {
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }

            #right li a {
                font-size: 16px;
            }

            #logo {
                max-width: 60px;
                max-height: 30px;
            }
        }

        @keyframes walkMobile {
            to { left: 150px; }
        }

        @keyframes flyInMobile {
            0% {
                opacity: 1;
                top: 50px;
                left: 60px;
                transform: rotate(0deg);
            }
            100% {
                opacity: 1;
                top: 57px;
                left: 90px;
                transform: rotate(-1deg);
            }
        }
  </style>
</head>
<body>


<div id="landing">
  <div class="logo-container">
    <img src="../location-tracker/img/treaker.png" alt="Trekker" class="trekker">
    <div class="text">Paaila</div>
    <img src="../location-tracker/img/plane.png" alt="Plane" class="plane">
      <div class="text sec" style="font-size: small;">with you in every steps...</div>
  </div>
</div>


<div id="main-content">
   <nav>
        <div id="nav">
            <div id="left">
                <a href="#home"><img src="../location-tracker/img/logo.png" alt="Logo" id="logo"></a>
            </div>
            <div id="right">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#package">Packages</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="../location-tracker/login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

</body>
</html>
