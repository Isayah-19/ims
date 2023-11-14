<?php
 include("config.php");

if(isset($_POST['view']))
{
	if($_POST['view'] != '')
	{
		$UpdateNotifSQL = 'UPDATE notification SET notif_status=0 WHERE notif_status=1';
		$UpdateNotifQuery = mysqli_query($db,$UpdateNotifSQL) or die (mysqli_error($db));
	}


	$NotifOut = '<li>
                    <p class="red">Messages</p>
                </li>';

	$NotifLoadSQL = 'SELECT NOTIF.notif_details,
							NOTIF.notif_status,
							CONCAT(GUIDE.counselorFname," ",GUIDE.counselorMname," ",GUIDE.counselorLname) AS Name
					FROM notification AS NOTIF
					INNER JOIN users AS USER
						ON NOTIF.notif_user = USER.userId
					LEFT JOIN guidance_counselor AS GUIDE
						ON USER.user_referenced = GUIDE.counselorcode
					ORDER BY NOTIF.notif_id DESC 
                    LIMIT 5';
	$NotifLoadQuery = mysqli_query($db,$NotifLoadSQL) or die (mysqli_error($db));

	if(mysqli_num_rows($NotifLoadQuery) > 0)
	{
		while($row = mysqli_fetch_assoc($NotifLoadQuery))
		{
			if($row['notif_status'] == 1)
			{
				$Status = "Unread";
			}
			else
			{
				$Status = "Read";
			}
			$NotifOut .= '	<li>
							<a href="#">
                                    <span class="subject">
                                    <span class="from">'.$row['Name'].'</span>
                                    <span class="time">'.$Status.'</span>
                                    </span>
                                    <span class="message">
                                        '.$row['notif_details'].'
                                    </span>
                        	</a>
                        	</li>';
		}
	}
	else
	{
		$NotifOut .= '<a href="#">
                                <span class="message">
                                    No Notifications Found.
                                </span>
                    </a>';
	}

	$NotifCountSQL = 'SELECT COUNT(notif_id) AS NotifCount FROM notification WHERE notif_status=1';
	$NotifCountQuery = mysqli_query($db,$NotifCountSQL) or die (mysqli_error($db));
	$row = mysqli_fetch_assoc($NotifCountQuery);
	$NotifCount = $row['NotifCount'];

	$DataArray = array(
		'Notification' => $NotifOut,
		'NotificationCount' => $NotifCount
	);

	echo json_encode($DataArray);
}
else
{
	$NotifOut = '<li>
                        <p class="red">Messages</p>
                    </li>
                    <li>
						<a href="#">
                                <span class="message">
                                    No Notifications Found.
                                </span>
                    	</a>
                    </li>';

    $NotifCountSQL = 'SELECT COUNT(notif_id) AS NotifCount FROM notification WHERE notif_status=1';
	$NotifCountQuery = mysqli_query($db,$NotifCountSQL) or die (mysqli_error($db));
	$row = mysqli_fetch_assoc($NotifCountQuery);
	$NotifCount = $row['NotifCount'];

	$DataArray = array(
		'Notification' => $NotifOut,
		'NotificationCount' => $NotifCount
	);

	echo json_encode($DataArray);
}

?>