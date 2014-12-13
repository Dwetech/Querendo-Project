<!doctype html>
<html lang="en-US">
<head>
    <?php $this->load->view('admin/include/head'); ?>
</head>
<body>


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title text-success">Entre para continuar ao Painel Admin</h1>
                <div class="account-wall">
                    <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                         alt="">
                    <form class="form-signin" action="<?php echo base_url(); ?>admin/login" method="post">
                        <input name="email" type="email" class="form-control" placeholder="E-mail" required autofocus>
                        <input name="password" type="password" class="form-control" placeholder="Senha" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Submit">
                            Entrar</button>
                        <label class="checkbox pull-left">
                            <input type="checkbox" value="remember-me" name="remember">
                            Lembrar-me
                        </label>
                        <a href="#" class="pull-right need-help">Precisa de ajuda? </a><span class="clearfix"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>