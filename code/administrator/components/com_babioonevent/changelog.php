<?php
/**
 *
 * @version 2.0
 * @package BABIOONEVENT
 * @author Robert Deutz
 * @copyright Robert Deutz Business Solution
 **/

die( 'Direct Access to this location is not allowed.' );
?>

Changelog for Babioon Event Component


Changelog
------------
This is a non-exhaustive (but still near complete) changelog for
the component, including beta and release candidate versions.
Our thanks to all those people who've contributed bug reports and
code fixes.

Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

-- Version 2.0.0 -- 25 October 2012 -----------------------------------------
! changed the version naming scheme, see http://babioon.com


-- Version 1.2 -- 5 May 2012 -----------------------------------------
! renamed to babioon event to avoid migration conflicts

-- Version 1.1 -- 30 August 2009 ----------------------------------------
# freeofcharge display problem

-- Version 1.0 -- 24 August 2009 ----------------------------------------
^ change class prefix from Event to RdEvent
^ change configration handling
^ rd_event table added 3 colums: sizex, sizey, image 
^ change to system plugin usage
! Master Component is also nessesary
- config controller, model, view
^ moved xml configuration files to configuration directory
^ changed section from 'com_rd_event_details' to 'com_rd_event'
^ language strings all start with RDEVENT_
^ split datetime in date and time 


-- Version 0.9 -- 18 April 2008 -----------------------------------------
