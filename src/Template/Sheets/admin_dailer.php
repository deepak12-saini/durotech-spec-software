
<div class="page-content">

	<script type="text/javascript"src="https://media.twiliocdn.com/sdk/js/client/releases/1.3.21/twilio.min.js"></script>
	<script type="text/javascript">
	
		var caller_id = '';
		var client_id = 0;
		Twilio.Device.setup("<?php echo $token; ?>");
		Twilio.Device.ready(function (device) {
			$("#log").text("Ready");
			setTimeout(function(){
				nextusers();
			},100);
		});
		Twilio.Device.error(function (error) {
			$("#log").text("Error: " + error.message);
		});
		Twilio.Device.connect(function (conn) {
			$("#log").text("Successfully established call");
		});
		Twilio.Device.disconnect(function (conn) {
			$("#log").text("Call ended");
			callended();
		});
		function call() {
		
			var params = {"PhoneNumber": $("#number").val(),"task_id": <?php echo $task_id; ?>,"caller_id": '<?php echo $callerId; ?>',"user_id": '<?php echo $this->Session->read('Customer.id');?>'};
		
			Twilio.Device.connect(params);
		}
		function hangup(){
			Twilio.Device.disconnectAll();
			$("#log").text("Ready");
		}
		function nextusers(){
			//call();
		}
		
		function callstablished(){
			var dial_number_id = $("#dial_number_id").val();
			if(dial_number_id  > 0){
				$.ajax({
					url: "<?php echo SITEURL ?>dialers/callstablished",
					type: "POST",
					dataType: "html",
					data: {dial_number_id:dial_number_id},
					success: function(response) {
					}
				});
			}
		}
		function callended(){
			
			var delay = $("#delay").val();
			if(delay > 10){
				delay = delay * 1000;
			}else{
				delay = 10000;
			}
			setTimeout(function(){
				$("#dial_number_id").val('');
				$("#number").val('');
				$("#message").val('');
				setInterval(function(){
					nextusers();
				},3000);
			},delay);
		}
    </script>
	<style>
		#log {
		  width: 100%;
		  max-width: 466px;
		  background: #404040;
		  padding: 10px;
		  margin-top: 0.75em;
		  margin-bottom: 0.75em;
		  text-align: center;
		  border: 1px solid #d4d4d4;
		  text-decoration: none;
		  font:18px/normal sans-serif;
		  color: white;
		  white-space: nowrap;
		  outline: none;
		  background-color: #404040;
		  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#000), to(#404040));
		  background-image: -moz-linear-gradient(#000, #404040);
		  background-image: -o-linear-gradient(#000, #404040);
		  background-image: linear-gradient(#000, #404040);
		  -webkit-background-clip: padding;
		  -moz-background-clip: padding;
		  -o-background-clip: padding-box;
		  /*background-clip: padding-box;*/ /* commented out due to Opera 11.10 bug */
		  -webkit-border-radius: 5px;
		  -moz-border-radius: 5px;
		  line-height: 25px;
		  border-radius: 5px;
		  /* IE hacks */
		  zoom: 1;
		  *display: inline;
		}

		#people {
			position:fixed;
			bottom:0px;
			right: 0px;
			height:100%;
			width:200px;
			margin: 0;
			padding: 0;
			list-style: none;
			font-family:'Helvetica','Arial';
			text-align: left;
			background-color:#ee0000 !important;
			border:none !important;
			overflow: auto;
			overflow-x: hidden;

		}

		#people li {
			position:relative;
			width: 100%;
			display:block;
			color:#eee !important;
			background-color:#ff0000!important;
			border:solid 1px #ee0000 !important;
			padding: 0.5em 0 0.5em 1em;
			background: #f7f2ea;
			cursor: pointer;
		}

		#people li:HOVER {
			color: #fff;
			background-color:#dd0000!important;
		}

		#people li:ACTIVE {
			color: #fff;
			background-color:#C00 !important;
		}



		/* ------------------------------------------------------------------------------------------------------------- BUTTON */

		button.call, button.hangup, input {
			-moz-box-shadow: 1px 2px 10px #BBB;
			-webkit-box-shadow: 1px 2px 10px #BBB;
			box-shadow: 1px 2px 10px #BBB;
		}

		button.call, button.hangup {
			position: relative;
			overflow: visible;
			display: inline-block;
			padding: 0.5em 1em;
			border: 1px solid #d4d4d4;
			margin: 25px auto 0 auto;
			text-decoration: none;
			text-shadow: 1px 1px 0 #fff;
			font:35px/normal sans-serif;
			font-weight: bold;
			color: #333;
			white-space: nowrap;
			cursor: pointer;
			outline: none;
			background-color: #ececec;
			background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f4f4f4), to(#ececec));
			background-image: -moz-linear-gradient(#f4f4f4, #ececec);
			background-image: -o-linear-gradient(#f4f4f4, #ececec);
			background-image: linear-gradient(#f4f4f4, #ececec);
			-webkit-background-clip: padding;
			-moz-background-clip: padding;
			-o-background-clip: padding-box;
			/*background-clip: padding-box;*/ /* commented out due to Opera 11.10 bug */
			-webkit-border-radius: 10px;
			-moz-border-radius: 10px;
			border-radius: 10px;
			/* IE hacks */
			zoom: 1;
			*display: inline;
		}

		button.call:hover,
		button.call:focus,
		button.call:active,
		button.call.active,
		button.hangup:hover,
		button.hangup:focus,
		button.hangup:active,
		button.hangup.active {
			border-color: #3072b3;
			border-bottom-color: #2a65a0;
			text-decoration: none;
			text-shadow: -1px -1px 0 rgba(0,0,0,0.3);
			color: #fff;
			background-color: #3C8DDE;
			background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ff0000), to(#dd0000));
			background-image: -moz-linear-gradient(#599bdc, #3072b3);
			background-image: -o-linear-gradient(#599bdc, #3072b3);
			background-image: linear-gradient(#599bdc, #3072b3);
		}

		button.call:active,
		button.call.active,
		button.hangup:active,
		button.hangup.active {
			border-color: #2a65a0;
			border-bottom-color: #3884CF;
			background-color: #3072b3;
			background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#3072b3), to(#599bdc));
			background-image: -moz-linear-gradient(#3072b3, #599bdc);
			background-image: -o-linear-gradient(#3072b3, #599bdc);
			background-image: linear-gradient(#3072b3, #599bdc);
		}

		/* overrides extra padding on button elements in Firefox */
		button.call::-moz-focus-inner,
		button.hangup::-moz-focus-inner {
			padding: 0;
			border: 0;
		}

		input {
		  display: block;
		  outline: none;
		  border: 1px solid #999;
		  line-height: 1.4em;
		  font-size: 24px;
		  padding: 10px;
		  width: 100%;
		  max-width: 466px;
		  text-align: center;
		  margin-top: 0.75em;
		}
		.sendernumber {
		  display: block;
		  outline: none;
		  border: 1px solid #999;
		  line-height: 1.4em;
		  font-size: 24px;
		  padding: 10px;
		  width: 100%;
		  max-width: 466px;
		  text-align: center;
		  margin-top: 0.75em;
		}

		/* ............................................................................................................. Icons */

		button.call:before,
		button.hangup:before {
			content: "";
			position: relative;
			top: 1px;
			float:left;
			width: 44px;
			height: 37px;
			margin: 0 0.75em 0 -0.25em;
			background: url(<?php echo SITEURL;?>img/buttons.png) 0 99px no-repeat;
		}

		button.call:before { background-position: 0 -48px; }
		button.call:hover:before,
		button.call:focus:before,
		button.call:active:before { background-position: 0 0; }

		button.call {
		   margin-right: 25px;
		}

		button.hangup:before { background-position: 0 -131px; }
		button.hangup:hover:before,
		button.hangup:focus:before,
		button.hangup:active:before { background-position: 0 -88px; }
    </style>
	<!-- <div class="row">
		<div class="panel">					
			<?php 		
				if(!empty($phone)){			
				$phoneNumber = str_replace("+","",$phone);
				$phoneNumber = str_replace(' ','',$phoneNumber);
				$phoneNumber = str_replace('(','',$phoneNumber);
				$phoneNumber = str_replace(')','',$phoneNumber);
				$phoneNumber = str_replace('-','',$phoneNumber);
				$ccode = substr($phoneNumber, 0, 2);
				if($ccode == 61 || $ccode == 91){
					
				}else{
					$phoneNumber = '61'.$phoneNumber;
				}			
			?>
				<div class="panel-body" style="padding: 1px 38px;">
					<button class="call" onclick="call();" style="padding: 10px 29px !important;">
					  Call
					</button>
					<button class="hangup" onclick="hangup();" style="padding: 10px 12px !important;">
					  Hangup
					</button>	
					<input type="text" id="number" value="<?php echo $phoneNumber; ?>" name="number" placeholder="Enter a phone number to call" readonly/>
					<input type="hidden" id="delay" name="delay" placeholder="Delay in seconds" value="30"/>
					<div id="log">Loading pigeons...</div>
				</div>
			<?php } ?>
		</div>
	</div> -->
	
		<table class="table table-striped table-bordered table-hover" id="simple-table" >
			<tbody>
				<tr>
					<th>S No.</th>
					<th>Called By</th>
					<th>Call To</th>
					<th>Duration</th>
					<th>Voice Url</th>
					<th>Status</th>
					<th>Date</th>
				<tr>
				<?php 
				$i=1;
				if(!empty($LogArr)){ foreach($LogArr as $LogArrs){ ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $LogArrs['NappUser']['name'].' '.$LogArrs['NappUser']['lname']; ?></td>
						<td><?php echo $LogArrs['Log']['phone_number']; ?></td>
						<td><?php echo $LogArrs['Log']['call_duration']; ?> Sec</td>
						<td><?php if(!empty($LogArrs['Log']['voice_url'])){ ?><a href="<?php echo $LogArrs['Log']['voice_url']; ?>" target="_blank" >Recording</a> <?php }else{ echo 'N/A'; }?></td>
						<td><?php echo $LogArrs['Log']['status']; ?></td>
						<td><?php echo $LogArrs['Log']['created']; ?></td>
						
					<tr>
				<?php $i++; } } ?>
			</tbody>			
		</table>	
</div>
