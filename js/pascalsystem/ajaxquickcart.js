PS.AjaxQuickCart = {
	initView : function(selector, url){
		PS.onload(function(){
			var els = $$(selector);
			for (var i=0;i<els.length;i++) {
				els[i]._ajaxUrl = url;
				els[i].onclick = PS.AjaxQuickCart.clickViewCart;
			}
		});
	},
	initQuick : function(conf){
		PS.onload(function(){
			var els;
			var i;
			els = $$(conf.single.selector);
			for (i=0;i<els.length;i++) {
				if (typeof els[i]._psquick != 'undefined')
					continue;
				els[i]._psquick = new PS.AjaxQuickCart.AddToCart(els[i], 'single', conf);
			}
			els = $$(conf.list.selector);
			for (i=0;i<els.length;i++) {
				if (typeof els[i]._psquick != 'undefined')
					continue;
				els[i]._psquick = new PS.AjaxQuickCart.AddToCart(els[i], 'list', conf);
			}
		});
	},
	initLayerQuick : function(selector) {
		var els = $$(selector);
		var conf = {'single':{'selector':selector}};
		for (var i=0;i<els.length;i++) {
			if (typeof els[i]._psquick != 'undefined')
				continue;
			els[i]._psquick = new PS.AjaxQuickCart.AddToCart(els[i], 'single', conf);
		}
	},
	refresh : function(url) {
		if (PS.AjaxQuickCart._fixDoubleRefresh)
			return;
		PS.AjaxQuickCart._fixDoubleRefresh = true;
		PS.ajax.call(url,{});
		setTimeout(function(){PS.AjaxQuickCart._fixDoubleRefresh=false;},100);
	},
	clickViewCart : function() {
		if (typeof this._ajaxUrl == 'undefined')
			return true;
		PS.layer.ajax(this._ajaxUrl, {'content':'content'});
		return false;
	}
}
PS.AjaxQuickCart.AddToCart = function(el, type, conf) {
	if (typeof el.onclick == 'function') {
		el._orginalStringOnClick = el.getAttribute('onclick');
		if (typeof el._orginalStringOnClick == 'function')
			el._orginalStringOnClick = el._orginalStringOnClick.toString();
		el._psajaxonclick = el.onclick;
	}
	el.onclick = function() {
		if (this._psquick.actionClick())
			return false;
		return el._psajaxonclick();
	}
	this._element = el;
	this._type = type;
	this._conf = conf;
}
PS.AjaxQuickCart.AddToCart.prototype.actionClick = function() {
	if (this._type == 'single') {
		return this.actionClickSingle();
	}
	var url = this.getUrl();
	if (!url)
		return false;
	PS.layer.ajax(url, {'content':'content'});
	return true;
}
PS.AjaxQuickCart.AddToCart.submitAddProductToLayer = function() {
	var form = document.getElementById('product_addtocart_form');
	if (!form) {
		return this._psajaxquickcart();
	}
	var varienForm = new VarienForm('product_addtocart_form');
	
	if (!varienForm.validator.validate())
		return false;
	
	var methodSend = form.getAttribute('method');
	var url = form.getAttribute('action');
	var els = Form.getElements(form);
	
	var postData = '';
	for (var i=0;i<els.length;i++) {
		if (postData)
			postData+='&';
		if (els[i].disabled)
			continue;
		if (!els[i].name)
			continue;
		postData+= els[i].name.toString()+'='+els[i].value.toString();
	}
	url+= (url.indexOf('?')<0)?'?':'&';
	url+= postData;
	if (typeof PS.layer.manager.content != 'undefined') {
		PS.layer.manager.close();
	}
	PS.layer.ajax(url, {'content':'content'});
	return false;
}
PS.AjaxQuickCart.AddToCart.prototype.actionClickSingle = function() {
	if (typeof productAddToCartForm == 'undefined') {
		PS.AjaxQuickCart.AddToCart.submitAddProductToLayer();
		return false;
	}
	if (typeof productAddToCartForm._psajaxquickcart != 'undefined') {
		productAddToCartForm.submit();
		return true;
	}
	productAddToCartForm._psajaxquickcart = productAddToCartForm.submit;
	productAddToCartForm.submit = PS.AjaxQuickCart.AddToCart.submitAddProductToLayer;
	productAddToCartForm.submit();
	return true;
}
PS.AjaxQuickCart.AddToCart.prototype.getUrl = function() {
	if (typeof this._url == 'undefined') {
		var att = this._element._orginalStringOnClick;
		if (att) {
			if (this._conf[this._type].match) {
				this._url = false;
				var splitData = this._conf[this._type].match.toString().split('###URL###');
				if (splitData.length == 2) {
					var parts = att.toString().split(splitData[0]);
					if (parts.length>1) {
						var lastParts = parts[1].toString().split(splitData[1]);
						var lastUrlPart = lastParts[0].toString();
						if (lastUrlPart) {
							this._url = lastUrlPart;
						}
					}
				}
			} else {
				this._url = att;
			}
		} else {
			this._url = false;
		}
		this._url = this._url.toString();
		if (this._url.indexOf('?') < 0)
			this._url+= '?';
		else
			this._url+= '&';
		this._url+= 'ajaxquickcartoption=1';
	}
	return this._url;
}
PS.AjaxQuickCart._fixDoubleRefresh = false;