<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DISNAV TG EMAS</title>
        <link rel = "icon" href = "./img/kemenhub.png" type = "image/x-icon">
		<script src="https://kit.fontawesome.com/3f6e445922.js" crossorigin="anonymous"></script>
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        
        <style>body {font-family: 'Nunito'; font-size: 14px;}</style>
    </head>

		<style>
			.btn-outline-primary {
				/* --bs-btn-bg: ; */
				--bs-btn-border-color: rgba(24,117,210,255);
				/* --bs-btn-hover-color: rgba(24,117,210,255); */
				/* --bs-btn-hover-border-color: #{shade-color($bd-violet, 10%)}; */
				--bs-btn-hover-bg: rgba(24,117,210,255);
			}
		</style>
    
    <body class="antialiased"   style="background-color : rgba(240, 248, 255, 0.397);">
        <!-- <nav class="navbar" style="background-color : #91C8E4"> -->
        <nav class="navbar navbar-dark" style="background-color : rgba(24,117,210,255)">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <nav class="navbar navbar-dark">
                    <div class="container-fluid" style="display:flex; align-items: center;">
                        <h1 class="navbar-brand fw-semibold font-monoscape fs-4 m-0"style="text-transform: uppercase"><i class="fa-solid fa-ship me-2"></i>VESSEL TRAFFIC SERVICES</h1>
                    </div>
                </nav>
								<div class="text-white" style="display:flex; align-items: center;">
								<i class="fa-solid fa-id-card ms-3 me-2" style="font-size: 21px"></i><span class="text-uppercase fw-medium me-4"> <?php echo $_SESSION['name'] ?></span> 
									<a href="logout.php" type="button" class="text-white"><i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 19px"></i></a>
								</div>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <!-- <div class="offcanvas-header" style="background-color : #749BC2"> -->
                    <div class="offcanvas-header" style="background-color : #bad6f2">
                        <img class="m-0" src="./img/kemenhub.png" alt="" style="width: 50px">
												<h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="margin-left: -70px">Disnav Tanjung Emas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body" style="background-color : rgba(24,117,210,255)">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link <?php if($current_page==="index.php"){echo 'active';} ?>" style="font-size: 16px;" aria-current="page" href="index.php"><i class="fa-solid fa-book"></i> Traffic Logbook</a>
                            </li>

                            <li class="nav-item">
															<a class="nav-link <?php if($current_page==="indexkapal.php"){echo 'active';} ?>" style="font-size: 16px;" aria-current="page" href="indexkapal.php"><i class="fa-solid fa-ship"></i> Vessel Data</a>
														</li>
                            <li class="nav-item">
                                <a class="nav-link <?php if($current_page==="indexComms.php"){echo 'active';} ?>" style="font-size: 16px;" aria-current="page" href="indexComms.php"><i class="fa-solid fa-comment"></i> Communications</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" style="font-size: 16px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Export Logbook
                                </a>
                                <ul class="dropdown-menu">
                                    <li><button onclick="updatePath('export-pdf','logbook')" type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModal">Pdf</button></li>
                                    <li><button onclick="updatePath('export-excel','logbook')" type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModal">Excel</button></li>
                                        <!-- <hr class="dropdown-divider" /> -->
                                    <li class="d-none"><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportOneDayModal">One Day Export</button></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" style="font-size: 16px;" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Export QSO
                                </a>
                                <ul class="dropdown-menu">
                                    <li><button type="button" onclick="updatePath('export-pdf','qso')" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModalQSO">Pdf</button></li>
                                    <li><button type="button" onclick="updatePath('export-excel','qso')" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportModalQSO">Excel</button></li>
                                        <!-- <hr class="dropdown-divider" /> -->
                                    <li class="d-none"><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exportOneDayModalQSO">One Day Export</button></li>
                                </ul>
                            </li>
							<!-- <li class="nav-item">
                                <a href="https://kjg.vtssemarang.my.id" class="nav-link" style="font-size: 16px;" aria-current="page" href="indexComms.php"><i class="fa-solid fa-arrow-down-up-across-line fa-rotate-90"></i> KJG Monitoring</a>
                            </li>
							<li class="nav-item">
                                <a href="https://kjg.vtssemarang.my.id/ais-imotion" class="nav-link" style="font-size: 16px;" aria-current="page" href="indexComms.php"><i class="fa-solid fa-triangle-exclamation"></i> AIS IMOTION</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                
            </div>
        </nav>
				<script>
					let id = <?php echo $_SESSION['id_kantor'] ?>;
					console.log("🚀 ~ file: layout.php:83 ~ id:", id);
				</script>
				
        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="hapusModalLabel">Export Logbook</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
					</div>
					<form method="POST" action="">
						<div class="modal-body">Please enter the date range for the data you want to export</div>
							<div class="mb-3" style="padding-left:20px;">
								<label for="first_date" class="form-label">From</label>
									<input type="date"  class="form-control" id="first_date" name="first_date" style="width:320px" required>
							</div>
							<div class="mb-3" style="padding-left:20px;">
								<label for="last_date" class="form-label">To</label>
									<input type="date"  class="form-control" id="last_date" name="last_date" style="width:320px">
							</div>
							<div class="modal-footer">
								<button type="submit" name="submit_date_range" class="btn btn-primary">Submit</button>
							</div>
					</form>
				</div>
			</div>
		</div>
        <div class="modal fade" id="exportOneDayModal" tabindex="-1" aria-labelledby="exportOneDayModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exportOneDayModalLabel">Export Logbook One Day</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
					</div>
					<form method="POST" action="exportOneDay.php">
						<div class="modal-body">Please enter the date for the data you want to export</div>
							<div class="mb-3" style="padding-left:20px;">
								<label for="only_date" class="form-label">Date</label>
                            	<input type="date"  class="form-control" id="only_date" name="only_date" style="width:320px" required>
							</div>
							<div class="modal-footer">
								<button type="submit" name="submit_date_only" class="btn btn-primary">Submit</button>
							</div>
					</form>
				</div>
			</div>
		</div>
    <div class="modal fade" id="exportModalQSO" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="hapusModalLabel">Export QSO</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
					</div>
					<form method="POST" action="https://pdf.pemapi.my.id/export?path=qso&idKantor=<?php echo $_SESSION['id_kantor'] ?>">
						<div class="modal-body">Please enter the QSO date range for the data you want to export</div>
							<div class="mb-3" style="padding-left:20px;">
								<label for="first_date" class="form-label">From</label>
                            	<input type="date"  class="form-control" id="first_date" name="first_date" style="width:320px" required>
							</div>
							<div class="mb-3" style="padding-left:20px;">
								<label for="last_date" class="form-label">To</label>
                            	<input type="date"  class="form-control" id="last_date" name="last_date" style="width:320px" required>
							</div>
							<div class="modal-footer">
								<button type="submit" name="submit_date_range" class="btn btn-primary">Submit</button>
							</div>
					</form>
				</div>
			</div>
		</div>
        <div class="modal fade" id="exportOneDayModalQSO" tabindex="-1" aria-labelledby="exportOneDayModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exportOneDayModalLabel">Export QSO One Day</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
					</div>
					<form method="POST" action="exportCommsOneDay.php">
						<div class="modal-body">Please enter the date for the data you want to export</div>
							<div class="mb-3" style="padding-left:20px;">
								<label for="only_date" class="form-label">Date</label>
                            	<input type="date"  class="form-control" id="only_date" name="only_date" style="width:320px" required>
							</div>
							<div class="modal-footer">
								<button type="submit" name="submit_date_only" class="btn btn-primary">Submit</button>
							</div>
					</form>
				</div>
			</div>
		</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

				<script>
					function updatePath(path, type){
						console.log({path, type});
						if(type=="logbook"){
							let form=document.querySelector("#exportModal form");
							form.action = `https://pdf.pemapi.my.id/${path}?path=logbook&idKantor=<?php echo $_SESSION['id_kantor'] ?>`;
							console.log(form.action);
							return
						}

						let form=document.querySelector("#exportModalQSO form");
						form.action = `https://pdf.pemapi.my.id/${path}?path=qso&idKantor=<?php echo $_SESSION['id_kantor'] ?>`;
						console.log(form.action);
					}
				</script>
    </body>
</html>