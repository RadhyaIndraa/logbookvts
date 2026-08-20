<?php
include 'layout.php';
include_once("config.php");
	$row = 0;
	$rowperpage = 25;
	$total_pages_sql = "SELECT COUNT(*) FROM traffic t left join user u on u.id=t.input_by where u.id_kantor=".$_SESSION['id_kantor']."";
	$results = mysqli_query($mysqli,$total_pages_sql);
	$total_rows = mysqli_fetch_array($results)[0];
	$total_pages = ceil($total_rows / $rowperpage);
	
	//Buttons pagination
	//First button
	if(isset($_POST['but_first'])){
        $row = $_POST['row'];
        $row = 0;
    }
	// Prev button
	if(isset($_POST['but_prev'])){
        $row = $_POST['row'];
        $row -= $rowperpage;
        if( $row < 0 ){
            $row = 0;
        }
    }
    // Next Button
    if(isset($_POST['but_next'])){
		$row = $_POST['row'];
        $val = $row + $rowperpage;

		echo "nextt".$row."<br> val =".$val;
         if( $val/$rowperpage < $total_pages ){
            $row = $val;
        }
    }
	//Last button
	if(isset($_POST['but_last'])){
		$row = $_POST['row'];
		$row = ($total_pages-1)*$rowperpage;
	}

	$quer = "SELECT k.MMSI, k.Nama_kapal, k.Call_sign, k.IMO, k.Length, k.Width, k.Tipe_kapal, t.input_date, t.qso_date, t.Last_port, t.Next_port, t.ETD, t.ETA, t.Draught, t.Traffic_ID, t.input_by 
         FROM kapal k 
         INNER JOIN traffic t ON k.MMSI = t.MMSI 
         LEFT JOIN user u ON u.id = t.input_by";

	if (isset($_GET['search'])) {
		$search = $_GET['search'];
		$from_day = $_GET['from_day'];
		$to_day = $_GET['to_day'];
		
		// Menambahkan kondisi pencarian jika terdapat kata kunci pencarian
		if (!empty($search)) {
			$whereClause .= " AND (k.Nama_kapal LIKE '%" . $search . "%' 
							OR k.Call_sign LIKE '%" . $search . "%' 
							OR k.MMSI LIKE '%" . $search . "%')";
		}

		// Menambahkan kondisi tanggal berdasarkan from_day dan to_day
		if (!empty($from_day) && !empty($to_day)) {
			$whereClause .= " AND (t.qso_date BETWEEN '$from_day' AND '$to_day')";
		} elseif (!empty($from_day)) {
			$whereClause .= " AND t.qso_date >= '$from_day'";
		} elseif (!empty($to_day)) {
			$whereClause .= " AND t.qso_date <= '$to_day'";
		}

		$result = mysqli_query($mysqli, $quer . $whereClause . " ORDER BY t.input_date DESC LIMIT $row, $rowperpage");
	} else {
		$result = mysqli_query($mysqli, $quer . " WHERE u.id_kantor = " . $_SESSION['id_kantor'] . " ORDER BY t.input_date DESC LIMIT $row, $rowperpage");
	}
?>

<html>
	<link rel="stylesheet" href="button.css">
	<head>
		<title>DISNAV SMG</title>
	</head>
	
	<body>
		<div class="container">
			<h4 class="mt-5">Vessel Traffic Logbook</h4>
			<div class="" style="display:flex; align-items:flex-start;">
				<form class="input-group mb-3" action="index.php" method="GET" style="width:40%">
					<input type="text" name="search" class="form-control" style="height:50%;" placeholder="Vessel Name / Call Sign / MMSI">
					<div style="padding:0px 5px 0px;"></div>
					<div class="mb-3">
						<input type="date" class="form-control" id="from_day" name="from_day" placeholder="From Date">
						<input type="date" class="form-control" id="to_day" name="to_day" placeholder="To Date">
					</div>
					<div class="" style="z-index: 0">
						<button style="margin-left:10px;" class="btn btn-outline-secondary" type="submit">Search</button>
					</div>
				</form>

				<!-- <div style="padding:0px 10px 0px;"></div>
				<div style="padding:0px 10px 0px;"></div> -->
				<!-- <a href="add.php" type="button" class="btn btn-outline-primary rounded-3" style="width:130px;">Add Data</a> -->
				<button type="button" class="btn btn-outline-primary rounded-3 ms-5" onclick="addDataBtn()" style="width:130px;">Add Data</button>
				<!-- TOAST FOR ADD DATA BUTTON -->
				<div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
					<div id="liveToast" class="toast z-3 bg-warning" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
						<div class="toast-header">
							<!-- <img src="..." class="rounded me-2" alt="..."> -->
							<strong class="me-auto text-danger">WARNING!!</strong>
							<small></small>
							<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
						</div>
						<div class="toast-body">
							<div>
								Vessel Logbook now will automatically added after you add Communications / QSO data !!
							</div>
							<div class="mt-3 text-danger text-uppercase">
								Are you aware of this input manually ?
							</div>
							<div class="mt-2 pt-2 border-top">
								<a href="add.php" type="button" class="btn btn-danger btn-sm">Add Data</a>
								<a href="addComm.php" type="button" class="btn btn-success btn-sm">Add QSO</a>
								<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">close</button>
							</div>
						</div>
					</div>
				</div>
				<script>
					async function addDataBtn(){
						// document.querySelector('#liveToastBtn').click()
						const toastLiveExample = document.getElementById('liveToast')
						const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
						toastBootstrap.show()
					}
				</script>
				<!-- / TOAST FOR ADD DATA BUTTON -->
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered mt-2">
					<thead class="">
					<tr>
						<th>NO</th>
						<th class="text-nowrap">Report Date</th>
						<th>MMSI</th>
						<th>Vessel Name</th>
						<th>Type</th>
						<th>Call Sign</th>
						<th>IMO</th>
						<th>Last Port</th>
						<th>Next Port</th>
						<th>ETD</th>
						<th>ETA</th>
						<th>Length</th>
						<th>Beam</th>
						<th>Draught</th>
						<!-- <th>id</th> -->
						<?php 
						$role = $_SESSION['role'];
							if($role === "admin"){
							echo "<th class=' text-center'>Action</th>";
						}
						?>
					</tr>
				</thead>
			</div>
				
				<tbody>
					<?php
					$role = $_SESSION['role'];
					$number = ($row)+1;
						while($traffic = mysqli_fetch_array($result)) {
							echo "<tr>";
							echo "<td>".$number."</td>";
							$number++;
							if($traffic['Traffic_ID'] > 4213 ){
								echo "<td>".date('d-m-Y',strtotime($traffic['qso_date']))."</td>";
							}else{
								echo "<td>".date('d-m-Y',strtotime($traffic['input_date']))."</td>";
							}
							echo "<td>".$traffic['MMSI']."</td>";
							echo "<td>".$traffic['Nama_kapal']."</td>";
							echo "<td>".$traffic['Tipe_kapal']."</td>";
							echo "<td>".$traffic['Call_sign']."</td>";
							if($traffic['IMO'] == NULL) {echo "<td>-</td>";} else {echo "<td>".$traffic['IMO']."</td>";}
							echo "<td>".$traffic['Last_port']."</td>";
							echo "<td>".$traffic['Next_port']."</td>";
							if ($traffic['ETD'] == '0000-00-00 00:00:00') {echo "<td>-</td>";}
							else {echo "<td>".date_format(date_create($traffic['ETD']),"d-m-Y H:i")."</td>";}
							echo "<td>".date_format(date_create($traffic['ETA']),"d-m-Y H:i")."</td>";
							echo "<td>".$traffic['Length']."</td>";
							echo "<td>".$traffic['Width']."</td>";
							echo "<td>".$traffic['Draught']."</td>";
							// echo "<td>".$traffic['input_by']."</td>";
							if($role === "admin"){
								echo "<td>"
									. "<div style='display:flex; align-items:flex-start;'>"
									. 	"<a href='edit.php?Traffic_ID=$traffic[Traffic_ID]' type='button' class='btn btn-outline-warning rounded-3'>Edit</a>"
									. 	"<div style='padding:0px 2px 0px;'></div>"
									. 	"<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModalTraffic$traffic[Traffic_ID]'>Delete</button>"
									. "</div>"
									. "</td>";
								
								echo "<div class='modal fade' id='deleteModalTraffic$traffic[Traffic_ID]' tabindex='-1' aria-labelledby='deleteModalTrafficLabel$traffic[Traffic_ID]' aria-hidden='true'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h5 class='modal-title' id='deleteModalTrafficLabel$traffic[Traffic_ID]'>Confirmation</h5>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body'>
													Are you sure?
												</div>
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>No</button>
													<a href='delete.php?Traffic_ID=$traffic[Traffic_ID]' class='btn btn-danger'>Yes</a>
												</div>
											</div>
										</div>
									</div>";
							}
							echo "</tr>";
						} 
					?> 
				</tbody>
			</table>
			<form method="post" action="">
						<div class="text-center">
							Page <?php echo ($row/$rowperpage+1). " of " .$total_pages?>
						</div>
						<div id="div_pagination">
							<input type="hidden" name="row" value="<?php echo $row; ?>">
							<input type="hidden" name="allcount" value="<?php echo $total_rows; ?>">

							<ul class="pagination justify-content-center">
							<li class="page-item">
								<button type="submit" class="page-link" name="but_first" aria-label="First">
									<span aria-hidden="true">&laquo;&laquo;</span>
								</button>
							</li>
							<li class="page-item">
								<button type="submit" class="page-link" name="but_prev" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</button>
							</li>
							<!-- middle button -->
							<!-- <li class="page-item">
								<input type="number">
							</li> -->
							<!-- Render halaman-halaman -->							
							<li class="page-item">
								<button type="submit" class="page-link" name="but_next" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
								</button>
							</li>
							<li class="page-item">
								<button type="submit" class="page-link" name="but_last" aria-label="Last">
									<span aria-hidden="true">&raquo;&raquo;</span>
								</button>
							</li>
						</ul>
						</div>
					</form>
		</div>
	</body>
</html>