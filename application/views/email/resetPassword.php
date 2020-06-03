<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Reset Your Password</title>
	</head>
	<body>
		<div>
			<table style="width:100%;border-spacing:0" cellpadding="0" cellspacing="0">
				<tbody>
					<tbody>
						<tr>
							<td align="center">
								<div style="width:100%">
									<b>Hi, <?php echo $data["name"]; ?></b>! <span class="il"><?php echo $data["message"]; ?></span>
									<div style="min-height:20px"></div>
									<div style="width:100%">
										<a style="display:inline-block;font-size:15px;padding:10px 18px;vertical-align:middle;color:#ffffff;background:#f06100;border-top:solid 0px #f06100;border-right:solid 1px #f06100;border-bottom:solid 1px #2c8ea6;border-left:solid 1px #2c8ea6;border-radius:50px;text-decoration:none;white-space:normal;font-weight:bold;line-height:18px" href="<?php echo $data['reset_link']; ?>" target="_blank"> <span class="il"> RESET PASSWORD LINK </span></a>
									</div>
									<div style="min-height:28px"></div>
									<div align="center">
										OR COPY THIS IN YOUR BROWSER :
										<br>
										<br>
										<?php echo $data['reset_link']; ?>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			<div class="yj6qo"></div>
			<div class="adL"></div>
			</table>
		</div>
	</body>
</html>
