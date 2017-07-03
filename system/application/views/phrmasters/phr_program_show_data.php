<style>
	th.lokal {
		background-color:#49BAA8;
		text-transform:uppercase;
		text-align:center;
		padding:0.5em;
		color: #fff;
	}
</style>
<br /><br />

<div class="table-responsive">
<table class="table table-bordered table-striped ">
        <thead>
            <tr>
				<th class="lokal">No</th>
                <th class="lokal">Nama Program</th>
                <th class="lokal">Periode</th>
                <th class="lokal">Penjelasan Program</th>
            </tr>
        </thead>
        <?php foreach($program as $no=> $data): $no++ ?>

        <tr>
			<td><?php echo $no; ?></td>
            <td><?php echo $data->NAMA_PROGRAM;?></td>
            <td><?php echo "<strong>".$data->TGL_AWAL."</strong> to <strong>"; echo $data->TGL_AKHIR."</strong>";?></td>
            <td><?php echo $data->PENJELASAN_PROGRAM;?></td>

        </tr>
        <?php endforeach; ?>
 </table>
 </div><br />
