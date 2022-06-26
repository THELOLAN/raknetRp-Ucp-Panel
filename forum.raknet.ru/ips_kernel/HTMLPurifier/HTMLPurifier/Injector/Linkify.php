<?php

/**
 * Injector that converts http, https and ftp text URLs to actual links.
 */
class HTMLPurifier_Injector_Linkify extends HTMLPurifier_Injector
{

    public $name = 'Linkify';
    public $needed = array('a' => array('href'));

    public function handleText(&$token) {
        if (!$this->allowsElement('a')) return;
        
        //var_dump( $token->data ); exit;

        if (strpos($token->data, '://') === false) {
            // our really quick heuristic failed, abort
            // this may not work so well if we want to match things like
            // "google.com", but then again, most people don't
            return;
        }
//print $token->data;
        // there is/are URL(s). Let's split the string:
        // Note: this regex is extremely permissive
        //$bits = preg_split('#((?:https?|ftp)://[^\s\'"<>()]+)#S', $token->data, -1, PREG_SPLIT_DELIM_CAPTURE);
        /* MODIFIED April 26, 2013
            @link http://community.invisionpower.com/resources/bugs.html/_/ip-board/links-being-corrupted-or-malformed-in-board-and-nexus-r41993
            Test case:
http://invisionpower.com,
http://invisionpower.com.
http://invisionpower.com
https://invisionpower.com
https://blah.gov/blah-blah.as
http://en.wikipedia.org/wiki/Chi_(mythology)
http://en.wikipedia.org/wiki/Assassin's_Creed
(http://google.com)
             */
        
        preg_match_all( "#(.*?)(\()?((?:http|ftp|https):\/\/[\w\-_]+(?:\.[\w\-_]+)?(?:[\w\-\.,\'\(\)@?^=%&amp;:/~\+\#]*[\w\-\@?^=%&amp;/~\+\#]))(.*)(?(?=\S+)\S+)(.*)$#ims", $token->data, $matches );
        
        //$token = array();

        // $i = index
        // $c = count
        // $l = is link
        /*for ($i = 0, $c = count($bits), $l = false; $i < $c; $i++, $l = !$l) {
            if (!$l) {
                if ($bits[$i] === '') continue;
                $token[] = new HTMLPurifier_Token_Text($bits[$i]);
            } else {
                $token[] = new HTMLPurifier_Token_Start('a', array('href' => $bits[$i]));
                $token[] = new HTMLPurifier_Token_Text($bits[$i]);
                $token[] = new HTMLPurifier_Token_End('a');
            }
        }*/
        if( is_array($matches[0]) AND count($matches[0]) )
        {
            $token = array();

            foreach( $matches[0] as $k => $match )
            {
                if( !$matches[3][$k] )
                {
                    $token[]   = new HTMLPurifier_Token_Text($token->data);
                }
                else
                {
                    if( $matches[1][$k] )
                    {
                    	if ( stripos( $matches[1][$k], '[' ) !== FALSE AND stripos( $matches[4][$k], ']' ) !== FALSE )
						{
							/* Concatenate and test to make sure we're not linking inside a bbcode option */
							$test = $matches[1][$k] . $matches[3][$k] . $matches[4][$k];
							if ( preg_match( '#\[([a-zA-Z]+)\=(http:\/\/|https:\/\/|ftp"\/\/)#i', $test ) )
							{
		                	    $matches[1][$k] .= $matches[3][$k] . $matches[4][$k];
		                	    unset( $matches[3][$k] );
		                	    unset( $matches[4][$k] );
							}
						}
						
                        $token[] = new HTMLPurifier_Token_Text($matches[1][$k]);
                    }
                    
                    if( $matches[2][$k] )
                    {
                        $token[] = new HTMLPurifier_Token_Text($matches[2][$k]);
                    }
					
					/**
					 * This looks a little weird so bare with me. When attempting to detect the URL, a space is added to try and separate it from any non-URL text (ending BBCode tag, for example)
					 * Previously, the if() statement below checked to see if ANY spaces were added at all, and if so, we just stopped processing immediately. The posed problems where a URL such as:
					 * [mybbcode]https://test.domain.com/linkwith#!strangechars[/mybbcode] would be cut off at the exclamation point.
					 *
					 * As such, rather than trying to detect if there is a space anywhere in the string, we only check at the end of it. Inside the conditional, we look for the presence of a space,
					 * and if found, explode the string into to two pieces, starting from the first space found. If the first bit is not an exclamation point, full stop, or comma, then we add it to
					 * the URL, and reassign the other bit to $matches[4][$k]. Otherwise, we just recompile the bits together again into $matches[4][$k] and ignore them.
					 *
					 * mind = blown
					 */
                    if( !$matches[2][$k] AND !in_array( $matches[4][$k], array( '!', '.', ',' ) ) AND substr( $matches[4][$k], 0, -1 ) !== ' ' AND ! preg_match( "#(\r|\n|\r\n)#i", $matches[4][$k] ) )
                    {
                    	if ( stripos( $matches[4][$k], ' ' ) !== FALSE )
                    	{
	                    	$bits = explode( ' ', $matches[4][$k], 2 );
	                    	if ( ! in_array( $bits[0], array( '!', '.', ',' ) ) )
	                    	{
		                    	$matches[3][$k] .= $bits[0];
								$matches[4][$k] = $bits[1];
	                    	}
	                    	else
	                    	{
		                    	$matches[4][$k] = implode( ' ', $bits );
	                    	}
                    	}
                    	else
                    	{
	                        $matches[3][$k] .= $matches[4][$k];
							unset($matches[4][$k]);
						}
                    }
                    
                    $token[] = new HTMLPurifier_Token_Start('a', array('href' => str_replace( '\'', '%27', $matches[3][$k] )));
                    $token[] = new HTMLPurifier_Token_Text($matches[3][$k]);
                    $token[] = new HTMLPurifier_Token_End('a');

                    if( $matches[4][$k] )
                    {
                  		// Let's do some testing. We may need to recurse in on this line for extra links.
                  		$test = explode( ' ', $matches[4][$k] );
                  		foreach( $test AS $v )
                  		{
                  			if ( strpos( $v, 'http' ) !== false OR strpos( $v, 'https' ) !== false OR strpos( $v, 'ftp' ) !== false )
                  			{
                  				$token[] = new HTMLPurifier_Token_Start('a', array('href' => str_replace( '\'', '%27', $v )));
                  				$token[] = new HTMLPurifier_Token_Text($v);
                  				$token[] = new HTMLPurifier_Token_End('a');
                  				$token[] = new HTMLPurifier_Token_Text(' '); // Because we exploded the text, spaces were lost. Re-add them.
                  			}
                  			else
                  			{
                  				$token[] = new HTMLPurifier_Token_Text($v);
                  				$token[] = new HTMLPurifier_Token_Text(' '); // Because we exploded the text, spaces were lost. Re-add them.
                  			}
                  		}
                        //$token[] = new HTMLPurifier_Token_Text($matches[4][$k]);
                    }
                    
                    if( $matches[5][$k] )
                    {
                    	$token[] = new HTMLPurifier_Token_Text( $matches[5][$k] );
                    }
                   
                }
            }
        }
    }

}

// vim: et sw=4 sts=4
