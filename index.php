<?php 
	require __DIR__ .'/vendor/autoload.php';
	//Reading data from spreadsheet.

	$client = new \Google_Client();

	$client->setApplicationName('Google Sheets and PHP');

	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

	$client->setAccessType('offline');

	$client->setAuthConfig(__DIR__ . '/credentials.json');

	$service = new Google_Service_Sheets($client);

	$spreadsheetId = '1TIw2kMMata0TTCU-XjvA_MQWsiclkusndRMFzCScKb0';
	$get_range = 'A1:D';

	//Request to get data from spreadsheet.

	$response = $service->spreadsheets_values->get($spreadsheetId, $get_range);

	$values = $response->getValues();

	/* Days of the week */
	$weekDays = [
		'Sun'=> 'Sunday',
	    'Mon'=>'Monday',
	    'Tue'=>'Tuesday',
	    'Wed'=>'Wednesday',
	    'Thu'=>'Thursday',
	    'Fri'=>'Friday',
	    'Sat'=>'Saturday'
	];
	
	$year = date('Y');

	$ArHours=[
			'12' => '12',
			'13' => '1',
			'14' => '2',
			'15' => '3',
			'16' => '4',
			'17' => '5',
			'18' => '6',
			'19' => '7',
			'20' => '8',
			'21' => '9',
			'22' => '10',
			'23' => '11'];

	foreach ($values as $key => $value) {
		if (count($value) == 1) {
			$data = explode(' ', $value[0]);
			if ($key > 0) {
				echo "</tbody>
				  		</table>";
			}
			echo $htmlTop = "
							<table border='0' align='center' cellpadding='0' cellspacing='0' class='time-zones'>
								<tbody>
								  <tr>
								  	<h2>Amazing Discoveries Satellite Schedule <br>
								  	for ".$weekDays[$data[0]]." - ".$data[1]." ".$data[2].", &nbsp;
								  	".$year."
								  	</h2>
								  </tr>
						          <tr>
						              <td>PST</td>
						              <td width='15%'></td>
						              <td width='45%'>Program</td>
						              <td width='20%'>Speaker</td>
						              <td width='20%'>Series</td>
						          </tr>";
		}else{
			$hour = explode(':', $value[0]);
			$programTime = (isset($ArHours[$hour[0]])) ? $ArHours[$hour[0]].":".$hour[1]." PM" : $value[0]." AM";
			$speakerName = (isset($value[3])) ? $value[3] : '' ;
			echo "	<tr>
			              <td>".$programTime."</td>
			              <td></td>
			              <td> ".$value[1]." </td>
			              <td> ".$speakerName." </td>
			              <td> ".$value[2]." </td>
			           	</tr>";
		}
	}
	echo "</tbody>
				  		</table>";
 ?>