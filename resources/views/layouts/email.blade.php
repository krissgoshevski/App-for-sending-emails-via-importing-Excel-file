<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>@yield('title', 'Email')</title> <!-- Default title set to 'Email' -->
</head>

<style> 
    body {
    font-family: Arial, sans-serif;
    /* background-color: #f4f4f4; */
    margin: 0;
    padding: 0;
}

.email {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
}

h3 {
    margin-top: 20px; 
}


p {
    margin: 5px 0; 
    font-size: 14px; 
}

.contact-info {
    margin-top: 20px;
    font-size: 12px;
}

.contact-info p {
    margin: 3px 0; 
}


.contact-info a {
    color: blue;
    text-decoration: none; 
}


.contact-info a:hover {
    color: darkblue;
}



.address-container, .service-container {
    margin-bottom: 10px; 
}

#addresses, #services {
    display: inline; 
    margin: 0;
    padding: 0; 
}

label {
    display: inline-block; 
    width: 70px; 
    vertical-align: top; 
    margin-right: 2px; 
}

.english-banner-neotel-logo{
    width: 100%;
    /* max-width: 600px; */
    margin: 0 auto;
 
}

.mk-banner-neotel-logo{
    width: 100%;
    /* max-width: 600px; */
    margin: 0 auto;
 
}

 .icons {
    text-align: center;
    background-color: #ffffff;
}

img {
    background-color: #ffffff;
}

   /* Media Query for Large Screens */
   @media only screen and (min-width: 768px) {
        .email {
            padding: 40px;
        }
        
        .icons {
            margin-top: 40px;
        }

        .address-service-container {
            margin-bottom: 20px;
        }

    }

  

</style>
<body>
    <table border='1px solid black'>

    <div class="email">
        @yield('content')
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/footer.png'))) }}" alt="Footer Neotel Logo" class="footer-neotel-logo"> <br> 
        
        <div class="icons"> 
                <a href="https://www.facebook.com/neotel.mk" target="_blank">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/ikoni/ikoni-obicni/fb-icon.png'))) }}" alt="Facebook" style="width: 24px; height: 24px; background-color: #ffffff;">
                </a>

                <a href="https://twitter.com/NeotelMKD" target="_blank">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/ikoni/ikoni-obicni/x.png'))) }}" alt="Twitter" style="width: 24px; height: 24px; background-color: #ffffff;">
                </a>

                <a href="https://www.youtube.com/channel/UCWF50BM7-ASqNeRdq_x2jEw" target="_blank">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/ikoni/ikoni-obicni/yt.png'))) }}" alt="Youtube" style="width: 24px; height: 24px; background-color: #ffffff;">
                </a>

                <a href="https://www.linkedin.com/company/neotel-macedonia" target="_blank">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/ikoni/ikoni-obicni/lin.png'))) }}" alt="Linkedin" style="width: 24px; height: 24px; background-color: #ffffff;">
                </a>

                <a href="https://www.instagram.com/neotel_mkd" target="_blank">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/assets/images/ikoni/ikoni-obicni/in.png'))) }}" alt="Instagram" style="width: 24px; height: 24px; background-color: #ffffff;">
                </a>
        </div>
    </div>
</table>
</body>
</html>
