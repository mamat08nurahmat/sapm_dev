<br /><br />
<table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>ID</td>
                <td>ID Nasabah</td>
                <td>Nama Nasabah</td>
                <td></td>
            </tr>
        </thead>
        <?php foreach($nasabah as $data): ?>
        <tr>
            <td><?php echo $data->ID;?></td>
            <td><?php echo $data->ID_NASABAH;?></td>
            <td><?php echo $data->NAMA_NASABAH;?></td>
            <td><a href="#" class="tambah" id_prospek="<?php echo $data->ID;?>"
                                         nama_nasabah="<?php echo $data->NAMA_NASABAH;?>"><i class="glyphicon glyphicon-plus"></i></a></td>
        </tr>
        <?php endforeach;?>
 </table>
 
 
 
 