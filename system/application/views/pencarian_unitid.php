<br /><br />
<table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>ID Unit</td>
                <td>Nama Unit</td>
                <td></td>
            </tr>
        </thead>
        <?php foreach($unit as $data): ?>
        <tr>
            <td><?php echo $data->BRANCH_CODE; ?></td>
            <td><?php echo $data->BRANCH_NAME; ?></td>
            <td><a href="#" class="tambah" id_unit="<?php echo $data->BRANCH_CODE;?>" ><i class="glyphicon glyphicon-plus"></i></a></td>
        </tr>
        <?php endforeach;?>
 </table>
 
 
 
 			