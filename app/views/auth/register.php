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
        <div class="register-form">
            <div class="regsiter-auth">
                <div class="register__img-box"><img src="<?=ASSETS?>images/login_logo.png" alt=""></div>
                <div class="text-center">
                    <h2 class="auth__heading">Setup login details</h2>
                </div>
                <div class="sub_header mb-5">
                    <span class="auth__heading-sub-text">You’ll use your email and password to login to your account</span>
                </div>
                <form action="javascript:void(0)"  method="post" accept-charset="utf-8" enctype="multipart/form-data" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Fullname:<span class="im_input">*</span></label>
                                <input autocomplete='chrome-off' type="text" id="fullname" name="fullname" placeholder="Enter Name" class="form-input" autocomplete="off" value="">
                                <span class="fmsg"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Email Address:<span class="im_input">*</span></label>
                                <input autocomplete='chrome-off' type="text" id="email" name="email" placeholder="Enter email address" class="form-input" autocomplete="off" value="">
                                <span class="emsg"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Date of Birth:<span class="im_input">*</span></label>
                                <input autocomplete='chrome-off' type="date" id="dbo" name="dbo" class="form-input" autocomplete="off" value="">
                                <span class="dbomsg"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mobile No:<span class="im_input">*</span></label>
                                <div class="form-input-group">
                                    <input autocomplete='chrome-off' type="tel" id="mobile" name="mobile" placeholder="+(453) 4534-5345-34"/>
                                </div> 
                                <span class="mbmsg"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">CV/Resume:<span class="im_input">*</span></label>
                                <div class="form-input-group">
                                    <input autocomplete='chrome-off' type="file" id="cv" name="cv" />
                                </div> 
                                <span class="cvmsg"></span>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label class="form-label">Password:<span class="im_input">*</span></label>
                        <div class="form-input-group">
                            <input autocomplete='chrome-off' type="password" id="password_input" name="password" placeholder="Enter new password" autocomplete="off" value="">
                            <i id="password_eye" class="fa fa-eye-slash"></i>
                        </div>
                        <span class="pmsg"></span>
                    </div>
                    <ul class="strength-list form-requirements">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                                    <li> 
                                        <span class="loweruppercase list-group">
                                            <div ms-code-pw-validation-icon="false" class="icon_invalid w-embed">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22C6.477 22 2 17.523 2 12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12C22 17.523 17.523 22 12 22ZM12 10.586L9.172 7.757L7.757 9.172L10.586 12L7.757 14.828L9.172 16.243L12 13.414L14.828 16.243L16.243 14.828L13.414 12L16.243 9.172L14.828 7.757L12 10.586Z" fill="currentColor"></path>
                                                </svg>
                                            </div>
                                            <span class="validate_text">Lowercase uppercase</span>
                                        </span> 
                                    </li>
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                                        <li> 
                                        <span class="numbercase list-group">
                                            <div ms-code-pw-validation-icon="false" class="icon_invalid w-embed">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22C6.477 22 2 17.523 2 12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12C22 17.523 17.523 22 12 22ZM12 10.586L9.172 7.757L7.757 9.172L10.586 12L7.757 14.828L9.172 16.243L12 13.414L14.828 16.243L16.243 14.828L13.414 12L16.243 9.172L14.828 7.757L12 10.586Z" fill="currentColor"></path>
                                                </svg>
                                            </div>
                                            <span class="validate_text">Number (0-9)</span>
                                        </span> 
                                    </li>
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                                    <li> 
                                        <span class="specialcase list-group">
                                            <div ms-code-pw-validation-icon="false" class="icon_invalid w-embed">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22C6.477 22 2 17.523 2 12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12C22 17.523 17.523 22 12 22ZM12 10.586L9.172 7.757L7.757 9.172L10.586 12L7.757 14.828L9.172 16.243L12 13.414L14.828 16.243L16.243 14.828L13.414 12L16.243 9.172L14.828 7.757L12 10.586Z" fill="currentColor"></path>
                                                </svg>
                                            </div>
                                            <span class="validate_text" style="font-size: 10px;">Special Characters(!#@$%*)</span>
                                        </span> 
                                    </li>
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12">
                                    <li> 
                                        <span class="numcharacter list-group">
                                            <div ms-code-pw-validation-icon="false" class="icon_invalid w-embed">
                                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22C6.477 22 2 17.523 2 12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12C22 17.523 17.523 22 12 22ZM12 10.586L9.172 7.757L7.757 9.172L10.586 12L7.757 14.828L9.172 16.243L12 13.414L14.828 16.243L16.243 14.828L13.414 12L16.243 9.172L14.828 7.757L12 10.586Z" fill="currentColor"></path>
                                                </svg>
                                            </div>
                                            <span class="validate_text">8 Characters</span>
                                        </span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </ul>
                    <div class="form-group">
                        <label class="form-label">Confirm Password:<span class="im_input">*</span></label>
                        <div class="form-input-group">
                            <input autocomplete='chrome-off' type="password" id="Confirmpassword" name="Confirmpassword" placeholder="Re-type password" autocomplete="off" value="">
                            <i id="cpassword_eye" class="fa fa-eye-slash"></i>
                        </div>
                        <span class="cmsg"></span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address:<span class="im_input">*</span></label>
                        <textarea  rows="4" cols="50" id="address" name="address" placeholder="Enter your address"></textarea>
                        <span class="addmsg"></span>
                    </div>
                    
                    <div class="auth__footer">
                        <button class="form-button inactive" id="registerButton" disabled="disabled" type="submit">Register Now</button>
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
                <div class="newUser">
                    <span>Already have an account? <a href="<?=ROOT?>auth/login/">Login here</a></span>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?=ASSETS?>js/validate.js"></script>
</body>
</html>