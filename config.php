<?php

### Config file for puppyCMS by James Welch, 2017.

### Change the variables below to personalise your site

$site_name = "Puppy"; # e.g. Steve's Site
$site_brand = "Puppy"; # Short text that goes above the menu - or you can use 'Menu' (or leave blank) if you like

$site_root = "/"; # the folder in which you install puppyCMS. If its at the root of a domain, then simply put '/'. For any other folder, please use trailing slash.

$site_template = "puppy.tpl"; #option of puppy.tpl or bootstrap.tpl - in future versions, it can be changed per page

# email for forms - this is the email your enquiries will go to.
$form_email = "your@email.com";

$menu = 'left-sidebar'; # 3 options left-sidebar or right-sidebar or top-menu (this is for puppy.tpl template only)
$blog_mode = 0; # if set to 1, then pages are shown in menu in reverse time order. 0 lists pages alphabetically.
$show_social = 0; # if set to 1, then show social share buttons in side bar (at the bottom if using hamburger menu).
$show_edit = 0; # if set to 1, then show Admin link in menu.
$better_fonts = 0; # if set to 1, then better-sized fonts will be used depending on the display the site is seen on. makes things more readable. WORTH TRYING :)
$evil_icons = 1; # ability to use evil icons (evil-icons.io) for nice looking icons  - e.g. <div data-icon="ei-chart" data-size="s"></div>
$scroll_anim = 0; #if this is set then you can create scroll effects on divs, paragraphs, images etc by using ASO (http://michalsnik.github.io/aos/).
# Example code: <div data-aos="flip-up" data-aos-duration="3000" data-aos-offset="300">Blah blah blah.</div>

$show_slider = 0; # if set to 1, then show content slider on home page.
# if you do want to show a slider on the home page, put content (such as an image url, or a paragraph of text) in each $slide(x) variable. Max 5. Images must all be the same size.
	$slide[0] = "";
	$slide[1] = "";
	$slide[2] = "";
	$slide[3] = "";
	$slide[4] = "";
	$slide[5] = "";

#link text - change these phrases to urls whenever they are used in text on a page (only changes the first occurance of a phrase on a page)
# e.g. link red widgets to http://redwidgets.com
$link_text=array(
	"PuppyCMS"=>"http://puppycms.com",
);


#####################################################################################
### the stuff below is more geeky stuff, so only play with it if you know what you're doing!

define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');

define('CONTENT_DIR', ROOT_DIR. '/content/'); // change this to change which folder you want your content to be stored in. too many things rely on this, so leave.

# if no title has been added, then use site name.
$default_title = $site_name;

$file_format = ".txt"; // do not change this whatsoever

// Get request url and script url
$url = '';
$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
	
// Get our url path and trim the / of the left and the right
if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');

// Get the file path
if($url) {
	$file = strtolower(CONTENT_DIR . $url);
} else {
	$file = CONTENT_DIR .'index';
}

// Load the file
if(is_dir($file)) {
	$file = CONTENT_DIR . $url .'/index' . $file_format;
} else {
	$file .=  $file_format;
}

# make the title tag human-readable
$title = ucwords(str_replace("-"," ",$url));

############################################## all below is instructions at the top of each page (title, desc etc) ###################################

# grab the first line of the file, to see if it has any instructions in it.

$first_line = "";
if(file_exists($file)) {
	$first_line = fgets(fopen($file, 'r'));
}

$meta_desc = NULL; #register the variable

//if the file has the optional instructions heading line, then do stuff, else show the page as normal
if ( strpos($first_line, '|') !== false) {
	
	//extract the instructions between the pipes
	$display = explode('|', $first_line);

	//create a title tag if its there
	if ($display[1] != "") {
		$title = $display[1];
	}

	//create a meta description tag if its there
	if ($display[2] != "") {
		$meta_desc = '<meta name="description" content="'.$display[2].'">';
		
	} else {$meta_desc = " ";}


	// get the contents of the file
	if(file_exists($file)) {
		$content = file_get_contents($file);
	    $content = preg_replace("/[|](.*)[\n\r]/","",$content,1);
	}else {
		// Show 404 if file cannot be found
		$content = file_get_contents(CONTENT_DIR .'404' . $file_format);
		$content = preg_replace("/[|](.*)[\n\r]/","",$content,1);
	}
	
} else  {
	//if there were no instructions
	
	if(file_exists($file))  {
		$content = file_get_contents($file);
	} else {
		// Show 404 if file cannot be found
		$content = file_get_contents(CONTENT_DIR .'404' . $file_format);
	}
	
}

# function to change text to links
	
function str_replace_first($from, $to, $subject) {
	$from = '/'.preg_quote($from, '/').'/';
	return preg_replace($from, $to, $subject, 1);
}

# this is where I'm hiding :-)
$puppy_link = 1; # if set to 1 then show link to puppy site.
$puppy_version = "5.1";
?>
