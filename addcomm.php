<?php
    include 'layout.php';
    include_once 'config.php';
?>

<html>
    <head>
        <title>TAMBAH DATA KOMUNIKASI KAPAL</title>
    </head>
    
    <body>
        <div class="container">
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title fw-bolder mb-3">Tambah Data Komunikasi Kapal</h5>
                    <form action="addcomm.php" method="POST" name="form1">
                        
                        <!-- FIRST COLLUMN ROW -->
                        <div class="input-group">
                            <div class="mb-3">
                                <label for="Input_Date" class="form-label">Tanggal & Jam Komunikasi</label>
                                <div class="col-md-3">
                                    <input id="Input_Date" name="Input_Date" style="width:230px" 
                                    type="datetime-local" class="form-control" required  maxlength="9" value="">
                                </div>
                                <!-- <div class="col-md-3">
                                    <input id="Input_Date" name="Input_Date" style="width:230px" 
                                    type="datetime-local" class="form-control" required  maxlength="9" value="<?php date_default_timezone_set('Asia/Bangkok');echo date("Y-m-d H:i"); 
                                    ?>">
                                </div> -->
                            </div>

                            <div style="width:5%"></div>

                            <div class="mb-3">
                                <label for="MT" class="form-label">Channel awal akhir</label>
                                <div class="input-group">
                                    <!-- <span class="input-group-text">First and last name</span> -->
                                    <input type="number" name="Ch_awal" class="form-control" style="width: 15px;" value="16">
                                    <input type="number" name="Ch_akhir" class="form-control" style="width: 15px;" value="68">
                                </div>
                            </div>
                        </div>
                        <!-- END OF FIRST COLUMN ROW -->

                        <!-- SCND ROW INPUT (VESSEL) -->
                        
                        <div class="input-group" style="display:flex; align-items:flex-start;">
                            <div class="mb-3">
                            <label for="MMSI" class="form-label">MMSI</label>
                                <div class="col-md-3">
                                    <input id="MMSI" name="MMSI" type="number" style="width:200px;" list="list_MMSI" class="form-control" onkeyup="GetDetail(this.value)" required>
                                    <datalist id="list_MMSI">
                                        <?php $result = mysqli_query($mysqli, "SELECT * FROM kapal");
                                        while($MMSI = mysqli_fetch_array($result)){
                                            echo "<option>".$MMSI['MMSI']."</option>";
                                        }?>
                                    </datalist>
                                </div>
                            </div>
                            
                            <div style="width:5%"></div>
                            
                            <!-- SCRIPT AUTOFILL SHIP INFO -->
                            <script>
                                function GetDetail(str) {
                                    if (str.length != 9) {
                                        document.getElementById("Nama_kapal").value = "";
                                        document.getElementById("Call_sign").value = "";
                                        document.getElementById("Tipe_kapal").value = "";
                                        spawnCargoField('OTHER');
                                        return;
                                    }
                                    else {
                                        var xmlhttp = new XMLHttpRequest();
                                        xmlhttp.onreadystatechange = function () {
                                            if (this.readyState == 4 && this.status == 200) {
                                                var myObj = JSON.parse(this.responseText);
                                                document.getElementById("Nama_kapal").value = myObj[0];
                                                document.getElementById("Call_sign").value = myObj[1];
                                                document.getElementById("Tipe_kapal").value = myObj[2];
                                                if(document.getElementById("Tipe_kapal").value === 'CARGO' || document.getElementById("Tipe_kapal").value === 'TANKER' ) {spawnCargoField('CARGO');}
                                                else if (document.getElementById("Tipe_kapal").value === 'CRUISE'){spawnCargoField('CRUISE');}
                                                else if (document.getElementById("Tipe_kapal").value === 'TUG' || document.getElementById("Tipe_kapal").value === 'TUG BOAT' ) {spawnCargoField('TUG');}
                                                else if (document.getElementById("Tipe_kapal").value === 'PASSENGER') {spawnCargoField('PASSENGER');}
                                                else {spawnCargoField('OTHER');}
                                               
                                            }
                                        };
                                        xmlhttp.open("GET", "controller.php?MMSI=" + str, true);
                                        xmlhttp.send();
                                        
                                        
                                    }
                                }
                            
                                function spawnCargoField(value) {
                                    const cargoField1 = document.getElementById('cargoField1');
                                    const cargoField2 = document.getElementById('cargoField2');
                                    const cargoField3 = document.getElementById('cargoField3');
                                    const cargoField4 = document.getElementById('cargoField4');
                                    const cargoField5 = document.getElementById('cargoField5');
                                    if (value === 'CARGO' || value === 'TANKER') {
                                        console.log("CARGO & TANKER");
                                        cargoField1.style.display = "block";
                                        cargoField2.style.display = "none";
                                        cargoField3.style.display = "none";
                                        cargoField4.style.display = "none";
                                        cargoField5.style.display = "none";
                                    }
                                    else if (value === 'TUG') {
                                        console.log("TUG");
                                        cargoField1.style.display = "none";
                                        cargoField2.style.display = "none";
                                        cargoField3.style.display = "block";
                                        cargoField4.style.display = "none";
                                        cargoField5.style.display = "none";
                                    }
                                    else if (value === 'CRUISE') {
                                        console.log("CRUISE");
                                        cargoField1.style.display = "none";
                                        cargoField2.style.display = "none";
                                        cargoField3.style.display = "none";
                                        cargoField4.style.display = "block";
                                        cargoField5.style.display = "none";
                                    }
                                    else if (value === 'PASSENGER') {
                                        console.log("PASSENGER");
                                        cargoField1.style.display = "none";
                                        cargoField2.style.display = "block";
                                        cargoField3.style.display = "none";
                                        cargoField4.style.display = "none";
                                        cargoField5.style.display = "none";

                                    }
                                    else {
                                        console.log("OTHER");
                                        cargoField1.style.display = "none";
                                        cargoField2.style.display = "none";
                                        cargoField3.style.display = "none";
                                        cargoField4.style.display = "none";
                                        cargoField5.style.display = "block";
                                    }
                                }

                                function askTugCrew(value) {
                                    const tug_crew = document.getElementById('tugCrew');
                                    (value === 'YES') ? tug_crew.style.display = 'block' : tug_crew.style.display = 'none';
                                }
                            </script>
                            <!-- END OF SCRIPT -->

                            <div class="mb-3">
                                <label for="Nama_kapal" class="form-label">Ship Name</label>
                                <input type="text" readonly class="form-control" id="Nama_kapal" style="height:35px" name="Nama_kapal" required>
                            </div>
                                                 
                            <div style="width:5%"></div>

                            <div class="mb-3">
                                <label for="Tipe_kapal" class="form-label">Tipe Kapal</label>
                                <input type="text" readonly class="form-control" id="Tipe_kapal" style="height:35px" name="Tipe_kapal"  required>
                            </div>
                                                 
                            <div style="width:5%"></div>

                            <div class="mb-3">
                                <label for="Call_sign" class="form-label">Call Sign</label>
                                <input type="text" readonly class="form-control"id="Call_sign" style="width:150px ; height: 30px;" name="Call_sign" required>
                            </div>

                            <div style="width:5%"></div>
                        </div>
                        <div class="mb-3">
                            <label for="Draught" class="form-label">Draught</label>
                            <input type="number" step="0.1" class="form-control" id="Draught" name="Draught"  style="width:200px" value=0 required>
                        </div>
                        <div class="input-group" style="display:flex; align-items:flex-start;">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault1" value="1" onclick="in_out_value(1), updateLabel('Ship In'), toggleTextField('Ship In'), toggleTextFieldETD('ETDasks')">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Ship In
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault2" value="0" onclick="in_out_value(0), updateLabel('Ship Out'), toggleTextField('Ship Out'), toggleTextFieldETD('ETDask')">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Ship Out
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault2" id="flexRadioDefault3" value="2" onclick="in_out_value(2), updateLabel('Ship Out'), toggleTextField('Ship Out'), toggleTextFieldETD('ETDasks')">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Info
                                    </label>
                                </div>
                            </div>


                            <div style="padding:0px 20px 0px;"></div>

                            <div class="mb-3">
                                <label for="NP_LP" class="form-label" id="npLpLabel">NP/LP</label>
                                <input type="text" class="form-control" name="NP_LP" style="width:320px; height: 30px;" nullable required>
                            </div>

                            <div style="padding:0px 20px 0px;"></div>
                            
                            <div id="additionalField" style="display: none;">
                                <div class="mb-3">
                                    <label for="Weather" class="form-label">Weather</label>
                                    <input type="text" class="form-control" name="Weather" style="width:320px; height: 30px;" nullable>
                                </div>
                            </div>                            
                        </div>
                        
                        <script>
                           function toggleTextField(selectedValue) {
                            const additionalField = document.getElementById('additionalField');
                            if (selectedValue === 'Ship In') {
                                additionalField.style.display = 'block';
                            } else {
                                additionalField.style.display = 'none';
                            }
                        }
                        function toggleTextFieldETD(selectedValue) {
                            const additionalFieldETD = document.getElementById('additionalFieldETD');
                            if (selectedValue === 'ETDask') {
                                additionalFieldETD.style.display = 'block';
                            } else {
                                additionalFieldETD.style.display = 'none';
                            }
                        }
                        function updateLabel(selectedValue) {
                            const npLpLabel = document.getElementById('npLpLabel');
                            
                            if (selectedValue === 'Ship In') {
                                npLpLabel.textContent = 'LP';
                            } else if (selectedValue === 'Ship Out') {
                                npLpLabel.textContent = 'NP';
                            }
                        }
                        </script>


                        <div class="input-group">
                            <div id="additionalFieldETD" style="display: none;">
                                <div class="mb-3" style="margin-right:20px;">
                                    <label  for="ETD" class="form-label">ETD</label>
                                    <input type="datetime-local" class="form-control" name="ETD" nullable>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ETA" class="form-label">ETA</label>
                                <input type="datetime-local" style="width:100%" class="form-control" name="ETA" nullable>
                            </div>
                        </div>
                            
                        <div class="input-group">
                            <div class="mb-3">
                                <label for="Crew" class="form-label">Crew + Master</label>
                                <input type="number" class="form-control" name="Crew" style="width:100px" nullable>
                            </div>
                            <div style="width:30px;"></div>
                            <div class="input-group">
                                <div class="mb-3">
                                    <label for="operator" class="form-label">Operator</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="operator" style="width:180px;" nullable>
                                        <input type="text" class="form-control" name="operator2" style="width:180px;" nullable>
                                        <input type="text" class="form-control" name="operator3" style="width:180px;" nullable>
                                        <input type="text" class="form-control" name="operator4" style="width:180px;" nullable>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- <div class="mb-3">
                            <label for="Input_Date" class="form-label">Input Date</label>
                            <input type="datetime-local" class="form-control" name="Input_Date" style="width:200px" nullable>
                        </div> -->

                        <div class="input-group" id="cargoField1" style="display:none; padding-top:10px;">
                            <div class="mb-3" style="display:flex; align-items:flex-start;">
                                <label for="cargo" class="form-label">Cargo :</label>
                                <div style="width:10px;"></div>
                                <input type="text" class="form-control" name="cargo" style="width:180px" nullable>
                            </div>
                        </div>

                        <div class="input-group" id="cargoField2" style="display:none">
                            <div class="mb-3">
                                <label for="passenger" class="form-label">Passenger</label>
                                <textarea class="form-control" name="passenger" nullable></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="vehicle" class="form-label">Vehicles</label>
                                <textarea class="form-control" name="vehicle" nullable></textarea>
                            </div>
                        </div>

                        <div class="input-group" id="cargoField3" style="display:none">
                            <div style="display:flex; align-items:flex-start">
                                <div class="mb-3">
                                    <label class="form-label">Does it carry a barge?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault3" id="yesTug" value="1" onclick="askTugCrew('YES'), tug_stat_val(1)">
                                        <label class="form-check-label" for="yesTug">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault3" id="noTug" value="0" onclick="askTugCrew('NO'), tug_stat_val(0)">
                                        <label class="form-check-label" for="noTug">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <div style="width: 20px;"></div>
                                <div class="mb-3" id="tugCrew" style="display:none;">
                                    <label for="tug_crew" class="form-label">Barge Name</label>
                                    <input type="text" class="form-control" name="tug_crew" nullable>
                                </div>
                            </div>
                        </div>

                        <div class="input-group" id="cargoField4" style="display:none">
                            <div class="mb-3">
                                <label for="passengerCr" class="form-label">Passenger</label>
                                <textarea class="form-control" name="passengerCr" nullable></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Additional Note</label>
                            <textarea class="form-control" name="note" nullable></textarea>
                        </div>

                        <script>
                            function in_out_value(value) {
                                const in_out_input = document.getElementById('in_or_out');
                                if (value === 1) {in_out_input.value = 1;}
                                else if (value === 2) {in_out_input.value = 2;}
                                else {in_out_input.value = 0;}
                            }

                            function tug_stat_val(value) {
                                const tug_in = document.getElementById('tugStatus');
                                if (value === 1) {tug_in.value = 1;}
                                else {tug_in.value = 0;}
                            }
                        </script>    

                        <div class="text-center">
                            <button type="submit" name="Submit" class="btn btn-primary">SUBMIT</button>
                            <input type="hidden" id="in_or_out" name="in_or_out" class="form-control" value="69">
                            <input type="hidden" id="tugStatus" name="tugStatus" class="form-control" value="69">
                        </div>
                        <!--TEST -->
                         
                        <!--TEST -->
                    </div>
                    <!-- TOAST FOR ADD DATA BUTTON -->
                    <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
                        <div id="liveToast" class="toast z-3 bg-warning text-white w-100" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                            <div class="toast-header">
                                <!-- <img src="..." class="rounded me-2" alt="..."> -->
                                <strong class="me-auto text-success"><i class="fa-solid fa-circle-info me-1"></i>INFO</strong>
                                <small></small>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body fs-5">
                                <div class="text-uppercase">
                                    <i class="fa-solid fa-database me-2"></i>input vessel data to <a href="indexComms.php">qso</a>: <span class="result"></span>
                                </div>
                                <div class="mt-3 text-uppercase">
                                    <i class="fa-solid fa-database me-2"></i>input vessel data to <a href="index.php">logbook</a>: <span class="result2"></span>
                                </div>
                                <div class="mt-2 pt-2 border-top">
                                    <a id="sendWa" type="button" href="" class="btn btn-success"><span class="d-flex"><i class="fa-brands fa-whatsapp fs-4 me-1"></i> SEND TO WHATSAPP</span></a>
                                    <!-- <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">No</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        async function toastSuccess(result,result2){
                            console.log({result,result2});
                            if(result == '1') {document.querySelector('span.result').innerHTML = 'success'}
                            if(result != '1') {
                                document.querySelector('span.result').innerHTML = 'failed'
                                document.querySelector('span.result').classList.add('text-danger','fw-bold')
                            }
                            if(result2 == '1') {document.querySelector('span.result2').innerHTML = 'success'}
                            if(result2 != '1') {
                                document.querySelector('span.result2').innerHTML = 'failed'
                                document.querySelector('span.result2').classList.add('text-danger','fw-bold')
                            }
                            // document.querySelector('#liveToastBtn').click()
                            const toastLiveExample = document.getElementById('liveToast')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                            toastBootstrap.show()
                        }
                        // toastSuccess('1','1')

                        async function textToWa(msg){
                            const encodedMessage = encodeURIComponent(msg);
                            console.log("🚀 ~ file: addcomm.php:406 ~ textToWa ~ encodedMessage:", encodedMessage)
                            let btn = document.querySelector("#sendWa");
                            btn.href=`https://wa.me/?text=${encodedMessage}`;
                        }
                    </script>
                    <!-- / TOAST FOR ADD DATA BUTTON -->
                    <?php
                    if(isset($_POST['Submit'])) {
                        // $jam_comm = $_POST['Jam_komunikasi'];
                        $ch_1 = $_POST['Ch_awal'];
                        $ch_2 = $_POST['Ch_akhir'];
                        if ($_POST['in_or_out'] != 0 && $_POST['in_or_out'] != 1 && $_POST['in_or_out']) {$_POST['in_or_out'] = 2;}
                        $in_out_stat = $_POST['in_or_out'];
                        $NP_LP = $_POST['NP_LP'];
                        $weather = $_POST['Weather'];
                        $ETA = $_POST['ETA'];
                        $ETD = $_POST['ETD'];
                        $CM = $_POST['Crew'];
                        $CM = $CM? $CM : 0;
                        if($_POST['Tipe_kapal'] == 'CRUISE') {$passenger = $_POST['passengerCr'];}
                        else if ($_POST['Tipe_kapal'] == 'PASSENGER') {$passenger = $_POST['passenger'];}
                        else{$passenger=$_POST['passenger'];}
                        $vehicle = $_POST['vehicle'];
                        $cargo = $_POST['cargo'];
                        $Draught = $_POST['Draught'];
                        if ($_POST['tugStatus'] != 0 && $_POST['tugStatus'] != 1) {$_POST['tugStatus'] = 0;}
                        $tug_stat = $_POST['tugStatus'];
                        $tug_crew =  $_POST['tug_crew'];
                        $note = htmlspecialchars($_POST['note']);
                        $operator = $_POST['operator'];
                        $operator .= "<br>".$_POST['operator2'];
                        $operator .= "<br>".$_POST['operator3'];
                        $operator .= "<br>".$_POST['operator4'];
                        
                        $check_query = mysqli_query($mysqli, "SELECT MMSI FROM kapal WHERE MMSI = ".$_POST['MMSI']);
                            if (mysqli_num_rows($check_query) == 0) {
                                echo "<br><div class='text-center'>INPUT FAILED </div><div class = 'text-center'>MAKE SURE THE MMSI ALREADY REGISTERED IN <a href = indexkapal.php>VESSEL DATA</a></div>";
                            }
                            else{
                                    $tglInput = $_POST['Input_Date'];
                                    if($tglInput==''){
                                        $tglInput = current_timestamp();
                                    };
                                // if(strtotime($_POST['Input_Date']) == '') {
                                    (strlen((string)$_POST['MMSI']) != 9) ? $MMSI = NULL : $MMSI = $_POST['MMSI'];
                                    $result = mysqli_query($mysqli, "INSERT INTO kom (`Channel_Awal`, `Channel_akhir`, `MMSI`, `IN_OUT`, `NP_LP`, `ETA`, `ETD`, `Cuaca`, `CrewMaster`, `Cargo`, `Penumpang`, `Kendaraan`, `Tongkang`, `Crew_tongkang`, `Operator`, `Note`, `input_date`,`input_by`) VALUES ($ch_1, $ch_2, $MMSI, $in_out_stat, '$NP_LP', '$ETA', '$ETD', '$weather', $CM, '$cargo', '$passenger', '$vehicle', $tug_stat, '$tug_crew', '$operator', '$note', '$tglInput',".$_SESSION['id'].")");

                                    // INSERT TO TRAFFIC LOGBOOK TABLE
                                    // $in_out_stat , 0=out, 1= in, 2=info
                                    if($in_out_stat==0){
                                        $Next_port = $NP_LP;
                                        $Last_port = 'SEMARANG';
                                    };
                                    if($in_out_stat==1){
                                        $Next_port = 'SEMARANG';
                                        $Last_port = $NP_LP;
                                    };
                                    if($Draught == '') {$Draught=null;};
                                    if($in_out_stat!=2){
                                        $result2 = mysqli_query($mysqli, "INSERT INTO traffic (MMSI, Last_port, Next_port, ETD, ETA, Draught, qso_date, input_by) VALUES($MMSI,'$Last_port', '$Next_port', '$ETD', '$ETA', $Draught, '$tglInput', ".$_SESSION['id'].")");
                                    };


                                    // if(!$result) {echo "<h6 style='margin-left:20px;'>GAGAL</h6>";}
                                    if(!$result) {
                                        echo "<script type='text/javascript'> toastSuccess('$result' , '$result2'); </script>";
                                    }
                                    // else {echo "<h6 style='margin-left:20px;'>BERHASIL. <a href='indexComms.php'>Back to home</a>", $result2;}
                                    else {
                                        $jamQso = date('H:i',strtotime($tglInput));
                                        $tipe=$_POST['Tipe_kapal'];
                                        $muatan=$_POST['cargo'];
                                        $vehicle= $vehicle? "\nKEND. ".$vehicle."," : '';
                                        if($tipe=='PASSENGER' || $tipe=='CRUISE'){
                                            $tipe='PNP';
                                            $muatan=$_POST['passenger'];
                                        };
                                        $ETD=$ETD? "\nCO: ".date('d/m H:i',strtotime($ETD))."LT," : '';
                                        if($tipe=='' || $tipe=='TUG' || $tipe=='OTHER'){$tipe='CARGO';};
                                        if($in_out_stat==0){
                                            $inOut='NP';
                                            $co="\nCO: ".$ETD.",";
                                        };
                                        if($in_out_stat==1){$inOut='LP';};
                                        if($in_out_stat==2){$inOut='INFO';};
                                        $note= $note? "\nNOTE: ".$note."." : '';
                                        $weather=$weather? "\nCUACA: $weather," : '';
                                        $namaKapal=$_POST['Nama_kapal'];
                                        $callSign=$_POST['Call_sign'];
                                        $tug_crew= $tug_crew? "\nTK: $tug_crew," : '';

                                        $textWa = "".$jamQso."LT,\nQSO.".$_POST['Nama_kapal']."/".$_POST['Call_sign']."/$MMSI,\n$inOut: $NP_LP,\nETA: ".date('d/m H:i',strtotime($ETA))."LT,$ETD\n$tipe: ".$muatan.",$vehicle\nC+M: $CM JIWA,$weather $tug_crew $note";

                                        echo "<script type='text/javascript'> toastSuccess('$result' , '$result2', `".$textWa."`);</script>";
                                        echo "<script type='text/javascript'> textToWa(`".$textWa."`);</script>";
                                        // echo "<script type='text/javascript'> textToWa('$jamQso', '$namaKapal', '$callSign', '$MMSI', '$inOut', '$NP_LP', ".date('d/m H:i',strtotime($ETA)).", '$ETD', '$tipe', '$muatan', '$vehicle', '$CM', '$weather', '$note');</script>";
                                    };

                                    // (strlen((string)$_POST['MMSI']) != 9) ? $MMSI = NULL : $MMSI = $_POST['MMSI'];
                                    // $result = mysqli_query($mysqli, "INSERT INTO kom (`Jam_Komunikasi`, `Channel_Awal`, `Channel_akhir`, `MMSI`, `IN_OUT`, `NP_LP`, `ETA`, `ETD`, `Cuaca`, `CrewMaster`, `Cargo`, `Penumpang`, `Kendaraan`, `Tongkang`, `Crew_tongkang`, `Operator`, `Note`, `input_date`,`input_by`) VALUES ('$jam_comm', $ch_1, $ch_2, $MMSI, $in_out_stat, '$NP_LP', '$ETA', '$ETD', '$weather', $CM, '$cargo', '$passenger', '$vehicle', $tug_stat, '$tug_crew', '$operator', '$note', '$tglInput',".$_SESSION['id'].")");
                                    // if(!$result) {echo "<h6 style='margin-left:20px;'>GAGAL</h6>";}
                                    // else {echo "<h6 style='margin-left:20px;'>BERHASIL. <a href='indexComms.php'>Back to home</a>";}
                                // }
                                // else {
                                //     $in_date = ($_POST['Input_Date']);
                                //     (strlen((string)$_POST['MMSI']) != 9) ? $MMSI = NULL : $MMSI = $_POST['MMSI'];
                                //     $result = mysqli_query($mysqli, "INSERT INTO kom (`Jam_Komunikasi`, `Channel_Awal`, `Channel_akhir`, `MMSI`, `IN_OUT`, `NP_LP`, `ETA`, `ETD`, `Cuaca`, `CrewMaster`, `Cargo`, `Penumpang`, `Kendaraan`, `Tongkang`, `Crew_tongkang`, `Operator`, `Note`, `input_date`) VALUES ('$jam_comm', $ch_1, $ch_2, $MMSI, $in_out_stat, '$NP_LP', '$ETA', '$ETD', '$weather', $CM, '$cargo', '$passenger', '$vehicle', $tug_stat, '$tug_crew', '$operator', '$note', '$in_date')");
                                //     if(!$result) {echo "<h6 style='margin-left:20px;'>GAGAL</h6>";}
                                //     else {echo "<h6 style='margin-left:20px;'>BERHASIL. <a href='indexComms.php'>Back to home</a>";}
                                // }
                            }
                        }
                        // $result = mysqli_query($mysqli, "SELECT k.MMSI, k.Nama_kapal, k.Call_sign, k.Tipe_kapal, c.input_date, c.Kom_id, c.Channel_awal, c.Channel_akhir, c.Jam_Komunikasi, c.IN_OUT, c.NP_LP, c.ETA, c.ETD, c.Cuaca, c.CrewMaster, c.Cargo, c.Penumpang, c.Kendaraan, c.Tongkang, c.Operator, c.Crew_tongkang, c.Note, c.Kom_id from kapal k inner join kom c ON k.MMSI = c.MMSI left join user u on u.id=c.input_by where u.id_kantor=1 order by c.`Kom_id` DESC LIMIT 1");
                        // $comms = mysqli_fetch_array($result);
                        // echo $comms;

                    ?>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>




