<?php
#If I am an Iframe, I want to call the function and print out the page
if($_GET['method'] == 'iframe')
  {$endoid = $_GET['endoid'];
	$method = $_GET['method'];
	$cssloc = $_GET['cssloc'];
  echo endo_genhtml($endoid, $method, $cssloc);
  };
  
function endo_genhtml($endoid, $method, $cssloc){
#Grab the variables
require(dirname(__FILE__) . "/endovariables.php");

#Grab the remote site
$contents = file_get_contents('http://www.endomondo.com/profile/'.$endoid);

#Modify the remote HTML using the replacements in the variables php
$modified_html = str_replace(
  array_keys($searchReplaceArray),
  array_values($searchReplaceArray),
  $contents
);

if($cssloc == 'local') {
	if(!class_exists('externalURL'))  {require_once(dirname(__FILE__) . "/sysfunctions.php");};

	#If i am an iframe, then I cannot reference the plugin_url function, and need to figure out the path myself.
	if($method == 'iframe'){$css_path = externalURL('dir').'endostyle.css';}
	
	#If I am local, the result of externalURL doesnt give me the correct path, but I can reference the plugins_url function
	elseif($method == 'local'){$css_path = plugins_url('endotom/endostyle.css',_FILE_);};
	
	//I could have just used plugins_url function for both	however, as frame.php file runs outside the wordpress codex,
	//you would need to include the wp-includes/link-template.php using "../../", I get the feeling is not reconmended. 
	//Alternitivly, I could have used a global variable: $_SESSION['endotom'] = plugins_url('endostyle.css',_FILE_); on 
	//the endotom.php and referenced it using $_SESSION['endotom']
	
	$css_snip = '<link rel="stylesheet" type="text/css" href="'.$css_path.'">';
	}
else
  {
	#Cut out the CSS using the Start and End strings pattern
	if(preg_match($css_match, $modified_html, $css_matches))
	  {
	  $css_snip = $css_matches[1];
	  }
	else
	{
	$EndoErrorCSS = True;
	};
  }

#Cut out the column using the Start and End strings pattern
if(preg_match($col_match, $modified_html, $col_matches))
  {
  $col_snip = $col_matches[1];
  }
else
{
$EndoErrorCOL = True;
};

#If there is a match error, then let the user know
if (($EndoErrorCSS==True) || ($EndoErrorCOL==True))
    {return 'Match Error has occured, check endomondo profile page, or contact plugin support Debug info=CSS:'. $EndoErrorCSS . ' COL:' . $EndoErrorCOL . ' </b>';}
else
	#There are too many Div close tags which cause issues on main page.
	#Remove last div close tag
	{$endo_build = str_lreplace('</div>', '', $col_snip);}

	#Put everything together
	
	#Print Headder information for iframe
	if($method == 'iframe'){$output = '<html><head>';};
	if($method == 'iframe' || $cssloc == 'external'){$output .= $css_snip;};
	if($method == 'iframe'){$output .= '</head>';};
	
	#Cant just set endo_style_id as "ew" as it will automatically inherit from stylesheet
	if($cssloc == 'local'){$endo_css_id = ' id="ew"';};
	
	if($method == 'iframe'){$output .= '<body'.$endo_css_id.'>';}
	elseif($method == 'local'){$output .= '<div'.$endo_css_id.'>';};
	
	$output .= $endo_build;

	#Close the tags
	if($method == 'iframe'){$output .= '</body></html>';}
	elseif($method == 'local'){$output .= '</div>';};
	
return $output;

};

#Function to search and replace for the last instance of a string
function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);
    if($pos == false)
    {
        return $subject;
    }
    else
    {
        return substr_replace($subject, $replace, $pos, strlen($search));
    };
}
?>