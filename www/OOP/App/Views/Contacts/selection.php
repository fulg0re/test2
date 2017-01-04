<?php

	function turnSide($turn){
		return ($turn == "ASC") ? "DESC" : "ASC";
	};

	function getSortArrows($turn){
		return ($turn == "ASC") ? " ⇓" : " ⇑" ;
	};

	function getHref($sortBy, $activePage, $sortTurn){
		$str = "/contacts/selection?";
		$str .= "sortBy=$sortBy&";
		$str .= "activePage=$activePage&";
		$str .= "sortTurn=" . turnSide($sortTurn);

		return $str;
	};
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ContactManager/Selection</title>

		<?php require_once '../App/Views/Elements/head.php' ?>

	</head>
	<body>
		<div id='body-div'>
			<?php require_once '../App/Views/Elements/header.php' ?>

			<!-- message part -->
			<?php require_once '../App/Views/Elements/message.php' ?>
		
			<form action="/contacts/selection" method="post">
				<?php if (!isset($noContacts)): ?>
					<div id="table-div">

						<a href='#'>
							<div id="accept-button">
								<p>ACCEPT</p>
							</div>
						</a>

						<a href='#'>
							<div id="cancel-button">
								<p>CANCEL</p>
							</div>
						</a>

						<table>
							<tr>
								<th id="checkbox-all">
									<input type="checkbox" name="checkbox" value="All">
									<p>All</p>
								</th>
								<th id="th-id"></th>
								<th id="th-firstname"><a href=<?php echo getHref("firstname",$activePage, $sortTurn); ?>>First
									<?php echo ($sortBy == "firstname") 
											? getSortArrows($sortTurn) 
											: null;
									?>
									</a></th>
								<th id="th-lastname"><a href=<?php echo getHref("lastname",$activePage, $sortTurn); ?>>Last
									<?php echo ($sortBy == "lastname") 
											? getSortArrows($sortTurn) 
											: null;
									?>
									</a></th>
								<th id="th-email">Email</th>
								<th id="th-best-phone">Best Phone</th>
							</tr>
							<?php foreach ($contacts as $v): ?>
								<tr>
									<td><input type="checkbox" name="checkbox<?php $v['id']?>" value="<?php $v['id']?>"></td>
									<td><?php echo $v['id']?></td>
									<td><?php echo $v['firstname']?></td>
									<td><?php echo $v['lastname']?></td>
									<td><?php echo $v['email']?></td>
									<td><?php switch ($v['best_phone']):
											case "home_phone":
												echo $v['home_phone'];
												break;
											case "work_phone":
												echo $v['work_phone'];
												break;
											case "cell_phone":
												echo $v['cell_phone'];
												break;
										endswitch; ?></td>
									<td></td>
								</tr>
							<?php endforeach; ?>
						</table>
					<?php else: ?>
						<h2><?php echo $noContacts ?></h2>
					<?php endif; ?>
					<div id="pagination-block">
						<div id="previous-a">
							<?php 
								$maxPages = ceil($numberOfAllFields/$maxOnPage);
								if ($maxPages > 1): 
							?>
								<a href='/contacts?
									sortBy=<?php echo $sortBy?>&
									activePage=<?php $tempPage = (intval($activePage));
											echo ($tempPage > 1) ? (intval($activePage) - 1) : 1;?>&
									sortTurn=<?php echo $sortTurn?>'>
									
									<div id="previous-img"></div>
									<p>previous</p>
								</a>
							<?php endif; ?>
						</div>
						<div id="pages-block">
							<div>
								<p>page: </p>

								<?php
								$temp = 1;
								while ($temp <= $maxPages): ?>

									<a <?php echo ($temp == $activePage)
												? "style='color:white'"
												: null; ?>
										href='/contacts?
											sortBy=<?php echo $sortBy?>&
											activePage=<?php echo $temp?>&
											sortTurn=<?php echo $sortTurn?>'><?php echo $temp?></a>

									<?php
									$temp++;
								endwhile; ?>
							</div>
						</div>
						<div id="next-a">
							<?php if ($maxPages > 1): ?>
								<a href='/contacts?
									sortBy=<?php echo $sortBy?>&
									activePage=<?php $tempPage = (intval($activePage));
									echo ($tempPage >= $maxPages) ? $maxPages : (intval($activePage) + 1);?>&
									sortTurn=<?php echo $sortTurn?>'>
									
									<p>next</p>
									<div id="next-img"></div>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</form>

			<?php require_once '../App/Views/Elements/footer.php' ?>
		</div>
	</body>
</html>
