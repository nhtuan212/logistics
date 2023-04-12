<?php
	class PaginationsAjax
	{
		public $perpage;
		public $sql;
		
		function __construct()
		{
			$this->perpage = 1;
		}
		public function HandlingQuery()
		{
			global $d;
			$page = $p = (isset($_GET['p'])) ? htmlspecialchars($_GET['p']) : 1;
			$page -= 1;
	        $start = $page * $this->perpage;
	        return $d->rawQuery($this->sql." LIMIT $start, $this->perpage");
		}
		function getAllPageLinks($pageLink)
		{
			global $func, $d;
			$type = $_GET['type'];

			$tempLink = "";
			$tempLink .= "&p=";
			$pageLink .= $tempLink;

			$count = count($d->rawQuery($this->sql));
			$href = $pageLink;
			$elShow = $_GET['eShow'];
			$scroll = 'true';

			$output = '<ul>';

			if(!isset($_GET["p"])) $_GET["p"] = 1;

			if($this->perpage != 0) $pages = ceil($count/$this->perpage);

			if($pages>1)
			{
				if($_GET["p"] == 1) 
					$output = $output . '<li><a class="first disabled">First</a></li><li><a class="prev disabled">Prev</a></li>';
				else	
					$output = $output . '<li><a class="first" onclick="loadPagingAjax(\'' . $href . (1) . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >First</a></li><li><a class="prev" onclick="loadPagingAjax(\'' . $href . ($_GET["p"]-1) . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >Prev</a></li>';
				
				if(($_GET["p"]-3)>0)
				{
					if($_GET["p"] == 1)
						$output = $output . '<li><a id=1 class="current">1</a></li>';
					else				
						$output = $output . '<li><a onclick="loadPagingAjax(\'' . $href . '1\',\''.$elShow.'\',0,\''.$scroll.'\')" >1</a></li>';
				}
				if(($_GET["p"]-3)>1)
				{
					$output = $output . '<li><a class="dot">...</a></li>';
				}
				
				for($i=($_GET["p"]-2); $i<=($_GET["p"]+2); $i++)
				{
					if($i<1) continue;
					if($i>$pages) break;
					if($_GET["p"] == $i)
						$output = $output . '<li><a id='.$i.' class="current">'.$i.'</a></li>';
					else				
						$output = $output . '<li><a onclick="loadPagingAjax(\'' . $href . $i . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >'.$i.'</a></li>';
				}
				if(($pages-($_GET["p"]+2))>1)
				{
					$output = $output . '<li><a class="dot">...</a></li>';
				}
				if(($pages-($_GET["p"]+2))>0)
				{
					if($_GET["p"] == $pages)
						$output = $output . '<li><a id=' . ($pages) .' class="current">' . ($pages) .'</a></li>';
					else				
						$output = $output . '<li><a onclick="loadPagingAjax(\'' . $href .  ($pages) .'\',\''.$elShow.'\',0,\''.$scroll.'\')" >' . ($pages) .'</a></li>';
				}
				
				if($_GET["p"] < $pages)
					$output = $output . '<li><a class="next" onclick="loadPagingAjax(\'' . $href . ($_GET["p"]+1) . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >Next</a></li><li><a class="last" onclick="loadPagingAjax(\'' . $href . ($pages) . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >Last</a></li>';
				else				
					$output = $output . '<li><a class="next disabled">Next</a></li><li><a class="last disabled">Last</a></li>';
			}
			$output .= '</ul>';
			return $output;
		}

		function getPrevNext($count, $href, $elShow)
		{
			$output = '';

			if(!isset($_GET["p"])) $_GET["p"] = 1;

			if($this->perpage != 0)
				$pages  = ceil($count/$this->perpage);

			if($pages>1)
			{
				if($_GET["p"] == 1) 
					$output = $output . '<li><a class="prev disabled">Prev</a></li>';
				else	
					$output = $output . '<li><a class="prev" onclick="loadPagingAjax(\'' . $href . ($_GET["p"]-1) . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >Prev</a></li>';			
			
				if($_GET["p"] < $pages)
					$output = $output . '<li><a class="next" onclick="loadPagingAjax(\'' . $href . ($_GET["p"]+1) . '\',\''.$elShow.'\',0,\''.$scroll.'\')" >Next</a></li>';
				else				
					$output = $output . '<li><a class="next disabled">Next</a></li>';
			}

			return $output;
		}
	}
?>