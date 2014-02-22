<?php
function paging()
{
	global $num_rows;
	global $page;
	global $page_amount;
	global $section;
	if($page_amount != "0")
	{
		echo "<div align='center' class='container'>";
		echo "<div class='pagination'>";
		if($page != "0")
		{
			$prev = $page-1;
			echo "<a href=\"$section.php?p=$prev\" class='page1'>Prev</a> ";
		}
		for ( $counter = 0; $counter <= $page_amount; $counter += 1)
		{
			if($page==$counter)
			{
				echo "<a class='page1 active'>";
				echo $counter+1;
				echo "</a> ";
			}
			else
			{
				echo "<a href=\"$section.php?p=$counter\" class='page1'>";
				echo $counter+1;
				echo "</a> ";
			}
		}
		if($page < $page_amount)
		{
			$next = $page+1;
			echo "<a href=\"$section.php?p=$next\" class='page1'>Next</a> ";
		}
		echo "<a href=\"$section.php?a=all\" class='page1'>All</a> ";
		echo "</div>";
		echo "</div>";
	}
}
?>