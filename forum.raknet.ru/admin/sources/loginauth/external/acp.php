<?php

/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.4.8
 * Login handler abstraction : External method
 * Last Updated: $Date: 2012-05-10 16:10:13 -0400 (Thu, 10 May 2012) $
 * </pre>
 *
 * @author 		$Author: bfarber $
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/company/standards.php#license
 * @package		IP.Board
 * @link		http://www.invisionpower.com
 * @since		Tuesday 1st March 2005 (11:52)
 * @version		$Revision: 10721 $
 *
 */

$config		= array(
					array(
							'title'			=> 'Remote Database Host',
							'description'	=> "Usually 'localhost' if database is you do not have more than one server",
							'key'			=> 'REMOTE_DB_SERVER',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Port',
							'description'	=> 'Leave blank if not sure',
							'key'			=> 'REMOTE_DB_PORT',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Database Name',
							'description'	=> 'The name of the database you want to authenticate against',
							'key'			=> 'REMOTE_DB_DATABASE',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Username',
							'description'	=> 'Username for your remote database',
							'key'			=> 'REMOTE_DB_USER',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Password',
							'description'	=> "Password for your remote database",
							'key'			=> 'REMOTE_DB_PASS',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Table Name',
							'description'	=> "The table in the remote database holding the user's authentication credentials",
							'key'			=> 'REMOTE_TABLE_NAME',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Table Prefix',
							'description'	=> 'If your remote database has table prefixes, enter it here and leave it off of the table name configured above',
							'key'			=> 'REMOTE_TABLE_PREFIX',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Remote Database Username Field',
							'description'	=> "The field in the remote database to verify the submitted email address or username against",
							'key'			=> 'REMOTE_FIELD_NAME',
							'type'			=> 'string',
						),
					array(
							'title'			=> 'Remote Database Password Field',
							'description'	=> "The field in the remote database to verify the submitted password against",
							'key'			=> 'REMOTE_FIELD_PASS',
							'type'			=> 'string',
						),
					array(
							'title'			=> 'Extra Database Query Info',
							'description'	=> "Any extra query to run (eg: AND status='active')" ,
							'key'			=> 'REMOTE_EXTRA_QUERY',
							'type'			=> 'string'
						),
					array(
							'title'			=> 'Password Hashing Technique',
							'description'	=> "How are passwords hashed?  If any method other than specified below, you will need to alter the code in auth.php to handle the password" ,
							'key'			=> 'REMOTE_PASSWORD_SCHEME',
							'type'			=> 'select',
							'options'		=> array( array( 'md5', 'MD5' ), array( 'sha1', 'SHA1' ), array( 'none', 'Plain Text' ) )
						),
					array(
							'title'			=> 'Remote Database Connection Type',
							'description'	=> "This field is only used for databases that use connection types, such as MS-SQL",
							'key'			=> 'REMOTE_SQL_TYPE',
							'type'			=> 'string',
						),
					);