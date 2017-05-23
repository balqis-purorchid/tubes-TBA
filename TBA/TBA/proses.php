<!DOCTYPE HTML>
<html>
	<head>
		<title>Tugas Besar TBA</title>
	</head>
	<body>
		<center>
			<h2>Morse Compiler | Teori Bahasa dan Automata</h2>
			<h3>Proses dan Hasil </h3><br/>
			<table>
					<header>
						<tr>
							<td align='center'>Status</td>
							<td align='center'>Pita</td>
							<td align='center'>Arah</td>
						</tr>
					</header>
					<?php

						// fungsi pemeriksa state saat ini
					
						function cariState($i, $state, $input){
							if($i > 1){
								if(($state == 'a') && ($input == '-')){
									$state = 'c';
								}else if(($state == 'a') && ($input == '.')){
									$state = 'b';
								}else if(($state == 'b') && ($input == '-')){
									$state = 'd';
								}else if(($state == 'b') && ($input == '.')){
									$state = 'b';
								}else if(($state == 'c') && ($input == '-')){
									$state = 'c';
								}else if(($state == 'c') && ($input == '.')){
									$state = 'e';
								}else if(($state == 'd') && ($input == '-')){
									$state = 'd';
								}else if(($state == 'd') && ($input == 'B')){
									$state = 'f';
								}else if(($state == 'e') && ($input == '.')){
									$state = 'e';
								}else if(($state == 'e') && ($input == 'B')){
									$state = 'f';
								}else if(($state == 'b') && ($input == 'B')){
									$state = 'f';
								}else if(($state == 'c') && ($input == 'B')){
									$state = 'f';
								}else if($state == 'f'){
									$state = 'g';
								}else if($state == 'g'){
									$state = 'h';
								}else if($state == 'h'){
									$state = 'i';
								}else if($state == 'i'){
									$state = 'j';
								}else if($state == 'j'){
									$state = 'k';
								}else if((($state == 'k') && ($input == 'X'))||(($state == 'k') && ($input == 'Y'))){
									$state = 'm';
								}else if(($state == 'k') && ($input == 'B')){
									$state = 'l';
								}else{
									$state = 'stop';
								}
								return $state;
							}else if($i < 2){
								return 'a';
							}
						}
					?>

					<?php
						$input = $_POST['input'];
						$counter = 0;
						$n = strlen($input);
						
						// pengecekan urutan karakter dalam string inputan

						for($i = 0; $i < $n; $i++){
							if($i<$n-1){
								if($input[$i]=='-'){
									if($input[$i+1]=='.'){
										$counter++;
									}
								}else if($input[$i]=='.'){
									if($input[$i+1]=='-'){
										$counter++;
									}
								}
							}
						}
						
						$depan = 2;
						$belakang = 2;
						$j = 0;

						//menambahkan karakter blank

						for($i=0; $i<$n+$depan+$belakang; $i++) {
							if(($i==0 || $i==1 || $i == $n+2 || $i == $n+3)) {
								$input2[$i] = 'B';
							} else {
								$input2[$i] = $input[$j];
								$j++;
							}
						}

						$i=0;
						$jumlahX = 0;
						$jumlahY = 0;
						$ketemu = 0;
						$status = 0;
						
						$state = 'a';
						$b = $n+3;
						while($ketemu==0) 
						{
							// arah penelusuran ke kanan

							echo "<tr>";
							if($i < $n+4 && $status==0) {
								$state = cariState($i, $state, $input2[$i]);
								if($input2[$i]=='-') 
								{
									$input2[$i]='Y';

								} 
								else if($input2[$i]=='.')
								{
									$input2[$i]='X';
								}
								else if($input2[$i]=='B' && $i<$n)
								{
									$i++;
								}
								else if($input2[$i]=='B' && $i>$n)
								{
									$status=1;
								}else{
									$state = 'stop';
								}
								
								$i = $i+1;
								$z = 0;

								// menampilkan state saat ini

								if($state != 'stop'){
									echo "<td width='50px' align='center' color='red'>";
									echo $state;
									echo "</td>";

									echo "<td width='200px' align='center'>";
									foreach ($input2 as $key ) {
										$z = $z +1;
										if($z > 2 && $z < $n+3){
											echo $key."";
										}
									};
									echo "</td>";

									if($input2[2] == "." || $input2[2] == "-" || $input2[2] == "Y" || $input2[2] == "X"){
										echo "<td width='50px' align='center'>";
										echo "R";
										echo "</td>";
									}
								}	
							} 

							//arah penelusuran ke kiri
							else {
								$z = 0;
								$print = 0;
								if($input2[$i]=='Y') {
									$state = cariState($i, $state, $input2[$i]);
									$print = 1;
									$jumlahY++;
								} else if($input2[$i]=='X') {
									$state = cariState($i, $state, $input2[$i]);
									$print = 1;
									$jumlahX++;
								} else if($input2[$i]=='B' && $i==1) {
									$state = cariState($i+1, $state, $input2[$i]);
									$print = 1;
									$ketemu=1;
								}
								
								//menampilkan state saat ini

								if($state != 'stop' && $print == 1){
									echo "<td width='50px' align='center'>";
									echo $state;
									echo "</td>";
									
									echo "<td width='200px' align='center'>";
									foreach ($input2 as $oke) {
										$z = $z +1;
										if($z > 2 && $z < $n+3){
											echo $oke."";
										}
									};
									echo "</td>";
									if($state != 'l'){

										if($input2[2] == "." || $input2[2] == "-" || $input2[2] == "Y" || $input2[2] == "X"){
											echo "<td width='50px' align='center'>";
											echo "L";
											echo "</td>";
										}
									}
									
								}
							
								$b = $b - 1;
								$i= $i-1;
							}
						} 

						//perhitungan -- penerjemahan ke bentuk angka

						if($jumlahX+$jumlahY==5 && $counter<=1) {
							echo $_POST['input']; 
							if($jumlahX==1 && $jumlahY==4) {
								if($input2[2]=='X') {
									echo " adalah 1";
								} else if($input2[2]=='Y') {
									echo " adalah 9";
								}
							} else if($jumlahX==2 && $jumlahY==3) {
								if($input2[2]=='X') {
									echo " adalah 2";
								} else if($input2[2]=='Y') {
									echo " adalah 8";
								}
							} else if($jumlahX==3 && $jumlahY==2) {
								if($input2[2]=='X') {
									echo " adalah 3";
								} else if($input2[2]=='Y') {
									echo " adalah 7";
								}
							} else if($jumlahX==4 && $jumlahY==1) {
								if($input2[2]=='X') {
									echo " adalah 4";
								} else if($input2[2]=='Y') {
									echo " adalah 6";
								}
							} else if($jumlahX==5) {
								if($input2[2]=='X') {
									echo " adalah 5";
								} 
							} else if ($jumlahY == 5){
								echo " adalah 0";
							}
							echo '<br/>';
						} else {
							echo "Masukan tidak diterima.";
						}
						echo '<br/>';
						echo '<br/>';
						
						?>
				</tr>	
				<tr>
					<td  colspan="3" align='center'>
						<?php
							// Keterangan proses
							
							if($state=='stop'){
								echo '<br/>'."Proses berhenti".'<br/>';
							}else if($counter > 1){
								echo '<br/>'."Masukan lebih dari seharusnya".'<br/>';
							}else if($state == 'l'){
								echo '<br/>'."Proses sukses".'<br/><br/>';
							}else{
								echo '<br/>'."Proses selesai namun tidak sukses".'<br/>';
							}
						?>
					</td>
				</tr>
			</table>
			<br/>
			<br/>
			<br/>
			<h7>&copy; Kelompok4-C1</h7>
		</center>
	</body>
</html>
</!DOCTYPE>