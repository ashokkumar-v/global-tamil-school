<?php
include("global-admin/includes/config.php"); 
$table_enquirylist="".DB_PREFIX."_enquiry_list";
if(isset($_REQUEST["submit"]))
{
$from_email ="Noreply@gmail.com";
//$to_mail_admin = "admin@globaltamilschool.co.uk ";
//$bcc_mail = "mskattabommudurai@gmail.com";
$to_mail_admin = "beulahviwb1220@gmail.com";
$bcc_mail = "beulahviwb1220@gmail.com";

		$name=$_REQUEST['name'];
		$email=$_REQUEST['email'];
		$phone=$_REQUEST['phone'];
		$message=$_REQUEST['comment'];
		
		$subject_admin = "Global Tamil School | Enquiry Form Details";
		$mail_body_admin = "<html>
				<head></head>
				<body>
				<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:100%'>
			   <tbody>
				<tr>
					<td style='background-color:#f6f5f1'>
					<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:70%; margin-top:60px; margin-bottom:60px;border:1px solid #dedede;'>
						<tbody>
							<tr>
								<td colspan='3' style='background-color:#d5d5d7; text-align:center; padding:10px 0%'><img alt='logo' src='https://globaltamilschool.co.uk/img/GCA-logo.png' style='height:90px;'/></td>
							</tr>
							<tr>
								<td style='background-color:#ffffff'>
								<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:80%;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif; font-size: 13px;'>
									<tbody>
										<tr>
											<td colspan='3'>
											<p>&nbsp;Hi Admin,</p>
											</td>
										</tr>
										<tr>
											<td>
											<p>Here is your new Enquiry Form Request</p>
											</td>
										</tr>
										<tr>
											<td>
												<table align='center' border='0' cellpadding='0' cellspacing='0' style='width:100%; border-collapse: collapse; border-color: #000;'>
													<tr><td width='150' align='left' style='text-transform:capitalize;'>Name:</td><td height='25' align='left'>  ".$name."</td></tr>
													<tr><td width='150' align='left' style='text-transform:capitalize;'>Email:</td><td height='25' align='left'>  ".$email."</td></tr>
													<tr><td width='150' align='left' style='text-transform:capitalize;'>Mobile No:</td><td height='25' align='left'>  ".$phone."</td></tr>
													<tr><td width='150' align='left' style='text-transform:capitalize;'>Message:</td><td height='25' align='left'>  ".$message."</td></tr>

													<tr height='25'></tr>
											</table>
											</td>
										</tr>
										<tr>
											<td>
											<p>Thanks &amp; Regards ,</p>
											</td>
										</tr>
										<tr>
											<td>
											<p>".$name."</p>
											</td>
										</tr>
									</tbody>
								</table>
								</td>
							</tr>
						</tbody>
					</table>
					</td>
				</tr>
			</tbody>
		</table>
		</body>
		</html>";
	$sql = "INSERT INTO $table_enquirylist( `name`, `phone`, `email`, `message`, `product`, `submitted_date`) VALUES ('".$name."','".$phone."','".$email."','".$message."','".$product."','".$date."')";
	$res = $db_cms->update_query($sql);
	
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: ' .$from_email. "\r\n";
$headers .= "Bccc: $bcc_mail\r\n"; #Your BCC Mail List
mail($to_mail_admin, $subject_admin, $mail_body_admin, $headers)  ?> 
<script>window.location.href='index.php';</script>

<?php 
}
?>