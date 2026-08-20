<?php
    include 'layout.php';
	include_once("config.php");

	$row = 0;
	$rowperpage = 25;
	$total_pages_sql = "SELECT COUNT(*) FROM kom k left join user u on u.id=k.input_by where u.id_kantor=".$_SESSION['id_kantor']."";
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
         if( $val/$rowperpage < $total_pages ){
            $row = $val;
        }
    }
	//Last button
	if(isset($_POST['but_last'])){
		$row = $_POST['row'];
		$row = ($total_pages-1)*$rowperpage;
	}
	

	$quer = "SELECT k.MMSI, k.Nama_kapal, k.Call_sign, k.Tipe_kapal, c.input_date, c.Kom_id, c.Channel_awal, c.Channel_akhir, c.Jam_Komunikasi, c.IN_OUT, c.NP_LP, c.ETA, c.ETD, c.Cuaca, c.CrewMaster, c.Cargo, c.Penumpang, c.Kendaraan, c.Tongkang, c.Operator, c.Crew_tongkang, c.Note, c.Kom_id FROM kapal k INNER JOIN kom c ON k.MMSI = c.MMSI LEFT JOIN user u ON u.id = c.input_by";
	if(isset($_GET['search']) || isset($_GET['from_day']) || isset($_GET['to_day'])){
		$from_day = isset($_GET['from_day']) ? $_GET['from_day'] : '';
		$to_day = isset($_GET['to_day']) ? $_GET['to_day'] : '';
		$search = isset($_GET['search']) ? $_GET['search'] : '';
		
		// Filter berdasarkan kantor pengguna
		$whereClause = " WHERE u.id_kantor = " . $_SESSION['id_kantor'];

		// Menambahkan pencarian berdasarkan nama kapal, call sign, atau MMSI
		if(!empty($search)) {
			$whereClause .= " AND (k.Nama_kapal LIKE '%" . $search . "%' 
							OR k.Call_sign LIKE '%" . $search . "%' 
							OR k.MMSI LIKE '%" . $search . "%')";
		}

		// Menambahkan filter berdasarkan rentang tanggal
		if(!empty($from_day) && !empty($to_day)) {
			$whereClause .= " AND c.input_date BETWEEN '$from_day' AND '$to_day'";
		} elseif (!empty($from_day)) {
			$whereClause .= " AND c.input_date >= '$from_day'";
		} elseif (!empty($to_day)) {
			$whereClause .= " AND c.input_date <= '$to_day'";
		}

		// Urutkan data berdasarkan input_date dari terbaru
		$result = mysqli_query($mysqli, $quer . $whereClause . " ORDER BY c.input_date DESC LIMIT $row, $rowperpage");
	} else {
		// Jika tidak ada filter pencarian
		$result = mysqli_query($mysqli, $quer . " WHERE u.id_kantor = " . $_SESSION['id_kantor'] . " ORDER BY c.input_date DESC LIMIT $row, $rowperpage");
	}


	// if(isset($_GET['search'])){
    //     if ($_GET['search'] == '') {
    //         $result = mysqli_query($mysqli, "SELECT k.MMSI, k.Nama_kapal, k.Call_sign, k.Tipe_kapal, c.input_date, c.Kom_id, c.Channel_awal, c.Channel_akhir, c.Jam_Komunikasi, c.IN_OUT, c.NP_LP, c.ETA, c.ETD, c.Cuaca, c.CrewMaster, c.Cargo, c.Penumpang, c.kendaraan, c.Tongkang, c.Operator, c.Crew_tongkang, c.Note from kapal k inner join kom c ON k.MMSI = c.MMSI order by c.input_date;");
    //     }
    //     else {
	// 	    $search = $_GET['search'];
	// 	    $result = mysqli_query($mysqli,"SELECT k.MMSI, k.Nama_kapal, k.Call_sign, k.Tipe_kapal, c.input_date, c.Kom_id, c.Channel_awal, c.Channel_akhir, c.Jam_Komunikasi, c.IN_OUT, c.NP_LP, c.ETA, c.ETD, c.Cuaca, c.CrewMaster, c.Cargo, c.Penumpang, c.kendaraan, c.Tongkang, c.Operator, c.Crew_tongkang, c.Note from kapal k inner join kom c ON k.MMSI = c.MMSI order by c.input_Date WHERE k.MMSI LIKE '%".$search."%' OR k.Nama_kapal LIKE '%".$search."%' OR k.Call_sign LIKE '%".$search."%';");
    //     }
	// }
    // else{
	// 	$result = mysqli_query($mysqli, "SELECT k.MMSI, k.Nama_kapal, k.Call_sign, k.Tipe_kapal, c.input_date, c.Kom_id, c.Channel_awal, c.Channel_akhir, c.Jam_Komunikasi, c.IN_OUT, c.NP_LP, c.ETA, c.ETD, c.Cuaca, c.CrewMaster, c.Cargo, c.Penumpang, c.kendaraan, c.Tongkang, c.Operator, c.Crew_tongkang, c.Note from kapal k inner join kom c ON k.MMSI = c.MMSI order by c.input_date LIMIT ".$row.",".$rowperpage.";");	
	// }

?>

<html>
	<link rel="stylesheet" href="button.css">
	<head>
		<title>DISNAV SMG</title>
	</head>
	<body>
		<div class="container">
			<h4 class="mt-5">QSO</h4>
			<div style="display:flex; align-items:flex-start;">
				<form class="input-group mb-3" action="indexComms.php" method="GET" style="width:500px;">
				<input type="text" name="search" class="form-control" style="height:50%;" placeholder="Vessel Name / Call Sign / MMSI">
				<div style="padding:0px 5px 0px;"></div>
					<div class="mb-3">
						<input type="date" class="form-control" id="from_day" name="from_day">
						<input type="date" class="form-control" id="to_day" name="to_day">
					</div>
					<div class="input-group-append">
						<button style="margin-left:10px;" class="btn btn-outline-secondary" type="submit">Search</button>
					</div>
				</form>
				<div style="padding:0px 10px 0px;"></div>
				<a href="addComm.php" type="button" class="btn btn-outline-primary rounded-3" style="width:130px;">Add Data</a>
			</div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered mt-2">
					<thead>
					<tr>
						<th>No</th>
						<th>Time and Channel</th>
						<th>Keterangan</th>
						<th>In/Out/Info</th>
						<th>Operator</th>
						<?php $role = $_SESSION['role'];
							if($role === "admin"){
							echo "<th class='text-center'>Action</th>";
						}
						?>
					</tr>
				</thead>
			</div>
				
				<tbody>
					<?php
					$role = $_SESSION['role'];
					$number = ($row)+1;
						while($comms = mysqli_fetch_array($result)) {
							echo "<tr>";

							echo "<td>".$number."</td>";
							$number++;

							$timeKom;
							// if($comms['Kom_id'] < 2810) {
							// 	$timeKom=date('H:i',strtotime($comms['Jam_Komunikasi']));
							// }else{
								$timeKom=date('d-m-Y H:i',strtotime($comms['input_date']));
							// }

                            //Time and Channel
							// echo "<td width='15%'>".$timeKom."<br />".$comms['Channel_awal']."<br />".$comms['Channel_akhir']."<br /><br />".$comms['input_date']."</td>";
							echo "<td width='15%'>".$timeKom."<br />".$comms['Channel_awal']."<br />".$comms['Channel_akhir']."</td>";
                            //END

                            //Vessel Info
							if ($comms['Tipe_kapal'] == 'TUG BOAT') {$comms['Tipe_kapal'] = 'TUG';}
                            echo "<td>".$comms['Nama_kapal']." / ".$comms['Call_sign']." / ".$comms['MMSI']. " / ".$comms['Tipe_kapal']."<br />";
                            //END

                            //NP or LP
                            if($comms['IN_OUT'] == 1) {
                                echo "LP = ".$comms['NP_LP']."<br />";
                            }
                            else {
                                echo "NP = ".$comms['NP_LP']."<br />";
                            }
                            //END

                            //ETA or ETD
                            if($comms['IN_OUT'] == 1 || $comms['IN_OUT'] == 2) {
                                echo "ETA = ".date_format(date_create($comms['ETA']),"d-m-Y H:i")."<br />";
                            }
                            else {
                                echo "ETD = ".date_format(date_create($comms['ETD']),"d-m-Y H:i")." || ETA = ".date_format(date_create($comms['ETA']),"d-m-Y H:i")."<br />";
                            }
                            //END

                            //Weather
                            if ($comms['IN_OUT'] == 1) {
                                if ($comms['Cuaca'] != NULL) {
                                    echo "Weather = ".$comms['Cuaca']."<br />";
                                }
                            }
                            //END

                            //CARGO DEPENDING ON VESSEL TYPE
                            if($comms['Tipe_kapal'] == 'CARGO') {
                                if($comms['Cargo'] != NULL) {
                                    echo "Cargo = ".$comms['Cargo']."<br />";
                                }
                            }
                            else if ($comms['Tipe_kapal'] == 'PASSENGER') {
                                if($comms['Penumpang'] != NULL) {
                                    echo "<br />";
                                    echo "Passenger : <br />";
                                    echo "".$comms['Penumpang']. "<br />";
                                }
                                if ($comms['Kendaraan'] != NULL) {
                                    echo "<br />";
                                    echo "Vehicle : <br />";
                                    echo "".$comms['Kendaraan']."<br /> <br />";
                                }
								else {echo "<br />";}
                            }
                            else if ($comms['Tipe_kapal'] == 'CRUISE') {
                                if($comms['Penumpang'] != NULL) {
                                    echo "<br />";
                                    echo "Passenger : <br />";
                                    echo "".$comms['Penumpang']."<br /> <br />";
                                }
                            }
                            else if ($comms['Tipe_kapal'] == 'TANKER') {
                                if($comms['Cargo'] != NULL) {
                                    echo "<br />";
                                    echo "Cargo : <br />";
                                    echo "".$comms['Cargo']."<br />";
                                }
                            }
                            else if ($comms['Tipe_kapal'] == 'TUG' || $comms['Tipe_kapal'] == 'TUG BOAT') {
                                if ($comms['Tongkang'] == 1) {
                                    if ($comms['Crew_tongkang'] != NULL) {
                                        echo "Barge Name = ".$comms['Crew_tongkang']."<br />";
                                    }
                                }
                            }
                            echo "Crew + Master = ".$comms['CrewMaster']."<br />";
                            if ($comms['Note'] != NULL) {echo "<br />"; echo $comms['Note'];}
                            echo "</td>";
                            //END

                            //IN OR OUT
                            if($comms['IN_OUT'] == 1) {echo "<td width='10%'>"."IN"."</td>";} else if ($comms['IN_OUT'] == 2) {echo "<td width='10%'>"."INFO"."</td>";} else {echo "<td width='10%'>"."OUT"."</td>";}
                            //END
                            
                            //OPERATOR
                            echo "<td width='10%'>".$comms['Operator']."</td>";
                            //END

                            //EDIT AND DELETE BUTTON
							if($role === "admin"){
								echo "<td>"
									. "<div style='display:flex; align-items:flex-start;justify-content: center'>"
									. 	"<a href='editComms.php?Kom_id=$comms[Kom_id]' type='button' class='btn btn-outline-warning rounded-3'>Edit</a>"
									. 	"<div style='padding:0px 2px 0px;'></div>"
									. 	"<button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModalComms$comms[Kom_id]'>Delete</button>"
									. "</div>"
									. "</td>";
								
								echo "<div class='modal fade' id='deleteModalComms$comms[Kom_id]' tabindex='-1' aria-labelledby='deleteModalCommsLabel$comms[Kom_id]' aria-hidden='true'>
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<h5 class='modal-title' id='deleteModalCommsLabel$comms[Kom_id]'>Confirmation</h5>
													<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
												</div>
												<div class='modal-body'>
													Are you sure?
												</div>
												<div class='modal-footer'>
													<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>No</button>
													<a href='deleteComms.php?Kom_id=$comms[Kom_id]' class='btn btn-danger'>Yes</a>
												</div>
											</div>
										</div>
									</div>";
							}
                            //END
							echo "</tr>";
						} 
					?> 
				</tbody>
			</table>
			<?php 
				if (!isset($_GET['search'])){
			?>
            <form method="post" action="">
						<div class="text-center">
							Page <?php echo ($row/$rowperpage+1). " of " .$total_pages?>
						</div>
						<div id="div_pagination">
							<input type="hidden" name="row" value="<?php echo $row; ?>">
							<input type="hidden" name="allcount" value="<?php echo $allcount; ?>">

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
					<?php }?>
        </div>
    </body>
</html>