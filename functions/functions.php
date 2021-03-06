<?php ob_start();


require_once 'php-mailer/PHPMailerAutoload.php';


/****************Helper functions***************************/

function clean($string)
{
    return  htmlentities($string);
}

function redirect($location)
{
    return header("Location: {$location}");
}

function set_message($message)
{
    if (!empty($message)) {
      $_SESSION['message'] = <<<DELIMITER

  <div class="alert alert-danger alert-dismissible " role="alert">
       <strong> WARNING:!</strong> $message
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
       </button>
  </div>

DELIMITER;

      return $_SESSION['message'];

    } else {
        $message = "";
    }
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function validation_errors($error_message)
{
    $error_message = <<<DELIMITER

<div class="alert alert-danger alert-dismissible " role="alert">
     <strong> WARNING:!</strong> $error_message
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
     </button>
</div>
DELIMITER;
    return $error_message;
}


// for email exists
function email_exists($email)
{
    $sql = "SELECT id  FROM users WHERE email = '$email'";
    $result = query($sql);
    if (row_count($result) == 1) {
        return true;
    } else {
        false;
    }
}


function username_exists($username)
{
    $sql = "SELECT id  FROM users WHERE username = '$username'";
    $result = query($sql);
    if (row_count($result) == 1) {
        return true;
    } else {
        false;
    }
}


//for sendin email
function send_email($email, $subject, $msg)
{
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
     $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

    $mail->Username = 'wealwayscareforyou114@gmail.com';                   // SMTP username
    $mail->Password = 'aliyahoo';                         // SMTP password
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->isHTML(true);
    $mail->setFrom('wealwayscareforyou114@gmail.com', 'CareForYou');
    $mail->addAddress($email);     // Add a recipient

    $mail->Subject = $subject;
    $mail->Body    ="<h2 class='bg-success'> {$msg} </h2>"  ;
    $mail->AltBody = $msg;

    return $mail->send();



    //  return mail($email, $subject, $msg, $headers);
}




// for form security
function token_generator()
{
    $token = $_SESSION['token'] =  md5(uniqid(mt_rand(), true));
    return $token;
}
/****************validation functions***************************/

function validate_user_registration()
{
    // we want see all errors bcoz we dont want to see not line by line
    $errors = [];
    $min = 3;
    $max = 20;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $first_name             = clean($_POST['first_name']);
        $last_name              = clean($_POST['first_name']);
        $username               = clean($_POST['username']);
        $email                  = clean($_POST['email']);
        $password               = clean($_POST['password']);
        $confirm_password       = clean($_POST['confirm_password']);

        if (strlen($first_name)<$min) {
            $errors[]  = "your first name cannot be less than {$min} characters";
        }
        if (strlen($last_name)<$min) {
            $errors[]  = "your last name cannot be less than {$min} characters";
        }
        if (strlen($username)<$min) {
            $errors[]  = "your username cannot be less than {$min} characters";
        }

        if (username_exists($username)) {
            $errors[]  = "Sorry that username is already registered";
        }


        if (email_exists($email)) {
            $errors[]  = "Sorry that email is already taken";
        }

        if ($password !== $confirm_password) {
            $errors[] = "your passsword fields do not match";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo validation_errors($error);
            }
        } else {
            if (register_user($first_name, $last_name, $username, $email, $password)) {
                set_message(" Please check your email or spam folder for activation ");
                redirect("index.php");
            } else {
                set_message("<p class='bg-danger text-center'> Something went wrong </p>");
                redirect("index.php");
            }
        }
    } //post
} // function


function register_user($first_name, $last_name, $username, $email, $password)
{
    $first_name = escape($first_name);
    $last_name = escape($last_name);
    $username = escape($username);
    $email = escape($email);
    $password = escape($password);

    if (email_exists($email)) {
        return false;
    } elseif (username_exists($username)) {
        return false;
    } else {
        $password = md5($password);
        $validation_code = md5($username . microtime());
        $sql ="INSERT INTO users(first_name,last_name,username,email,password,validation_code,active) ";
        $sql.=" VALUES('$first_name','$last_name','$username','$email','$password','$validation_code',0)";
        $result = query($sql);
        confirm($result); // to see query work

        // for sending mail

        $subject = "Activate your account";

        $msg = " Please click the link below to activate your Account  <br />

        <a href=\"http://localhost/login/activate.php?email=$email&code=$validation_code\"> LINKE IS HERE!</a>
          ";
        // $headers = "From: noreply@yourwebsite.com";

        send_email($email, $subject, $msg);
        return true;
    }
}

/****************activation functions***************************/

function activate_user()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['email'])) {
            $email = clean($_GET['email']);
            $validation_code = clean($_GET['code']); // becz hm ne servr ki req hi get kr di hai is

            $sql = "SELECT id FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code = '".escape($_GET['code'])."' ";
            $result = query($sql);
            confirm($result);
            if (row_count($result)== 1) {
                $sql2 = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."' AND validation_code = '".escape($validation_code)."' ";

                $result2 = query($sql2);
                confirm($result2);

                set_message("<p class='bg-success'>
       please login!!! your acoount is activated
       </p>");
                redirect("login.php");
            } else {
                set_message("<p class='bg-danger'>
      Sorry your account could not be activated.
      </p>");
                redirect("login.php");
            }
        }
    }
} //functions



/*/////////////////////// validate user login //////////////*/


function validate_user_login()
{
    // we want see all errors bcoz we dont want to see not line by line
    $errors = [];
    $min = 3;
    $max = 20;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email                  = clean($_POST['email']);
        $password               = clean($_POST['password']);
        $remember               = isset($_POST['remember']);

        if (empty($email)) {
            $error[] = "email field can't be empty";
        }
        if (empty($password)) {
            $error[] = "password field cants be empty";
        }


        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo validation_errors($error);
            }
        } else {
            if (login_user($email, $password, $remember)) {
                redirect("admin.php");
            } else {
                echo validation_errors("your credentials are not correct");
            }
        }
    }
}



  /*///////////////////////  login Function //////////////*/



  function login_user($email, $password, $remember)
  {
      $sql = "SELECT password, id FROM users WHERE email = '".escape($email)."' AND active = 1";
      $result = query($sql);

      if (row_count($result) == 1) {
          $row = fetch_array($result); // for getting password data from db
          $db_password = $row['password'];


          if (md5($password) == $db_password) {

    // for remember setting cookie

              if ($remember = "on") {
                  setcookie('email', $email, time() + 86400);
              }

              $_SESSION['email']= $email;



              return true;
          } else {
              return false;
          }

          return true;
      } else {
          return false;
      }
  }




    /*///////////////////////  logged in Function //////////////*/


function logged_in()
{
    if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
        return true;
    } else {
        return false;
    }
} //function


    /*//////////********  Recover Password *******//////////////*/

function recover_password()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

            $email = clean($_POST['email']); // from form

            if (email_exists($email)) {

                $validation_code = md5($email . microtime());

                setcookie('temp_access_code', $validation_code, time() + 1000);// ye hm ne is li ku k time ni dena itna user ko koi  bad me b acces na kry

                $sql = "UPDATE users SET validation_code = '".escape($validation_code)."' WHERE email = '".escape($email)."' ";
                $result = query($sql);
                confirm($result);

                $subject = "Please Reset your Password";

                $msg = " Here is your password reset code {$validation_code} <br />

                     <a href=\"http://localhost/login/code.php?email=$email&code=$validation_code\"> Click here to reset your password!</a>
            ";


                if (!send_email($email, $subject, $msg)) {
                    echo validation_errors("email cant be sent");
                } else {
                    set_message("<p class='bg-success text-center'> Please check your email or spam folder for password reset code </p>");
                    redirect("index.php");
                }
            } else {
                echo validation_errors("your are not registered by this email"); //email exist
            }
        } else {
            redirect("index.php"); //if token is not true
        }
    } // request metod post
}//function



  /*//////////******** COde.php validate of reciver pasword *******//////////////*/

  function validation_code()
  {
      if (isset($_COOKIE['temp_access_code'])) {
          if (!isset($_GET['email']) && !isset($_GET['code'])) {
              redirect("index.php");
          } elseif (empty($_GET['email']) && empty($_GET['code'])) {
              redirect("index.php");
          } else {
              if (isset($_POST['code'])) {

//    echo "getting post from Form";

                  $email = clean($_GET['email']);
                  $validation_code = clean($_GET['code']);
                  $sql = "SELECT id FROM users where validation_code = '".escape($_GET['code'])."' AND email = '".escape($_GET['email'])."' ";
                  $result = query($sql);
                  confirm($result);
                  if (row_count($result)==1) {

                      setcookie('temp_access_code', $validation_code, time() + 1100);// cookie for reset page

                      redirect("reset.php?email=$email&code=$validation_code");
                  } else {
                      echo validation_errors("sorry wrong validation code!");
                  }
              }
          }
      } else {
          set_message("<p class='bg-danger text-center'>
    your cookie was expired!

    </p>");
          redirect("recover.php") ;
      }
  }


  /*//////////********  Reset Password *******//////////////*/

  function reset_password()
  {
      if (isset($_COOKIE['temp_access_code'])) {
          if (isset($_GET['email']) && isset($_GET['code'])) {
              if (isset($_SESSION['token']) && isset($_POST['token'])) {
                  if ($_POST['token'] === $_SESSION['token']) {
                      if ($_POST['password']===$_POST['confirm_password']) {
                          $updated_password = md5($_POST['password']);

                          $sql = "UPDATE users SET password = '".escape($updated_password)."',validation_code=0,active=1 WHERE email = '".escape($_GET['email'])."' ";
                          $result = query($sql);

                          set_message("<div class='alert alert-success'>
                Your password is reset successfully, Please use this password when next time you login

               </div>");
                          redirect("login.php") ;
                      }
                  }
              }
          }
      } else {
          set_message("<P class='bg-danger'> You took so long so your cookie was  expired </P>");
          redirect("recover.php");
      }
  }//function
