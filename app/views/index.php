<!DOCTYPE html>
<html lang="en">
<?php $this->view("./components/Header");?>
<body>
    <?php $this->view("./components/NavBar");?>
    <section class="content container-fluid">
        <div class="box">
            <div class="box-body">
                <div class="mt-2 mb-4">
                    <button type="button" class="btn btn-sm bg-blue btn-flat" disabled="disabled"><i class="fa fa-plus"></i> Add Data</button>
                    <button class="btn btn-sm btn-flat btn-success" disabled="disabled"><i class="fa fa-upload"></i> Import</button>
                    <div class="pull-right insiderBox" id="iz" style="display:none">
                        <button id="delete__Btn" title="Delete This Professor" class="btn btn-sm btn-danger btn-flat" type="button"><i class="fa fa-trash"></i> Delete</button>
                        <button disabled="disabled" class="btn btn-sm" style="background-color: #000000; border-radius:25px"><span class="pull-left" id="deletebadge" style="color: #fff;">Selected</span></button>
                    </div>
                </div>
                   <form action="" method="post" id="idm">
                        <table class="table js-basic-example dataTable table-striped table-bordered table-hover" id="myTable" >
                            <thead>
                                <tr style="background:#21495c">
                                    <th colspan="9">
                                        <strong>Private Area</strong>
                                        <strong class="text-center" style="float:center; color:#fff;">Dashboard</strong>
                                    </th>
                                </tr>
                                <tr style="background:#ceede8;">
                                        <th>s/n</th>
                                        <th><input type="checkbox" id="chk_all" value=""/></th>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Date of Birth</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; ?>
                                <?php 
                                    if ($data['fetch_data'])
                                    foreach ($data['fetch_data'] as $list): ?>
                                    <?php if ($list > 0) $i ++;?>

                                <tr>
                                    <td><?=$i?></td>
                                    <th><input type="checkbox" id="dataX" class="checkboxid" name="checkuser[]" value="<?=$list['user_id']?>" /></th>
                                    <td><?=$list['user_id']?></td>
                                    <td><?=$list['name']?></td>
                                    <td><?=$list['email']?></td>
                                    <td><?=$list['mobile']?></td>
                                    <td><?=$list['dob']?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                Action
                                                <span class="sr-only">Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size:14px">
                                                <a class="dropdown-item" href="<?=ROOT?>el/edit/<?=$list['user_id']?>">
                                                    <span class="fa fa-edit text-primary"></span>
                                                    &nbsp;&nbsp;Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <span class="dropdown-item" onClick="juioDT(<?=$list['user_id']?>);" style="cursor:pointer">
                                                    <span class="fa fa-trash text-danger"></span>
                                                    &nbsp;Delete
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                        </table>
                    </form>
                </div>
                
                    </div>
                </div>
            
            </div>
        </div>
    </section>
    
    <script type="module" src="<?=ASSETS?>js/script.js"></script>
    <script src="<?=ASSETS?>js/dl.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
    
</body>
</html>