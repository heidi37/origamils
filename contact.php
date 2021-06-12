<!doctype html>
<html class="no-js" lang="">
    <head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    </head>

    <body>
        
        <header>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                <img src="img/origamils-logo-only.png" alt="Origamils Logo" class="d-inline-block align-text-top">Origamils
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="#pieces">pieces</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#about">about</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#contact">contact</a>
                    </li>
                </ul>
                </div>
            </div>
            </nav>

        </header>

        <main>
            <div class = "container">

            <?php
            // Checks if form has been submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                function post_captcha($user_response) {
                    $fields_string = '';
                    $fields = array(
                        'secret' => '6Lfx6SsbAAAAAH5lQ4NbMdPG88wexPwPcrCr-adV',
                        'response' => $user_response
                    );
                    foreach($fields as $key=>$value)
                    $fields_string .= $key . '=' . $value . '&';
                    $fields_string = rtrim($fields_string, '&');

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                    curl_setopt($ch, CURLOPT_POST, count($fields));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

                    $result = curl_exec($ch);
                    curl_close($ch);

                    return json_decode($result, true);
                }

                // Call the function post_captcha
                $res = post_captcha($_POST['g-recaptcha-response']);

                if (!$res['success']) {
                    // What happens when the CAPTCHA wasn't checked
                    echo '<p>Please click the back button and make sure you check the security CAPTCHA box.</p><br>';
                } else {
                    // If CAPTCHA is successfully completed...

                    // Paste mail function or whatever else you want to happen here!
                    if($_POST) {

                        $visitor_email = "";
                        $visitor_message = "";
                        $email_body = "<div>";
                        
                    
                    
                        if(isset($_POST['visitor_email'])) {
                            $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['visitor_email']);
                            $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
                            $email_body .= "<div>
                                            <label><b>Visitor Email:</b></label>&nbsp;<span>".$visitor_email."</span>
                                            </div>";
                        }
                        
                        
                        if(isset($_POST['visitor_message'])) {
                            $visitor_message = htmlspecialchars($_POST['visitor_message']);
                            $email_body .= "<div>
                                            <label><b>Visitor Message:</b></label>
                                            <div>".$visitor_message."</div>
                                            </div>";
                        }
                        
                            $recipient = "hfryzell@gmail.com";
                        
                        
                        $email_body .= "</div>";
                    
                        $headers  = 'MIME-Version: 1.0' . "\r\n"
                        .'Content-type: text/html; charset=utf-8' . "\r\n"
                        .'From: ' . $visitor_email . "\r\n";
                        
                        if(mail($recipient, $email_title, $email_body, $headers)) {
                            echo '<p>Thank you for contacting us. You will get a reply within 24 hours.</p><p><a href="index.html">Go back</a> to ORIGAMILS.</p>';
                        } else {
                            echo '<p>We are sorry but the email did not go through.</p>';
                        }
                        
                    } else {
                        echo '<p>Something went wrong</p>';
                    }
                }
            } ?>

            </div>
        </main>
    </body>
</html>


