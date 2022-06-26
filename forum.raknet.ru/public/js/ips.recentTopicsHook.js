
var _recentTopics = window.IPBoard;

_recentTopics.prototype.recentTopics = {
	ajaxHandler: '',
	updateInterval: '',
	maxElements: '',
	removalInProgress: false,
	ourTids: $A(),
	
	init: function()
	{
		document.observe( 'dom:loaded', function()
		{
			$( 'recentTopicsWrapper' ).down( 'h3 a.toggle' ).observe( 'click', ipb.recentTopics.toggleVisibility );	
		
			ipb.recentTopics.buildOurTids();
			
			ipb.recentTopics.ajaxHandler = new Ajax.PassivePeriodicalUpdater( 'recentTopicsWrapper', ipb.vars['base_url'] + '&app=forums&module=ajax&section=recentTopics',
			{
				method: 'post',
				frequency: ipb.recentTopics.updateInterval,
				decay: 1,
				evalJSON: 'force',
				parameters: {
					secure_key: 	ipb.vars['secure_hash'],
					last_post_time: $( 'recentTopicsWrapper' ).down( '.__topic' ).readAttribute( 'data-timestamp' ),
					our_tids: JSON.stringify( ipb.recentTopics.ourTids.uniq() )
				},
				hideLoader: ipb.recentTopics.img_disable ? true : false,
				onSuccess: function(t)
				{
					if ( t.responseJSON['html'] || t.responseJSON['updated'] )
					{
						var newStuff = new Element( 'div' );
					}
					
					if ( t.responseJSON['html'] )
					{
						newStuff.insert( t.responseJSON['html'] );
					}
					
					if ( t.responseJSON['updated'] )
					{
						t.responseJSON['updated'].each( function( tRow )
						{
							if ( $( 'trow_' + tRow.tid ) )
							{
								elem = $( 'trow_' + tRow.tid ).up( 'li' );
								
								new Effect.BlindUp( elem, 
								{
									duration: 0.5,
									afterFinish: function() 
									{ 
										$( elem ).remove();
										newStuff.insert( tRow.html );
									} 
								});
								
							}
						})
					}
					
					if ( t.responseJSON['html'] || t.responseJSON['updated'] )
					{
						$( 'recentTopics_table' ).insert( { top: newStuff } );
						
						Effect.Pulsate( newStuff, { pulses: 3, duration: 1.5 } );
									
						ipb.recentTopics.recountTopicListAndDrop();
						
						ipb.recentTopics.buildOurTids();
					}
					
					
					return;
				}
			});
            
			if( ipb.Cookie.get('toggleRecentTopics') == '1' )
			{	
				$( 'recentTopicsWrapper' ).down( '.table_wrap' ).hide();
				$( 'recentTopicsWrapper' ).down( 'h3' ).addClassName( 'collapsed' );
				ipb.recentTopics.ajaxHandler.stop();
			}
		});
	},
	
	recountTopicListAndDrop: function()
	{
		if ( ipb.recentTopics.removalInProgress == true )
		{
			Debug.error( "Removal in progress" );
			return false;
		}
		
		var numElements = $$( '#recentTopics_table tr.__topic' ).length;
		
		if ( numElements > ipb.recentTopics.maxElements )
		{
			ipb.recentTopics.removalInProgress = true;
			
			var toRemove = numElements - ipb.recentTopics.maxElements;
			
			for( var tr=0; tr < toRemove; tr++ )
			{
				new Effect.BlindUp( $$( '#recentTopics_table tr.__topic' ).last().up( 'li' ), 
				{
					duration: 0.5,
					afterFinish: function() 
					{ 
						$$( '#recentTopics_table tr.__topic' ).last().up( 'li' ).remove(); 
					} 
				});
			}
			
			ipb.recentTopics.removalInProgress = false;
			
			Debug.write( "Removed a topic entry" );
		}
	},
	
	buildOurTids: function()
	{
		$$( '#recentTopics_table tr.__topic' ).each( function(elem) 
		{
			tid = elem.readAttribute( 'data-tid' );
			timestamp = elem.readAttribute( 'data-timestamp' );
			ipb.recentTopics.ourTids[ tid ] = $A( [ tid, timestamp ] );
		});
	},
	
	toggleVisibility: function( e )
	{
		if( ipb.board.animating ){ return false; }
		
		Debug.write( 'collapsing' );
		
		var click = Event.element(e);
		var remove = $A();
		var wrapper = $( 'recentTopicsWrapper' ).down( '.table_wrap' );
		Debug.write( wrapper );
		var catname = $( 'recentTopicsWrapper' ).down( 'h3' );
		
		ipb.board.animating = true;
		
		// Get cookie
		var cookie = ipb.Cookie.get( 'toggleRecentTopics' );
		if( cookie == null )
		{
			cookie = $A();
		} 
		
		Effect.toggle( wrapper, 'blind', { duration: 0.4, afterFinish: function(){ ipb.board.animating = false; } } );
		
		if( catname.hasClassName( 'collapsed' ) )
		{
			catname.removeClassName( 'collapsed' );
			ipb.Cookie.set( 'toggleRecentTopics', '0', 1 );
			
			ipb.recentTopics.ajaxHandler.start();
		}
		else
		{
			new Effect.Morph( $( catname ), { style: 'collapsed', duration: 0.4, afterFinish: function(){
				$( catname ).addClassName('collapsed');
				ipb.board.animating = false;
			} });
			
			ipb.Cookie.set( 'toggleRecentTopics', '1', 1 );
			
			ipb.recentTopics.ajaxHandler.stop();
		}

		
		Event.stop( e );
	}
};

//------------------------------
// @author: adrianscott
// http://www.fluther.com/disc/9117/ajaxperiodicalupdater-only-update-if-the-content-has-changed/#quip58902
//------------------------------
Ajax.PassivePeriodicalUpdater = Class.create(Ajax.Base, 
{
	initialize: function($super, container, url, options) 
	{
		$super(options);
		this.onComplete = this.options.onComplete;
		
		this.frequency = this.options.frequency;
		this.decay = this.options.decay;
		this.updater = { };
		this.container = $(container);
		this.url = url;
		this.firstRun = 1;
		this.lastTidTimestamp = '';

		this.start();
	},
		
	start: function() 
	{
		this.options.onComplete = this.updateComplete.bind(this);
		this.onTimerEvent();
		Debug.write( "Starting timer" );
	},
		
	stop: function() 
	{
		if ( this.updater == undefined )
		{
			this.updater.options.onComplete = Prototype.emptyFunction;
		}
		
		clearTimeout(this.timer);
		this.decay = this.options.decay;
		
		(this.onComplete || Prototype.emptyFunction).apply(this, arguments);
		Debug.write( "Stopping timer" );
	},
		
	updateComplete: function(t) 
	{
		if ( t.responseJSON['last_tid'] + '-' + t.responseJSON['last_tid_timestamp'] == this.lastTidTimestamp || t.responseJSON['error'] ) 
		{
			if ( this.firstRun )
			{
				this.decay = 1;
				this.firstRun = 0;
			}
			else
			{
				this.decay = this.decay * this.options.decay;
			}
		} 
		else 
		{
			this.decay = this.options.decay;
			
			this.lastTidTimestamp = t.responseJSON['last_tid'] + '-' + t.responseJSON['last_tid_timestamp']; 
			this.options.parameters.last_post_time = t.responseJSON['last_tid_timestamp'];
		}
		
		this.timer = this.onTimerEvent.bind(this).delay( this.decay * this.frequency );
		Debug.info( "new timeout: " + (this.decay * this.frequency) );
		
		return true;
	},
		
	onTimerEvent: function() {
	 	
		this.updater = new Ajax.Request( this.url, this.options );
	}
});

ipb.recentTopics.init();