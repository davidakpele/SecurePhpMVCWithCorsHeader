<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8" />
    <meta name="theme-color" content="#c9190c" />
    <meta name="robots" content="index,follow" />
    <meta htttp-equiv="Cache-control" content="no-cache" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="msapplication-TileColor" content="#c9190c" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Kyc Project" /> 
    <!-- css styles -->
    <link rel="stylesheet" href="<?=ASSETS?>css/fonts/font-awesome/css/all.css "/>
    <link rel="stylesheet" href="<?=ASSETS?>css/style.css" />
    <link rel="stylesheet" href="<?=ASSETS?>css/bootstrap.min.css" />
    <title><?php if(isset($data['page_title'])){echo $data['page_title'];}else{echo App_Title;}?></title>
    <!-- js script -->
    <script type="text/javascript" src="<?=ASSETS?>js/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>js/bootstrap.js"></script>
    <script>
        var root_base = "<?=ROOT?>";
    </script>
</head>
<body class="auth_body">
    <div class="container">
        <div class="login-form">
            <div class="auth">
                <div class="text-center">
                    <h2 class="auth__heading">Login to your account</h2>
                </div>
                <div class="sub_header mb-5">
                    <span class="auth__heading-sub-text">New Here?<a href="<?=ROOT?>auth/register" class="registerLink"> Sign up </a>here</span>
                </div>
                <form action="javascript:void(0)" method="post" autocomplete="off">
                    <div class="form-group">
                        <label class="form-label">Email Address:*</label>
                        <input autocomplete='off' type="text" id="email" name="email" placeholder="Enter Email or Username" class="form-input" autocomplete="off" value="">
                        <span class="emsg"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password:*</label>
                        <div class="form-input-group">
                            <input autocomplete='off' type="password" id="login_password_input" name="password" placeholder="Enter password" autocomplete="off" value="">
                            <i id="login_password_eye" class="fa fa-eye-slash"></i>
                        </div>
                        <span class="pmsg"></span>
                    </div>
                    <div class="auth__footer">
                        <button class="form-button active" id="loginButton" type="submit">
                            <span class="loader"></span>
                            <span class="text">Login</span>
                        </button>
                    </div>
                    <div class="base_error_msg_container">
                        <div class="alert__container alert--warning alert--dark" id="darkerror_resp">
                            <div class="alert__icon-box">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            </div>
                            <div class="alert__message"></div>
                            <div class="alert__close-block">
                                <span class="alert__close">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?=ASSETS?>js/validate.js"></script>
</body>
</html>