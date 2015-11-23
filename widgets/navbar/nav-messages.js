(function ( $ ) {
    $.fn.navmessages = function( options ) {
        /*
		 * Private property SELF
		 * Return Object this
		 */
		var SELF = this;
		/*
		 * Private property element
		 * Return Object Jquery
		 */
		var element = $(this); 
		/*
		 * Private property settings
		 * Return Object
		 */
		var settings = {
			data : {},
			url : '',
			token : '',
			autoload : true,
			duration : 30, //30 second
			tLabel : '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' +
			'<i class="fa fa-envelope-o"></i>' +
			'<span class="label {classlabel}">{countmsg}</span>' +
			'</a>',
			tDropdownmenu : '<ul class="dropdown-menu">' +
			'<li class="header">Anda memiliki {countmsg} Pesan</li>' + 
			'<li><ul class="menu">{menuitem}</ul></li>' +
			'<li class="footer"><a href="#">Lihat Semua Pesan</a></li>' +
			'</ul>',
			tMenuitem : '<li>' +
			'<a href="{action}">' +
			'<div class="pull-left">' +
			'<img src="{imgsrc}" class="img-circle" alt="Img"/>' +
			'</div>' +
			'<h4>{title} <small><i class="fa fa-clock-o"></i>{time}</small></h4>' +
			'<p>{description}</p>' +
			'</a>' +
			'</li>',
		};
		/*
		 * Public method init
		 * Return Object
		 */
		var init = function(){
			removeMenu();
			if(settings.url != ''){
				$.ajax({
					url : settings.url,
					data : {'access-token' : settings.token},
					type : 'GET',
					dataType : 'JSON',
					success : function(response){
						//console.log(response);
						settings.data = response;
						load();
						
					}
				});	
			}
			if(settings.data.length > 0 && settings.url == ''){
				settings.data = JSON.parse(settings.data);
				load();
			}
			return SELF;
		}
		/*
		 * Private method load
		 * Return nothing
		 */
		var load = function(){
			var data = settings.data;
			var countmsg = data.length;
			var label = settings.tLabel.replace(/\{countmsg}/g, countmsg)
						.replace(/\{classlabel}/g, (countmsg > 0) ? 'label-danger' : 'label-success');
						
			var menuitem = '';
			for(index in data){
				var msgdesc = data[index].description.slice(0,35);
				
				menuitem += settings.tMenuitem.replace(/\{action}/g, data[index].action)
				.replace(/\{imgsrc}/g, data[index].avatar)
				.replace(/\{title}/g, data[index].title)
				.replace(/\{time}/g, data[index].time)
				.replace(/\{description}/g, msgdesc);	
			}
			var dropdownmenu = settings.tDropdownmenu.replace(/\{countmsg}/g, countmsg)
							.replace(/\{menuitem}/g, menuitem);
			
			element.append(label, dropdownmenu);
		}
		/*
		 * Private method removeMenu
		 * Return nothing
		 */
		var removeMenu = function(){
			element.empty();
		}
		/*
		 * Public method load
		 * Return nothing
		 */
		this.reload = function( options ){
			if(typeof options == 'object'){
				settings = $.extend(settings, options );
			}
			removeMenu();
			load();
		}
		
		if(typeof options == 'object'){
			settings = $.extend(settings, options );	
		}
		if(settings.autoload){
			setInterval(init, settings.duration * 1000);
		}
		return init();
    };
}( jQuery ));