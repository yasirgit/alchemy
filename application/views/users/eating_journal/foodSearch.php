<div>
	<table>
		<?php
		if (@is_array($foods['food']))
		{
			?>
			<tr>
				<td>
					<?php
					$this->paginator->setPaginator(array(	'records' =>	$foods['total_results'],
															'pages' =>		5,
															'start' =>		$foods["max_results"] * $foods["page_number"],
															'controller' =>	'journal',
															'method' =>		'listAll'));
					$this->load->view("paginator",array("paginator" => $this->paginator->getPaginator()));
					?>
				</td>
			</tr>
			<tr>
				<td>
					<?php
					foreach($foods['food'] AS $food)
					{					
						$this->load->view("users/eating_journal/foodSearchResults",$food);
					}
					?>
				</td>
			</tr>
			<?php
		}
		else
		{
			?><tr><td>No Results found</td></tr><?php
		}
		?>
	</table>
</div>
