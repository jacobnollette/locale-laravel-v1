/***********
 * vendors *
 ***********/
//  leaflet // https://leafletjs.com/reference-1.6.0.html
require('./vendor/leaflet');
//require('./vendor/masonry');


/***********
 * globals *
 ***********/
require('./blocks/navigation');

/**********
 * blocks *
 **********/

////////////////////////////
//  dashboard / explorer  //
////////////////////////////
require('./blocks/explorer_index');
require('./blocks/dashbard_index');


////////////////
//  playlist  //
////////////////
//  index
require('./blocks/playlist_index');
//  edit
require('./blocks/playlist_edit');
