<?php
require_once('TagCloud.php');

function remove_stop_Words($input){

	$commonWords = array('this','in','a','ain\'t','an','and','are','aren\'t','as','a\'s','at','be','been','but','by','can','cannot','cant','can\'t','c\'mon','co','co.','com','come','could','couldn\'t','did','didn\'t','do','does','doesn\'t','doing','done','don\'t','else','for','get','gets','go','got','had','hadn\'t','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','her','his','hither','how','however','if','in','inasmuch','inc','inc.','into','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','let','let\'s','like','made','mainly','make','makes','many','may','maybe','mayn\'t','me','more','much','must','mustn\'t','my','myself','needs','neither','neverless','nevertheless','no','non','none','nor','not','now','of','off','often','oh','ok','okay','on','or','our','ours','ourselves','out','over','perhaps','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sent','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
  /*
  foreach ($commonWords as &$word){
    $input = str_ireplace(" ".$word." ", " ", $input);
  }
  return $input;
  */
	return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$input);
}

/**
 * @param string $string
 * @param string|null $allowable_tags
 * @return string
 */
function strip_tags_with_whitespace($string, $allowable_tags = null)
{
    $string = str_replace('<', ' <', $string);
    $string = strip_tags($string, $allowable_tags);
    $string = str_replace('  ', ' ', $string);
    $string = trim($string);

    return $string;
}

function get_tagcloud($journalentries)
{
	$tag_cloud_json = "[]";
	if (count($journalentries)>0){
		$cloud = new TagCloud();
	  foreach ($journalentries as &$entry)
	  {
	    $curr_entry = $str = strtolower($entry['reflectivetext']);
	    $cloud->addString(remove_stop_Words(strip_tags_with_whitespace(html_entity_decode($curr_entry))));
	  }
		$tagcloud_array = $cloud->render('array');
		//print_r($journalentries);
		//print_r($tagcloud_array);

		$tag_cloud_json = "[";
		foreach ($tagcloud_array as $key => $item){
			$curr_tag = $item['tag'];
			$curr_weight = $item['size'];
			if ($curr_tag!="")
			{
				$tag_cloud_json = $tag_cloud_json . '{"weight":'. $curr_weight . ',"text":"'. $curr_tag .'", "html": {"data-toggle":"tooltip", "title": "' . $curr_weight .'"}},';
			}
		}
		$tag_cloud_json = rtrim($tag_cloud_json, ",");
		$tag_cloud_json = $tag_cloud_json . "]";
	}

	return $tag_cloud_json;
}

function get_journaldetails($db, $activity_id)
{
  $title = "";
	$show_titleinexport = 0;
  $activityobj = $db->read('activity', $activity_id)->fetch();
  if(!empty($activityobj)) {
    $title = $activityobj->title;
		$show_titleinexport = $activityobj->show_titleinexport;
		$export_title = $activityobj->export_title;
		$downloadfilename = $activityobj->downloadfilename;
		$downloadformat = $activityobj->downloadformat;
    //$introtext = $activityobj->introtext;
    //$feedback = $activityobj->feedback;
  }
	$details = array('title'=>$title, 'show_titleinexport'=>$show_titleinexport, 'export_title'=>$export_title, 'downloadfilename'=>$downloadfilename, 'downloadformat'=>$downloadformat);
  return $details;
}

function get_journalentries($db, $student_id, $activity_ids){
		//todo: IN statement in query not returning all records using current db lib
    //$select = $db->query( 'SELECT * FROM studentresponse WHERE student_id = :student_id AND activity_id IN (:activity_ids)', array( 'student_id' => $student_id, 'activity_ids' => $activity_ids  ) );
		//$sql = "SELECT * FROM studentresponse WHERE student_id ='". $student_id ."' AND activity_id IN (". $activity_ids .")";
		/*
		$select = $db->raw( $sql);
		$journalentries = array();
    while ( $row = $select->fetch() ) {
			print_r($row->activity_id);
      $title = get_journaldetails($db, $row->activity_id);
      $entry = array('activity_id'=>$row->activity_id, 'title'=>$title, 'reflectivetext'=>$row->reflectivetext);
      array_push($journalentries, $entry);
    }
		print_r($journalentries);
    return $journalentries;
		*/
		$activity_ids_array = explode(",", $activity_ids);
		$journalentries = array();
		foreach ($activity_ids_array as &$id)
		{
			$select = $db->query( 'SELECT * FROM studentresponse WHERE student_id = :student_id AND activity_id = :id', array( 'student_id' => $student_id, 'id' => $id  ) );
			while ( $row = $select->fetch() ) {
	      $details = get_journaldetails($db, $row->activity_id);
	      $entry = array('activity_id'=>$row->activity_id, 'title'=>$details['title'], 'show_titleinexport'=>$details['show_titleinexport'], 'export_title'=>$details['export_title'], 'downloadfilename'=>$details['downloadfilename'], 'reflectivetext'=>$row->reflectivetext);
	      array_push($journalentries, $entry);
	    }
		}
		return $journalentries;
}


function buildandexport_word($db, $student_id, $activity_ids){

  // Load the files we need:
  require_once 'lib/htmltodocx_0_6_5_alpha/phpword/PHPWord.php';
  require_once 'lib/htmltodocx_0_6_5_alpha/simplehtmldom/simple_html_dom.php';
  require_once 'lib/htmltodocx_0_6_5_alpha/htmltodocx_converter/h2d_htmlconverter.php';
  require_once 'lib/htmltodocx_0_6_5_alpha/example_files/styles.inc';

  // Functions to support this example.
  require_once 'lib/htmltodocx_0_6_5_alpha/documentation/support_functions.inc';

  // HTML fragment we want to parse:
  $entries_array = get_journalentries($db, $student_id, $activity_ids);

  $html = "";
	$downloadfilename = 'reflective_journal.docx';
  foreach ($entries_array as &$entry)
  {
		if ($entry['show_titleinexport']==1){
			$title = $entry['title'];
			if ($entry['export_title']!=""){
				$title = $entry['export_title'];
			}
			$html = $html . '<h2 style="text-align: center">' . $title . '</h2>';
		}
    $html = $html . htmlspecialchars_decode($entry['reflectivetext']);
		$downloadfilename = $entry['downloadfilename'] . 'docx';
  }
  //file_get_contents('example_files/example_html.html');
  // $html = file_get_contents('test/table.html');

  // New Word Document:
  $phpword_object = new PHPWord();
  $section = $phpword_object->createSection();

  // HTML Dom object:
  $html_dom = new simple_html_dom();
  $html_dom->load('<html><body>' . $html . '</body></html>');
  // Note, we needed to nest the html in a couple of dummy elements.

  // Create the dom array of elements which we are going to work on:
  $html_dom_array = $html_dom->find('html',0)->children();

  // We need this for setting base_root and base_path in the initial_state array
  // (below). We are using a function here (derived from Drupal) to create these
  // paths automatically - you may want to do something different in your
  // implementation. This function is in the included file
  // documentation/support_functions.inc.
  $paths = htmltodocx_paths();

  // Provide some initial settings:
  $initial_state = array(
    // Required parameters:
    'phpword_object' => &$phpword_object, // Must be passed by reference.
    // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.
    // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.
    'base_root' => $paths['base_root'],
    'base_path' => $paths['base_path'],
    // Optional parameters - showing the defaults if you don't set anything:
    'current_style' => array('size' => '12', 'name' => 'Times New Roman',), // The PHPWord style on the top element - may be inherited by descendent elements. 'indentation' => array('firstLine' => 100)
    'parents' => array(0 => 'body'), // Our parent is body.
    'list_depth' => 0, // This is the current depth of any current list.
    'context' => 'section', // Possible values - section, footer or header.
    'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).
    'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.
    'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.
    'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.
    'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.
    'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.

    // Optional - no default:
    'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.
    );

  // Convert the HTML and put it into the PHPWord object
  htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);

  // Clear the HTML dom object:
  $html_dom->clear();
  unset($html_dom);

  // Save File
  $h2d_file_uri = tempnam('', 'htd');
  $objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');
  $objWriter->save($h2d_file_uri);

  // Download the file:
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=' . $downloadfilename . );
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
  header('Content-Length: ' . filesize($h2d_file_uri));
  ob_clean();
  flush();
  $status = readfile($h2d_file_uri);
  unlink($h2d_file_uri);
  exit;
}

function buildandexport_pdf($db, $student_id, $activity_ids){

  // HTML fragment we want to parse:
  $entries_array = get_journalentries($db, $student_id, $activity_ids);

  $html = "";
	$downloadfilename = 'reflective_journal.pdf';
  foreach ($entries_array as &$entry)
  {
		if ($entry['show_titleinexport']==1){
			$title = $entry['title'];
			if ($entry['export_title']!=""){
				$title = $entry['export_title'];
			}
			$html = $html . '<h2 style="text-align: center">' . $title . '</h2>';
		}
    $html = $html . htmlspecialchars_decode($entry['reflectivetext']);
		$downloadfilename = $entry['downloadfilename'] . 'pdf';
  }

  $html = '<html><body>' . $html . '</body></html>';

	require_once 'dompdf/autoload.inc.php';

	// reference the Dompdf namespace
	use Dompdf\Dompdf;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('A4', 'landscape');

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	//$dompdf->stream();

	$dompdf->stream($downloadfilename, array("Attachment" => true));

	exit(0);
}
?>
