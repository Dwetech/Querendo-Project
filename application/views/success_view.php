<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('include/head'); ?>
    <?php $this->load->view('include/header'); ?>
</head>
<body>
<div style="min-height: 500px;">
    <div class="row well col-md-6 col-md-offset-3" style="margin-top: 100px;">
        <div>
            <div class="alert alert-success" style="font-size: 16px;text-align: center;">
                <?php
                if (($this->session->flashdata('success')))
                    echo $this->session->flashdata('success');
                else
                    redirect('home');
                ?>
            </div>
        </div>
        <div style="font-size: 20px;text-align: center;">
            <?php
            if (($this->session->flashdata('message')))
                echo $this->session->flashdata('message');
            else
                redirect('home');
            ?>
        </div>
    </div>
</div>
</body>
<?php $this->load->view('include/login-modal.php'); ?>
<?php $this->load->view('include/signup-modal.php'); ?>
<?php $this->load->view('include/footer'); ?>
</html>