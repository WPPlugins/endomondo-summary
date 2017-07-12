<?php
#Array of find/replace strings to modify the remote HTML to your needs
#Thank you http://stackoverflow.com!
$searchReplaceArray = array(
  '="../' => '="http://endomondo.com/',
  '<select' => '<!-- Hidden <select',
  'bind(this));">' => 'bind(this));"> -->',
  '?wicket:interface=:0:pageContainer:lowerMain:lowerMainContent:personalSummary:footer:statsLink::ILinkListener::"' => 'stats/'.$endoid.'"'
);

#The CSS section from the remote webiste we want to grab
$css_startcut = '<link rel="SHORTCUT ICON" href="http:\/\/www.endomondo.com\/favicon.ico" \/>';
$css_endcut = '<script type="text\/javascript" id="onEnterFormSubmitBehavior">';

#The Content section from the remote website we want to grab
$col_startcut = '<div class="column">';
$col_endcut = '<div class="profileNews">';

#Create the cutout code match string (dont need to touch this)
$css_match = '/' . $css_startcut . '(.*)' . $css_endcut . '/s';
$col_match = '/' . $col_startcut . '(.*)' . $col_endcut . '/s';

$endo_htmltag_a = 
'<html><head>
';

$endo_htmltag_b = 
'
</head>
<body id="ew">';

$endo_htmltag_c = '
</body>
</html>';

?>