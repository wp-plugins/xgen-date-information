jQuery(document).ready(function(){
	var order_by_param 	= getParameterByName('orderby');
	var order_param 	= getParameterByName('order');
	if(order_by_param == 'name' &&  order_param == 'asc')
	{
		jQuery('.column-name').html('Plugin <a href="?orderby=name&order=desc"><div class="arrow-down" style="margin-top: 7px;"></div></a>');
	}
	else if(order_by_param == 'name' &&  order_param == 'desc')
	{
		jQuery('.column-name').html('Plugin <a href="?orderby=name&order=asc"><div class="arrow-up" style="margin-top: -4px;"></div></a>');
	}
	else
	{
		jQuery('.column-name').html('Plugin <a href="?orderby=name&order=desc"><div class="arrow-down" style="margin-top: 7px;"></div></a>');
	}
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}