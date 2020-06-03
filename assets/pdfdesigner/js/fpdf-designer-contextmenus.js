/**
 * FPDF WYSIWYG Script Context Menus 1.1
 * Created by MklProgi on 09/10/2018.
 * Copyright 2018 MklProgi
 * Sales platform Codecanyon.net
 */

function contextmenu_cell(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setvalue-element": {"name": "Change value"},
					"setheight-element": {"name": "Change height"},
					"setwidth-element": {"name": "Change width"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-setfillcolor": {"name": "Fill color"},
							"elemcolor-setdrawcolor": {"name": "Draw color"},
							"elemcolor-settextcolor": {"name": "Text color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
					"borders": {
						"name": "Border", 
						"items": {
							"border-remove": {"name": "Remove"},
							"border-all": {"name": "All"},
							"border-top": {"name": "Top"},
							"border-bottom": {"name": "Bottom"},
							"border-right": {"name": "Right"},
							"border-left": {"name": "Left"},
						}
					},
					"textaligns": {
						"name": "Text align", 
						"items": {
							"textalign-left": {"name": "Left"},
							"textalign-center": {"name": "Center"},
							"textalign-right": {"name": "Right"}
						}
					},
					"setfills": {
						"name": "Set fill", 
						"items": {
							"setfill-yes": {"name": "Yes"},
							"setfill-no": {"name": "No"}
						}
					},
					"fonts": {
						"name": "Fonts", 
						"items": opt.config.fonts
					},
					"fontsize": {
						"name": "Font sizes", 
						"items": opt.config.fontsizes
					},
					"fontstyles": {
						"name": "Font-style", 
						"items": {
							"fontstyle-normal": {"name": "Normal"},
							"fontstyle-bold": {"name": "Bold"},
							"fontstyle-normalitalic": {"name": "Italic"},
							"fontstyle-bolditalic": {"name": "Bold Italic"}
						}
					},
				};
	return menu;
};

function contextmenu_line(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setwidth-element": {"name": "Change width"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-setdrawcolor": {"name": "Draw color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
				};
	return menu;
};

function contextmenu_link(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setvalue-element": {"name": "Change link"},
					"setheight-element": {"name": "Change height"},
					"setwidth-element": {"name": "Change width"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-settextcolor": {"name": "Text color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
					"fonts": {
						"name": "Fonts", 
						"items": opt.config.fonts
					},
					"fontsize": {
						"name": "Font sizes", 
						"items": opt.config.fontsizes
					},
					"fontstyles": {
						"name": "Font-style", 
						"items": {
							"fontstyle-normal": {"name": "Normal"},
							"fontstyle-bold": {"name": "Bold"},
							"fontstyle-normalitalic": {"name": "Italic"},
							"fontstyle-bolditalic": {"name": "Bold Italic"}
						}
					},
				};
	return menu;
};

function contextmenu_multicell(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setmulticellvalue-element": {"name": "Change value"},
					"setheight-element": {"name": "Change height"},
					"setwidth-element": {"name": "Change width"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-setfillcolor": {"name": "Fill color"},
							"elemcolor-setdrawcolor": {"name": "Draw color"},
							"elemcolor-settextcolor": {"name": "Text color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
					"borders": {
						"name": "Border", 
						"items": {
							"border-remove": {"name": "Remove"},
							"border-all": {"name": "All"},
							"border-top": {"name": "Top"},
							"border-bottom": {"name": "Bottom"},
							"border-right": {"name": "Right"},
							"border-left": {"name": "Left"},
						}
					},
					"textaligns": {
						"name": "Text align", 
						"items": {
							"textalign-left": {"name": "Left"},
							"textalign-center": {"name": "Center"},
							"textalign-right": {"name": "Right"}
						}
					},
					"setfills": {
						"name": "Set fill", 
						"items": {
							"setfill-yes": {"name": "Yes"},
							"setfill-no": {"name": "No"}
						}
					},
					"fonts": {
						"name": "Fonts", 
						"items": opt.config.fonts
					},
					"fontsize": {
						"name": "Font sizes", 
						"items": opt.config.fontsizes
					},
					"fontstyles": {
						"name": "Font-style", 
						"items": {
							"fontstyle-normal": {"name": "Normal"},
							"fontstyle-bold": {"name": "Bold"},
							"fontstyle-normalitalic": {"name": "Italic"},
							"fontstyle-bolditalic": {"name": "Bold Italic"}
						}
					},
				};
	return menu;
};

function contextmenu_image(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setvalue-element": {"name": "Change file"},
					"setheight-element": {"name": "Change height"},
					"setwidth-element": {"name": "Change width"},
					"imagetype": {
						"name": "Image Format", 
						"items": {
							"imageformat-remove": {"name": "Remove"},
							"imageformat-jpg": {"name": "JPG"},
							"imageformat-jpeg": {"name": "JPEG"},
							"imageformat-png": {"name": "PNG"},
							"imageformat-gif": {"name": "GIF"}
						}
					},
				};
	return menu;
};

function contextmenu_ln(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setheight-element": {"name": "Change height"}
				};
	return menu;
};

function contextmenu_write(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setheight-element": {"name": "Change height"},
					"setvalue-element": {"name": "Change value"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-settextcolor": {"name": "Text color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
					"fonts": {
						"name": "Fonts", 
						"items": opt.config.fonts
					},
					"fontsize": {
						"name": "Font sizes", 
						"items": opt.config.fontsizes
					},
					"fontstyles": {
						"name": "Font-style", 
						"items": {
							"fontstyle-normal": {"name": "Normal"},
							"fontstyle-bold": {"name": "Bold"},
							"fontstyle-normalitalic": {"name": "Italic"},
							"fontstyle-bolditalic": {"name": "Bold Italic"}
						}
					},
				};
	return menu;
};

function contextmenu_rect(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setheight-element": {"name": "Change height"},
					"setwidth-element": {"name": "Change width"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-setfillcolor": {"name": "Fill color"},
							"elemcolor-setdrawcolor": {"name": "Draw color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
					"styles": {
						"name": "Style", 
						"items": {
							"rectstyle-D": {"name": "Draw"},
							"rectstyle-F": {"name": "Fill"},
							"rectstyle-DF": {"name": "Draw and fill"}
						}
					},
				};
	return menu;
};

function contextmenu_setfillcolor(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setgreyscale-element": {"name": "Set grey scale"},
					"setrgb-element": {"name": "Set color"},
					
				};
	return menu;
};

function contextmenu_setdrawcolor(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setgreyscale-element": {"name": "Set grey scale"},
					"setrgb-element": {"name": "Set color"},
					
				};
	return menu;
};

function contextmenu_settextcolor(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setgreyscale-element": {"name": "Set grey scale"},
					"setrgb-element": {"name": "Set color"},
					
				};
	return menu;
};

function contextmenu_text(opt){
	'use strict';
	
	var menu = 	{
					"delete-element": {"name": "Delete"},
					"setvalue-element": {"name": "Change value"},
					"colors": {
						"name": "Colors", 
						"items": {
							"elemcolor-settextcolor": {"name": "Text color"},
							"elemcolor-remove": {"name": "Remove all colors"}
						}
					},
					"fonts": {
						"name": "Fonts", 
						"items": opt.config.fonts
					},
					"fontsize": {
						"name": "Font sizes", 
						"items": opt.config.fontsizes
					},
					"fontstyles": {
						"name": "Font-style", 
						"items": {
							"fontstyle-normal": {"name": "Normal"},
							"fontstyle-bold": {"name": "Bold"},
							"fontstyle-normalitalic": {"name": "Italic"},
							"fontstyle-bolditalic": {"name": "Bold Italic"}
						}
					},
				};
	return menu;
};



