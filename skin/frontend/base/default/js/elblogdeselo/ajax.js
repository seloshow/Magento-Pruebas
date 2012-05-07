/*script para realizar las diferentes llamadas ajax*/
var loadContent =  'local.pruebas.com/pruebaajax/ajax/addcontent';
elblogdeseloAjax=Class.create();
elblogdeseloAjax.prototype=
	{
		initialize: function(url, params) {
		    this.url = url;
		    this.params = params;
		    this.updateElementId = null;
		    this.messageUrl = SP_AJAXIFY_MESSAGE_URL;
		    
		    this.messageContainerId = 'sp_ajaxify_message';
		    this.loaderId = 'sp-loading';
		    
		  },
		//Definición de la clase en concreto
		//Propiedad para realizar una petición Ajax
		_requestAjax: function () {
		 	 new Ajax.Updater('output-div',this.url,{
		            method: 'get',
		            parameters: this.params,
		            onComplete: function(transport) {
		            	$('output-div').innerHTML = "";
		            	$('output-div').innerHTML = transport.responseText;
		            	Element.hide('loadingmask');
		            	}
		     });
		  },
		
	};



//Element.show('loadingmask');
//new Ajax.Request(loadContent, {
//method: 'post',
//parameters: "Params_Here",
//onComplete: function(transport) {
//Element.hide('loadingmask');
//$('output-div').innerHTML = "";
//$('output-div').innerHTML = transport.responseText;
// 
//}
//});