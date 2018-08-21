contentUrl = null;

function getContentUrl()
{
	return contentUrl;
}

function setContent(url)
{
	$.ajax({
		'type' : 'GET',
		'url' : url,
		'datatype' : 'html',
		'success' : function(data) {
			$('section.content').html(data);
			contentUrl = url;
		}
	});
}

function strToObj(str)
{
	return eval('function a(){return ' + str + ';}a();');
}

function doAjax(target, data, type, successCallback = function(rtn){}, errorCallback = function(rtn){})
{
	$.ajax({
		'url' : target,
		'type' : type,
		'data' : data,
		'dataType' : 'json',
		'success' : function(rtn) {
			successCallback(rtn);
		},
		'error' : function(rtn) {
			errorCallback(rtn.responseJSON);
		}
	});
}

function doConfirm(title, content, okButtonAction, cancelButtonAction = function(){})
{
	$.confirm({
		title: title,
		content: content,
		buttons: {
			'取消': function() {
				cancelButtonAction();
			},
			'确定': function() {
				okButtonAction();
			}
		}
	});
}

function doConfirmAjax(content, target, data, type, successCallback, errorCallback = function(rtn){$.alert(rtn.message, rtn.type);})
{
	doConfirm('确认', content, function(){
		doAjax(target, data, type, successCallback, errorCallback);
	});
}

$(document).ready(function() {
	$(document).on('click', '.ajax', function(event) {
		event.preventDefault();
		
		var object = $(this);
		var successCallback = $(this).attr('ajax-success-callback') ? $(this).attr('ajax-success-callback') : null;
		var errorCallback = $(this).attr('ajax-error-callback') ? $(this).attr('ajax-error-callback') : null;
		var target = $(this).attr('ajax-target');
		var type = $(this).attr('ajax-type') ? $(this).attr('ajax-type') : 'POST';
		var data = null;
		if($(this).attr('ajax-data'))
		{
			data = strToObj($(this).attr('ajax-data'));
		}
		else if($(this).attr('ajax-form'))
		{
			data = $($(this).attr('ajax-form')).serialize();
		}

		if(successCallback && errorCallback == null)
		{
			doAjax(target, data, type, function(rtn) {
				eval(successCallback);
			}, function(rtn) {
				$.alert(rtn.message, rtn.type);
			});
		}
		else if(successCallback && errorCallback != null)
		{
			doAjax(target, data, type, function(rtn) {
				eval(successCallback);
			}, function(rtn) {
				eval(errorCallback);
			});
		}
	});
});

$(document).ready(function() {
	$(document).on('click', '.confirm-ajax', function(event) {
		event.preventDefault();

		var object = $(this);
		var ajaxSuccess = $(this).attr('ajax-success-callback') ? $(this).attr('ajax-success-callback') : null;
		var ajaxError = $(this).attr('ajax-error-callback') ? $(this).attr('ajax-error-callback') : null;
		var target = $(this).attr('ajax-target');
		var type = $(this).attr('ajax-type') ? $(this).attr('ajax-type') : 'POST';
		var data = null;
		if($(this).attr('ajax-data'))
		{
			data = strToObj($(this).attr('ajax-data'));
		}
		else if($(this).attr('ajax-form'))
		{
			data = $($(this).attr('ajax-form')).serialize();
		}
		
		if((!data || !target) && !($(this).attr('ajax-force')))
		{
			$.alert('没有数据','提示');
			return;
		}

		if($($(this).attr('ajax-form')).attr('ajax-form-csrf'))
		{
			data += '&_token=' + $($(this).attr('ajax-form')).attr('ajax-form-csrf');
		}

		var content = $(this).attr('confirm-info');
		if(ajaxSuccess && ajaxError == null)
		{
			doConfirmAjax(content, target, data, type, function(rtn) {
				eval(ajaxSuccess);
			}, function(rtn) {
				$.alert(rtn.message, rtn.type);
			});
		}
		else if(ajaxSuccess && ajaxError != null)
		{
			doConfirmAjax(content, target, data, type, function(rtn) {
				eval(ajaxSuccess);
			}, function(rtn) {
				eval(ajaxError);
			});
		}
	});
});


$(document).ready(function() {
	$(document).on('click', '#btSelectAll', function() {
		var checkbox = $('tr').find(':checkbox');
		checkbox.prop('checked', $(this).prop('checked'));
	});
});

$(document).ready(function() {
	$(document).on('click', 'a.content-link', function(event) {
		event.preventDefault();
		var url = $(this).attr('href');
		if(url == '#' || url == '') return;
		setContent(url);
	});
});

