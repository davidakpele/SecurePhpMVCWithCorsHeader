<!DOCTYPE html>
<html lang="en">
<?php $this->view("./components/Header");?>
<body>
    <?php $this->view("./components/NavBar");?>
        <section class="content container-fluid">
            
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Data</h3>
                        <div class="box-tools pull-right">
                            <a href="<?=ROOT?>" class="btn btn-sm btn-flat btn-primary">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </div> 
                    <div class="row">
                        
                        <div class="<?=((isset($_SESSION['UserId']) && $_SESSION['UserId'] == $data['id'])?'col-md-6':'col-md-12')?>">
                            <div class="box-body">
                            <div class="editform">
                                <form action="javascript:void(0)"  id="user_info" method="post" accept-charset="utf-8">
                                    <input type="hidden" id="id" value="<?=((isset($_SESSION['UserId']) && $_SESSION['UserId'] == $data['id'])?$data['id']:$data['id'])?>"/>
                                    <div class="form-group">
                                        <label for="name">Name:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?=((!empty($data['user'])) ? $data['user']->name : '')?>" placeholder="Name"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile:<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" name="mobile" id="mobile" value="<?=((!empty($data['user'])) ? $data['user']->mobile : '')?>" placeholder="Last Name:" />
                                    </div>
                                        
                                    <div class="form-group">
                                        <label for="email">Email:<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="Email" id="email" value="<?=((!empty($data['user'])) ? $data['user']->email : '')?>" placeholder="Student Email"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="DBO:">Date of Birth:<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="dob" id="dob"  value="<?=((!empty($data['user'])) ? $data['user']->dob : '')?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="Address:">Address:<span class="text-danger">*</span></label>
                                        <textarea  rows="4" cols="50" id="address" name="address" placeholder="Enter your address"><?=((!empty($data['user'])) ? $data['user']->address : '')?></textarea>
                                    </div>
                                
                                    <div class="form-group pull-right">
                                        <button type="reset" class="btn btn-flat btn-danger">
                                            <i class="fa fa-rotate-left"></i> Reset
                                        </button>
                                        <button type="submit" id="isEditStudent" class="btn btn-flat bg-green">
                                            <i class="fa fa-pencil"></i> Update
                                        </button>
                                    </div> 
                                </form>
                            </div>
                        </div>	
                    </div>
                    <?php if((isset($_SESSION['UserId']) && $_SESSION['UserId'] == $data['id'])):?>
                        <div class="col-md-6">
                            <h4>This Side Only visible "if edit ID Match <b>active</b> User" </h4>
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Change Password</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                                <form action="javascript:void(0)" id="isUpdataPassword" method="post" accept-charset="utf-8">
                                <div class="box-body pb-0">
                                    <div class="form-group oji1">
                                        <label for="old">Current Password</label>
                                        <input type="password" placeholder="Current Password" id="old" class="form-control">  
                                        <small class="help-block1"></small>
                                    </div>
                                        <div class="form-group">
                                        <div class="form-group oji2">
                                            <label for="new">New Password</label>
                                            <input type="password" placeholder="New Password" id="new" class="form-control">
                                            <small class="help-block2"></small>
                                        </div>
                                        <div class="form-group oji3">
                                            <label for="new_confirm">Confirmation Password</label>
                                            <input type="password" placeholder="Confirmation Password" id="new_confirm" class="form-control">
                                            <small class="help-block3"></small>
                                        </div>
                                    </div>
                                <div class="box-footer">
                                <button type="reset" class="btn btn-flat btn-danger"><i class="fa fa-rotate-left"></i> Reset</button>
                                <button type="submit" id="btn-pass" class="btn btn-flat btn-primary">Change Password</button>            
                            </form>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <script type="module"  src="<?=ASSETS?>js/edit.js"></script>
</body>
</html>