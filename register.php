<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MuthootOne | Registeration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index2.html"><b>Muthoot</b>One</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Register a new membership</p>
        <form action="home.html" method="post" id="HomeForm">
          <div class="form-group has-feedback mail-group">            
            <input id="email" type="email" class="form-control" placeholder="Email" autocomplete="off">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <label class="control-label email-error" for="inputError" style="display:none"><i class="fa fa-times-circle-o"></i> please provide your email</label>
          </div>
          <p class="login-box-msg text-red error-message" style="display:none">Email not exist</p>
          <p class="login-box-msg text-green success-message" style="display:none"></p>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" id="terms" checked="checked"> I agree to the <a href="#"> terms </a>
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="button" id="SignIn" class="btn btn-primary btn-block btn-flat">Sign Up 
                <i class="fa fa-spinner fa-spin loader" style="display:none"></i>
              </button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="forgot.html">I forgot my password</a><br>
        <a href="login.html" class="text-center">I already have a account</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- MD5 -->
    <script src="plugins/md5/jquery.md5.js"></script>
    <!-- Config and Common -->
    <script src="plugins/js/config.js"></script>
    
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });

        $( "#terms" ).on("ifClicked", function() {
            if($('#terms').prop('checked')){
                $('#SignIn').prop('disabled', true);
            }
            else{
                $('#SignIn').prop('disabled', false);
            }
        });

        $( "#SignIn" ).click(function() {            
            if($.trim($("#email").val()) == ""){
                $(".mail-group").addClass("has-error");
                $(".email-error").show();
                $("#email").focus();
                return false;;
            }            
            $(".loader").show();
            var person = {
                UserName: $.trim($("#email").val()),
            }
            jQuery.ajax({
                url: SERVICE_URL + 'GlCustomCustomer/GetCustomerDetailsByEmail',
                method: "POST",    
                contentType: 'application/json',   
                data: JSON.stringify(person),                    
                beforeSend: function (xhr) {
                   xhr.setRequestHeader('Authorization', makeBaseAuth('', AUTHENTICATION_PASSWORD));
                },
                error: function(xhr, status, error) {
                    $(".error-message").html("Sorry, could not able to connect the server. Please try again later");
                    $(".error-message").show();
                    $(".loader").hide();
                },
                success: function(data) {
                   if(data['status'] == "1"){
                      var message = "An email has been sent to " + $.trim($("#email").val()) + ". You should recieve it shortly in 10-15 mins. Sometimes email go to promotions/spam folders.";
                      $(".success-message").html(message);
                      $(".success-message").show();
                      
                      // Email API
                      data['data']['email'] = $.trim($("#email").val());
                      jQuery.ajax({
                          url: MAIL_SERVICE_URL + 'mail.php',
                          method: "POST",    
                          contentType: 'application/json',   
                          data: JSON.stringify(data['data'])
                      });

                   }
                   else{
                      $(".error-message").show();
                   }
                   $(".loader").hide();
                }
           });

        });

        $('#email').on('keyup blur change', function(e) {
            $(".mail-group").removeClass("has-error");
            $(".email-error").hide();
        });
      });            
    </script>

  </body>
</html>
<!--
https://mandrillapp.com/api/docs/messages.JSON.html#method=send

https://www.ventureharbour.com/transactional-email-service-best-mandrill-vs-sendgrid-vs-mailjet/
-->